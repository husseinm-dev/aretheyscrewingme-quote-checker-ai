<?php

declare(strict_types=1);

namespace QuoteCheck;

use RuntimeException;
use Smalot\PdfParser\Parser;

class QuoteAnalyzer
{
    public function __construct(
        private OpenAIService $openAI, 
        private PricingEngine $pricing
    ) {
    }

    public function extractText(?array $uploadedFile, ?string $pastedText): array
    {
        $text = trim((string) $pastedText);
        $storedPath = null;
        $originalName = null;

        if ($uploadedFile && !empty($uploadedFile['tmp_name']) && (int) $uploadedFile['error'] === UPLOAD_ERR_OK) {
            $originalName = (string)($uploadedFile['name'] ?? 'quote');
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed = cfg('security.allowed_extensions', ['pdf','png','jpg','jpeg','webp','txt']);
            if (!in_array($ext, $allowed, true)) {
                throw new RuntimeException('Unsupported file type. Please use PDF, PNG, JPG, WEBP, or TXT.');
            }

            $maxBytes = ((int)cfg('security.max_upload_mb', 8)) * 1024 * 1024;
            if ((int)($uploadedFile['size'] ?? 0) > $maxBytes) {
                throw new RuntimeException('That file is too large. Keep uploads under ' . (int)cfg('security.max_upload_mb', 8) . 'MB.');
            }

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = (string)$finfo->file($uploadedFile['tmp_name']);
            $allowedMimes = [
                'pdf' => ['application/pdf'],
                'png' => ['image/png'],
                'jpg' => ['image/jpeg'],
                'jpeg' => ['image/jpeg'],
                'webp' => ['image/webp'],
                'txt' => ['text/plain', 'application/octet-stream'],
            ];
            if (!in_array($mime, $allowedMimes[$ext] ?? [], true)) {
                throw new RuntimeException('The uploaded file type did not match the file contents.');
            }

            $safeName = bin2hex(random_bytes(16)) . '.' . $ext;
            $dir = dirname(__DIR__) . '/storage/uploads';
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
            $storedPath = $dir . '/' . $safeName;
            if (!move_uploaded_file($uploadedFile['tmp_name'], $storedPath)) {
                throw new RuntimeException('Could not save the uploaded file.');
            }

            if ($ext === 'txt') {
                $text .= "\n" . (string)file_get_contents($storedPath);
            } elseif ($ext === 'pdf') {
                try {
                    $parser = new Parser();
                    $pdf = $parser->parseFile($storedPath);
                    $text .= "\n" . $pdf->getText();
                } catch (\Throwable $e) {
                    Helpers::logThrowable($e);
                    throw new RuntimeException('Could not parse that PDF. Try a text-based PDF or paste the quote text.');
                }
            } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'webp'], true)) {
                $text .= "\n" . $this->openAI->visionExtract($storedPath);
            }
        }

        $text = trim((string)preg_replace('/\s+/', ' ', $text));

        if ($text === '') {
            throw new RuntimeException('No readable text was found. Paste the quote text or upload a clearer file.');
        }

        return [
            'text' => $text,
            'stored_path' => $storedPath,
            'original_name' => $originalName,
        ];
    }

    public function run(string $quoteText, string $category, string $zipCode): array
    {
        $ai = $this->openAI->analyze($quoteText, $category, $zipCode);
        $quotedPrice = (float) ($ai['quoted_price'] ?? 0);

        if ($quotedPrice <= 0) {
            if (preg_match_all('/\$?([0-9]{1,3}(?:,[0-9]{3})*(?:\.[0-9]{2})?)/', $quoteText, $matches)) {
                $numbers = array_map(fn($n) => (float) str_replace(',', '', $n), $matches[1]);
                $quotedPrice = max($numbers);
            }
        }

        // Get AI-provided market pricing
        $fairLow = (float) ($ai['fair_low'] ?? 0);
        $fairHigh = (float) ($ai['fair_high'] ?? 0);
        
        $unitAnalysis = null;
        $serviceLabel = $ai['service_label'] ?? ucfirst($category) . ' quote';
        $score = 50;
        $status = 'Needs review';
        $overPct = 0;
        
        // Check if AI provided line item breakdown
        if (!empty($ai['line_items']) && is_array($ai['line_items'])) {
            // Multi-item quote with unit pricing analysis
            $unitAnalysis = [];
            
            foreach ($ai['line_items'] as $item) {
                $name = (string)($item['name'] ?? '');
                $quantity = (float)($item['quantity'] ?? 1);
                $unitPrice = (float)($item['unit_price'] ?? 0);
                $typicalLow = (float)($item['typical_low'] ?? 0);
                $typicalHigh = (float)($item['typical_high'] ?? 0);
                
                // Determine status based on AI-provided market ranges
                $status = 'unknown';
                if ($typicalHigh > 0 && $unitPrice > 0) {
                    if ($unitPrice < $typicalLow) {
                        $status = 'below_market';
                    } elseif ($unitPrice <= $typicalHigh) {
                        $status = 'fair';
                    } else {
                        // Calculate how much over market this is
                        $overMarketRatio = ($unitPrice - $typicalHigh) / $typicalHigh;
                        
                        if ($overMarketRatio <= 0.3) {
                            $status = 'expensive';
                        } elseif ($overMarketRatio <= 0.75) {
                            $status = 'red_flag';
                        } else {
                            $status = 'red_flag';
                        }
                    }
                }
                
                $unitAnalysis[] = [
                    'name' => $name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'typical_low' => $typicalLow,
                    'typical_high' => $typicalHigh,
                    'status' => $status,
                ];
            }
            
            // Calculate avg over-market percentage
            $overMarketSum = 0;
            $validItems = 0;
            foreach ($unitAnalysis as $item) {
                if ($item['typical_high'] > 0 && $item['unit_price'] > 0) {
                    $itemOverPct = (($item['unit_price'] - $item['typical_high']) / $item['typical_high']) * 100;
                    $overMarketSum += max(0, $itemOverPct);
                    $validItems++;
                }
            }
            $overPct = $validItems > 0 ? round($overMarketSum / $validItems) : 0;
            
            // Score based on TOTAL over-market percentage, not per-item penalties
            if ($fairHigh > 0 && $quotedPrice > 0) {
                // Use total quote vs total market range for accurate scoring
                [$score, $status, $totalOverPct] = $this->score($quotedPrice, $fairLow, $fairHigh);
                // Prefer the calculated total over-market if it's more accurate
                if ($totalOverPct > 0) {
                    $overPct = $totalOverPct;
                }
            } else {
                // Fallback: score based on average item over-market percentage
                $score = max(8, 82 - (int)round($overPct * 1.1));
                if ($overPct >= 50) {
                    $status = 'Major red flag';
                } elseif ($overPct >= 20) {
                    $status = 'Expensive';
                } elseif ($overPct > 0) {
                    $status = 'Slightly high';
                } else {
                    $status = 'Fair';
                }
            }
            
        } else {
            // Single-service quote - use AI-provided total range
            if ($fairHigh > 0) {
                [$score, $status, $overPct] = $this->score($quotedPrice, $fairLow, $fairHigh);
            } else {
                // Fallback to database if AI couldn't provide range
                $estimate = $this->pricing->estimate($category, 'unknown_service', $zipCode);
                $fairLow = $estimate['low'];
                $fairHigh = $estimate['high'];
                $serviceLabel = $estimate['label'] ?? $serviceLabel;
                [$score, $status, $overPct] = $this->score($quotedPrice, $fairLow, $fairHigh);
            }
        }

        $result = [
            'service_key' => 'ai_analysis',
            'service_label' => $serviceLabel,
            'quoted_price' => $quotedPrice,
            'fair_low' => $fairLow,
            'fair_high' => $fairHigh,
            'score' => $score,
            'status' => $status,
            'overpriced_percent' => $overPct,
            'summary' => $ai['summary'] ?? 'Analysis complete.',
            'red_flags' => array_values($ai['red_flags'] ?? []),
            'questions_to_ask' => array_values($ai['questions_to_ask'] ?? []),
            'reply_template' => $ai['reply_template'] ?? '',
            'notes' => $ai['notes'] ?? '',
            'confidence' => (float) ($ai['confidence'] ?? 0.65),
        ];
        
        // Add unit analysis if available
        if ($unitAnalysis !== null) {
            $result['unit_analysis'] = $unitAnalysis;
        }
        
        return $result;
    }

    private function score(float $quoted, float $low, float $high): array
    {
        if ($quoted <= 0 || $high <= 0) {
            return [50, 'Needs review', 0];
        }
        if ($quoted < $low) {
            return [90, 'Below market', -round((($low - $quoted) / $low) * 100)];
        }
        if ($quoted <= $high) {
            return [82, 'Fair', 0];
        }

        $overPct = round((($quoted - $high) / $high) * 100);
        $score = max(8, 82 - (int) round($overPct * 1.1));
        $status = $overPct >= 50 ? 'Major red flag' : ($overPct >= 20 ? 'Expensive' : 'Slightly high');
        return [$score, $status, $overPct];
    }
}
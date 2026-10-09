<?php

declare(strict_types=1);

namespace QuoteCheck;

use RuntimeException;

class OpenAIService
{
    public function __construct(private string $apiKey, private string $model) 
    {
    }

    // public function analyze(string $quoteText, string $category, string $zipCode, array $pricingEstimate): array
    public function analyze(string $quoteText, string $category, string $zipCode): array
    {
        $serviceKeys = [
            'mechanic' => ['brake_pads','rotors','alternator','starter','oil_change','battery_replacement','ac_recharge','unknown_service'],
            'plumber' => ['drain_cleaning','toilet_install','faucet_replace','water_heater_replace','pipe_repair','unknown_service'],
            'electrician' => ['outlet_replace','ceiling_fan_install','breaker_panel_work','lighting_install','unknown_service'],
            'hvac' => ['ac_tuneup','furnace_repair','thermostat_replace','capacitor_replace','duct_cleaning','unknown_service'],
            'landscaper' => ['lawn_cutting','mulch_install','spring_cleanup','tree_trim','sod_install','unknown_service'],
            'roofer' => ['roof_patch','roof_replace','gutter_repair','shingle_repair','unknown_service'],
            'contractor' => ['interior_painting','drywall_patch','fixture_install','tile_repair','general_handyman','unknown_service'],
            'moving' => ['local_move_studio','local_move_2br','local_move_3br','junk_removal','unknown_service'],
            'appliance' => ['dishwasher_repair','washer_repair','dryer_repair','fridge_repair','unknown_service'],
            'pest' => ['general_treatment','termite_treatment','bed_bug_treatment','rodent_control','unknown_service'],
        ];

        $allowed = implode(', ', $serviceKeys[$category] ?? ['unknown_service']);
        // $system = 'You are a consumer quote analyst. Return valid JSON only with keys: service_key, service_label, quoted_price, confidence, summary, red_flags (array), questions_to_ask (array), reply_template, notes. Use concise plain English. Infer the likely service_key from the quote text using only one of these values: ' . $allowed . '. quoted_price should be numeric.';

        $system = '
            You are an expert quote analyst. Provide accurate market pricing intelligence for ALL quotes.

            Return JSON with these keys:

            service_label (required: brief description)
            quoted_price (required: total price as number)
            fair_low (required: low end of fair market range for this ZIP code)
            fair_high (required: high end of fair market range for this ZIP code)
            line_items (optional: array for multi-item quotes)
            summary (required: 2-3 sentence analysis)
            red_flags (required: array of specific concerns)
            questions_to_ask (required: array of 3-5 good questions)
            reply_template (required: polite pushback message)
            confidence (required: 0-1)

            CRITICAL PRICING REQUIREMENTS:
            - ALWAYS provide fair_low and fair_high based on 2026 market rates for the service
            - Consider location (ZIP code), complexity, and industry standards
            - These should be realistic ranges a consumer could expect to pay elsewhere
            - For single-service quotes: provide total price range (e.g., oil change: $40-$80)
            - For multi-item quotes: also break down line_items with unit pricing

            LINE ITEMS FORMAT (for multi-item quotes):
            [
                {
                    "name": "Brake pads front and rear",
                    "quantity": 1,
                    "unit_price": 280,
                    "typical_low": 200,
                    "typical_high": 350
                }
            ]

            EXAMPLES:
            - Oil change quote $530: fair_low: 40, fair_high: 80
            - Faucet replacement $85: fair_low: 150, fair_high: 300
            - Brake job $450: fair_low: 300, fair_high: 500

            Be accurate and help consumers identify overpricing.
            ';


        // $user = "Category: {$category}\nZIP: {$zipCode}\nEstimated fair range: {$pricingEstimate['low']} - {$pricingEstimate['high']}\nQuote text:\n{$quoteText}";

        $user = "Category: {$category}\nZIP: {$zipCode}\n\nQuote text:\n{$quoteText}";




        $payload = [
            'model' => $this->model,
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $user],
            ],
            'temperature' => 0,
            'max_tokens' => 1500,
        ];

        $response = $this->request('https://api.openai.com/v1/chat/completions', $payload);
        $content = $response['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new RuntimeException('No analysis returned from OpenAI.');
        }

        $decoded = json_decode($content, true);
        if (!is_array($decoded)) {
            throw new RuntimeException('Invalid JSON returned from OpenAI.');
        }

        return $decoded;
    }

    public function visionExtract(string $absoluteImagePath): string
    {
        $mime = mime_content_type($absoluteImagePath) ?: 'image/jpeg';
        $base64 = base64_encode(file_get_contents($absoluteImagePath));

        $payload = [
            'model' => $this->model,
            'messages' => [[
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'Extract all readable text from this quote image. Return plain text only.'],
                    ['type' => 'image_url', 'image_url' => ['url' => 'data:' . $mime . ';base64,' . $base64]],
                ],
            ]],
            'temperature' => 0,
            'max_tokens' => 1500,
        ];

        $response = $this->request('https://api.openai.com/v1/chat/completions', $payload);
        return trim((string) ($response['choices'][0]['message']['content'] ?? ''));
    }

    private function request(string $url, array $payload): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 90,
        ]);

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($raw === false || $status >= 400) {
            throw new RuntimeException('OpenAI request failed: ' . ($error ?: $raw ?: 'Unknown error'));
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            throw new RuntimeException('Could not decode OpenAI response.');
        }

        return $decoded;
    }
}
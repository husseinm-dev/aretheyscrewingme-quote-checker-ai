<?php

declare(strict_types=1);

namespace QuoteCheck;

class UnitPricingEngine
{
    private array $ranges = [
        // Electrical
        'recessed lights' => [70, 120],
        'recessed light' => [70, 120],
        'can lights' => [70, 120],
        'outlets' => [50, 90],
        'outlet' => [50, 90],
        'receptacle' => [50, 90],
        'receptacles' => [50, 90],
        'gfi circuits' => [90, 180],
        'gfi circuit' => [90, 180],
        'gfci' => [90, 180],
        'gfci outlet' => [90, 180],
        'arc fault circuits' => [60, 120],
        'arc fault circuit' => [60, 120],
        'afci' => [60, 120],
        'ceiling fans install' => [150, 350],
        'ceiling fan' => [150, 350],
        'bath fans install' => [200, 400],
        'bath fan' => [200, 400],
        'exhaust fan' => [200, 400], 
        'smoke alarms' => [70, 150],
        'smoke alarm' => [70, 150],
        'smoke detector' => [70, 150],
        'combo alarms' => [90, 200],
        'combo alarm' => [90, 200],
        'hvac electrical hookup' => [500, 1200],
        '300 amp service' => [3000, 5000],
        '200 amp service' => [2000, 3500],
        '100 amp service' => [1200, 2000],
        'electrical panel' => [1500, 3000],
        'breaker panel' => [1500, 3000],
        'sub panel' => [800, 1500],
        'light switch' => [45, 85],
        'switches' => [45, 85],
        'dimmer switch' => [65, 110],
        'three way switch' => [75, 130],
        
        // Plumbing
        'toilet install' => [200, 450],
        'toilet' => [200, 450],
        'faucet install' => [150, 300],
        'faucet' => [150, 300],
        'sink install' => [250, 500],
        'sink' => [250, 500],
        'garbage disposal' => [200, 400],
        'water heater' => [1200, 2500],
        'tankless water heater' => [2000, 4000],
        'pipe repair' => [150, 400],
        'drain cleaning' => [150, 350],
        'shut off valve' => [120, 250],
        'angle stop' => [80, 150],
        
        // HVAC
        'ac unit' => [3000, 7000],
        'furnace' => [2500, 6000],
        'heat pump' => [4000, 8000],
        'thermostat' => [150, 400],
        'ductwork per linear foot' => [15, 35],
        'register' => [40, 80],
        'return vent' => [60, 120],
        
        // Roofing
        'shingles per square' => [90, 180],
        'roof square' => [300, 600],
        'ridge vent' => [200, 400],
        'soffit vent' => [100, 250],
        'gutter per linear foot' => [8, 18],
        'downspout' => [80, 150],
        
        // General contractor
        'drywall per sheet' => [40, 80],
        'paint per square foot' => [2, 5],
        'flooring per square foot' => [5, 15],
        'tile per square foot' => [8, 25],
        'trim per linear foot' => [4, 10],
        'door install' => [200, 500],
        'window install' => [300, 800],
        'cabinet install per linear foot' => [100, 300],
        'countertop per square foot' => [40, 150],
        
        // Landscaping
        'sod per square foot' => [0.35, 0.85],
        'mulch per cubic yard' => [35, 80],
        'tree removal' => [500, 2000],
        'fence per linear foot' => [15, 40],
        'deck per square foot' => [25, 50],
        'patio per square foot' => [12, 30],
    ];

    public function getRange(string $itemName): array
    {
        $normalized = strtolower(trim($itemName));
        
        // Try exact match first
        if (isset($this->ranges[$normalized])) {
            return $this->ranges[$normalized];
        }
        
        // Try fuzzy matching by looking for keywords
        foreach ($this->ranges as $key => $range) {
            // Check if the item name contains the key or vice versa
            if (
                str_contains($normalized, $key) || 
                str_contains($key, $normalized)
            ) {
                return $range;
            }
        }
        
        // No match found
        return [0, 0];
    }

    public function analyzeLineItem(array $item): array
    {
        $name = (string)($item['name'] ?? '');
        $quantity = (float)($item['quantity'] ?? 1);
        $unitPrice = (float)($item['unit_price'] ?? 0);
        
        $range = $this->getRange($name);
        $typicalLow = $range[0];
        $typicalHigh = $range[1];
        
        // Determine status
        $status = 'unknown';
        if ($typicalHigh > 0) {
            if ($unitPrice < $typicalLow) {
                $status = 'below_market';
            } elseif ($unitPrice <= $typicalHigh) {
                $status = 'fair';
            } elseif ($unitPrice <= $typicalHigh * 1.5) {
                $status = 'expensive';
            } else {
                $status = 'red_flag';
            }
        }
        
        return [
            'name' => $name,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'typical_low' => $typicalLow,
            'typical_high' => $typicalHigh,
            'status' => $status,
        ];
    }

    public function calculateScore(array $lineItems): array
    {
        $score = 80;
        $statusCounts = [
            'below_market' => 0,
            'fair' => 0,
            'expensive' => 0,
            'red_flag' => 0,
            'unknown' => 0,
        ];
        
        foreach ($lineItems as $item) {
            $status = $item['status'] ?? 'unknown';
            $statusCounts[$status]++;
            
            switch ($status) {
                case 'below_market':
                    $score += 3;
                    break;
                case 'fair':
                    // No change
                    break;
                case 'expensive':
                    $score -= 5;
                    break;
                case 'red_flag':
                    $score -= 10;
                    break;
                case 'unknown':
                    $score -= 2;
                    break;
            }
        }
        
        // Clamp score between 0 and 100
        $score = max(0, min(100, $score));
        
        // Determine overall status
        if ($score >= 80) {
            $status = 'Fair';
        } elseif ($score >= 60) {
            $status = 'Slightly high';
        } elseif ($score >= 40) {
            $status = 'Expensive';
        } else {
            $status = 'Major red flag';
        }
        
        return [
            'score' => $score,
            'status' => $status,
            'status_counts' => $statusCounts,
        ];
    }
}
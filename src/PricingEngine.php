<?php

declare(strict_types=1);

namespace QuoteCheck;

use PDO;

class PricingEngine
{
    public function __construct(private PDO $pdo)
    {
    }

    public function estimate(string $category, string $serviceKey, string $zipCode = ''): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM pricing_reference WHERE category = :category AND service_key = :service_key LIMIT 1');
        $stmt->execute([
            'category' => $category,
            'service_key' => $serviceKey,
        ]);
        $row = $stmt->fetch();

        if (!$row) {
            return [
                'low' => 0,
                'high' => 0,
                'multiplier' => 1,
                'label' => 'Unknown service',
            ];
        }

        $multiplier = $this->regionMultiplier($zipCode);

        return [
            'low' => round((float) $row['low_price'] * $multiplier, 2),
            'high' => round((float) $row['high_price'] * $multiplier, 2),
            'multiplier' => $multiplier,
            'label' => $row['label'],
        ];
    }

    private function regionMultiplier(string $zipCode): float
    {
        if (preg_match('/^(07|08)/', $zipCode)) {
            return 1.18;
        }
        if (preg_match('/^(10|11)/', $zipCode)) {
            return 1.25;
        }
        return 1.0;
    }
}

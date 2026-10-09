<?php

declare(strict_types=1);

namespace QuoteCheck;

use RuntimeException;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeService
{
    public function __construct(private array $config)
    {
        Stripe::setApiKey($this->config['secret_key']);
    }

    public function checkoutUrl(int $reportId, int $userId, string $successUrl, string $cancelUrl, string $mode = 'single'): string
    {
        if ($mode === 'pro') {
            if (empty($this->config['monthly_subscription_price_id']) || $this->config['monthly_subscription_price_id'] === 'price_replace_me') {
                throw new RuntimeException('Set stripe.monthly_subscription_price_id in config/app.php before selling Pro subscriptions.');
            }

            $session = Session::create([
                'mode' => 'subscription',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $this->config['monthly_subscription_price_id'],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'report_id' => (string) $reportId,
                    'user_id' => (string) $userId,
                    'mode' => $mode,
                ],
                'subscription_data' => [
                    'metadata' => [
                        'report_id' => (string) $reportId,
                        'user_id' => (string) $userId,
                        'mode' => $mode,
                    ],
                ],
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);

            return $session->url;
        }

        $amount = $mode === 'pack3'
            ? (int) $this->config['pack_3_price_cents']
            : (int) $this->config['single_report_price_cents'];

        $name = $mode === 'pack3' ? 'Are They Screwing Me? - 3 Report Pack' : 'Are They Screwing Me? - Single Report Unlock';

        $session = Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->config['currency'],
                    'product_data' => ['name' => $name],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'report_id' => (string) $reportId,
                'user_id' => (string) $userId,
                'mode' => $mode,
            ],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);

        return $session->url;
    }

    public function constructEvent(string $payload, string $signature, string $secret): mixed
    {
        return Webhook::constructEvent($payload, $signature, $secret);
    }

    public function createCustomerPortalSession(string $customerId, string $returnUrl): string
    {
        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $customerId,
            'return_url' => $returnUrl,
        ]);

        return $session->url;
    }
}

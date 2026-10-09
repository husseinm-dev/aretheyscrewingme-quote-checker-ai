<?php
use QuoteCheck\StripeService;
require_once __DIR__ . '/../config/bootstrap.php';

// Log all webhook attempts
$logFile = __DIR__ . '/../storage/webhook.log';
$logMsg = date('Y-m-d H:i:s') . " - Webhook called\n";
@file_put_contents($logFile, $logMsg, FILE_APPEND);

error_log("🔔 Webhook called: " . date('Y-m-d H:i:s'));

$payload = @file_get_contents('php://input') ?: '';
$sig = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

error_log("📦 Webhook payload length: " . strlen($payload));
error_log("📝 Webhook signature present: " . ($sig ? 'yes' : 'no'));

try {
    $stripe = new StripeService(cfg('stripe'));
    $event = $stripe->constructEvent($payload, $sig, cfg('stripe.webhook_secret'));
    
    error_log("✅ Webhook verified - Event type: {$event->type}");

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;
        $reportId = (int)($session->metadata->report_id ?? 0);
        $userId = (int)($session->metadata->user_id ?? 0);
        $mode = (string)($session->metadata->mode ?? 'single');
        
        error_log("💰 Purchase completed - User ID: {$userId}, Mode: {$mode}, Report ID: {$reportId}");
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " - Purchase: User {$userId}, Mode: {$mode}\n", FILE_APPEND);

        if ($mode === 'pro') {
            $credits = (int) cfg('stripe.monthly_subscription_report_credits', 15);
            $pdo->prepare('UPDATE users SET paid_credits_remaining = paid_credits_remaining + :credits, stripe_customer_id = :customer_id, stripe_subscription_id = :subscription_id, subscription_status = :subscription_status, subscription_plan = :subscription_plan WHERE id = :id')->execute([
                'credits' => $credits,
                'customer_id' => (string)($session->customer ?? ''),
                'subscription_id' => (string)($session->subscription ?? ''),
                'subscription_status' => 'active',
                'subscription_plan' => 'pro',
                'id' => $userId,
            ]);
            error_log("✅ Added {$credits} credits to user {$userId} (subscription)");
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " - Added {$credits} credits (subscription)\n", FILE_APPEND);
        } else {
            $credits = $mode === 'pack3' ? 3 : 1;
            $pdo->prepare('UPDATE users SET paid_credits_remaining = paid_credits_remaining + :credits WHERE id = :id')->execute(['credits' => $credits, 'id' => $userId]);
            error_log("✅ Added {$credits} credits to user {$userId} (one-time purchase)");
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " - Added {$credits} credits to user {$userId} ({$mode})\n", FILE_APPEND);
        }

        $pdo->prepare('INSERT INTO payments (user_id, report_id, stripe_session_id, amount_cents, status, purchase_mode) VALUES (:user_id, :report_id, :stripe_session_id, :amount_cents, :status, :purchase_mode) ON DUPLICATE KEY UPDATE status = VALUES(status)')->execute([
            'user_id' => $userId,
            'report_id' => $reportId,
            'stripe_session_id' => (string)$session->id,
            'amount_cents' => (int)($session->amount_total ?? 0),
            'status' => 'paid',
            'purchase_mode' => $mode,
        ]);
        
        error_log("✅ Payment record created for session: {$session->id}");
    }

    if ($event->type === 'invoice.paid') {
        $invoice = $event->data->object;
        $subscriptionId = (string)($invoice->subscription ?? '');
        if ($subscriptionId !== '') {
            $credits = (int) cfg('stripe.monthly_subscription_report_credits', 15);
            $pdo->prepare('UPDATE users SET paid_credits_remaining = paid_credits_remaining + :credits, subscription_status = :status WHERE stripe_subscription_id = :subscription_id')->execute([
                'credits' => $credits,
                'status' => 'active',
                'subscription_id' => $subscriptionId,
            ]);
            error_log("✅ Subscription renewal processed for: {$subscriptionId}");
        }
    }

    if ($event->type === 'customer.subscription.deleted') {
        $subscription = $event->data->object;
        $subscriptionId = (string)($subscription->id ?? '');
        if ($subscriptionId !== '') {
            $pdo->prepare('UPDATE users SET subscription_status = :status WHERE stripe_subscription_id = :subscription_id')->execute([
                'status' => 'canceled',
                'subscription_id' => $subscriptionId,
            ]);
            error_log("✅ Subscription canceled for: {$subscriptionId}");
        }
    }

    http_response_code(200);
    echo 'ok';
} catch (Throwable $e) {
    error_log("❌ Webhook error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(400);
    echo 'invalid';
}

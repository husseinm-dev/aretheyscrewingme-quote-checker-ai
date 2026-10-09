<?php
use QuoteCheck\StripeService;
require_once __DIR__ . '/../config/bootstrap.php';

require_login();
$user = $auth->user();

// Only allow access if user has an active subscription
if (!subscription_is_active($user) || empty($user['stripe_customer_id'])) {
    set_flash('error', 'You need an active Pro subscription to access billing management.');
    redirect('/dashboard');
}

$stripe = new StripeService(cfg('stripe'));
$returnUrl = rtrim(cfg('base_url'), '/') . '/dashboard';

try {
    $portalUrl = $stripe->createCustomerPortalSession($user['stripe_customer_id'], $returnUrl);
    redirect($portalUrl);
} catch (Throwable $e) {
    error_log("Billing portal error: " . $e->getMessage());
    set_flash('error', 'Unable to access billing portal. Please contact support.');
    redirect('/dashboard');
}

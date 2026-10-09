<?php
// Copy this file to config/app.php and fill in your own values.
// Never commit config/app.php — it is gitignored.
return [
    'app_name' => 'Are They Screwing Me?',
    'brand_domain' => 'yourdomain.com',
    'base_url' => 'https://yourdomain.com/',
    'session_name' => 'atsm_session',
    // Generate with: openssl rand -base64 32
    'app_key' => 'change-this-to-a-long-random-secret-key',

    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'your_database_name',
        'username' => 'your_database_user',
        'password' => 'your_database_password',
        'charset' => 'utf8mb4',
    ],

    'openai' => [
        'api_key' => 'sk-your-openai-api-key',
        'model' => 'gpt-4.1-mini',
    ],

    'stripe' => [
        // Use test keys (sk_test_/pk_test_) in development, live keys in production.
        'secret_key' => 'sk_test_your-stripe-secret-key',
        'publishable_key' => 'pk_test_your-stripe-publishable-key',
        'webhook_secret' => 'whsec_your-stripe-webhook-secret',
        'single_report_price_cents' => 499,
        'pack_3_price_cents' => 999,
        'monthly_subscription_price_id' => 'price_your-stripe-price-id',
        'monthly_subscription_report_credits' => 60,
        'currency' => 'usd',
    ],

    'trial' => [
        'free_credits' => 2,
        'cookie_name' => 'atsm_device',
        'cookie_days' => 365,
    ],

    'turnstile' => [
        'enabled' => false,
        'site_key' => '',
        'secret_key' => '',
    ],

    'security' => [
        'force_https' => true,
        'session_idle_minutes' => 60,
        'max_upload_mb' => 8,
        'allowed_extensions' => ['pdf', 'png', 'jpg', 'jpeg', 'webp', 'txt'],
        'analyze_limit_per_hour' => 12,
        'auth_limit_per_15m' => 8,
        'upload_limit_per_hour' => 20,
    ],
];

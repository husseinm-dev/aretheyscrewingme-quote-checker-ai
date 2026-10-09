<?php

declare(strict_types=1);

use QuoteCheck\Auth;
use QuoteCheck\Csrf;
use QuoteCheck\Database;
use QuoteCheck\Helpers;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/app.php';

if (!empty($config['security']['force_https']) && php_sapi_name() !== 'cli') {
    $httpsOff = empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if ($httpsOff && $host && !str_contains($host, 'localhost')) {
        header('Location: https://' . $host . ($_SERVER['REQUEST_URI'] ?? '/'), true, 301);
        exit;
    }
}

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
header("Content-Security-Policy: default-src 'self'; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self' 'unsafe-inline' https://challenges.cloudflare.com; connect-src 'self' https://api.stripe.com https://challenges.cloudflare.com; frame-src https://js.stripe.com https://hooks.stripe.com https://challenges.cloudflare.com; object-src 'none'; base-uri 'self'; form-action 'self' https://checkout.stripe.com;");

session_name($config['session_name']);
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
]);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = time();
    $_SESSION['last_active'] = time();
}

$idleLimit = (int)($config['security']['session_idle_minutes'] ?? 60) * 60;
if (!empty($_SESSION['last_active']) && (time() - (int)$_SESSION['last_active']) > $idleLimit) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_active'] = time();

date_default_timezone_set('America/New_York');

$db = new Database($config['db']);
$pdo = $db->pdo();
$auth = new Auth($pdo);
$csrf = new Csrf();

function cfg(string $key, mixed $default = null): mixed
{
    global $config;
    $parts = explode('.', $key);
    $value = $config;
    foreach ($parts as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function require_login(): void
{
    global $auth;
    if (!$auth->check()) {
        $_SESSION['flash']['error'] = 'Please log in first.';
        redirect('/login.php');
    }
}

function flash(?string $key = null): mixed
{
    if ($key === null) {
        $all = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $all;
    }
    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $value;
}

function set_flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function current_path(): string
{
    return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
}

function is_active(string $path): string
{
    return current_path() === $path ? 'active' : '';
}

function quote_categories(): array
{
    return [
        'mechanic' => 'Mechanic',
        'plumber' => 'Plumber',
        'electrician' => 'Electrician',
        'hvac' => 'HVAC',
        'landscaper' => 'Landscaper',
        'roofer' => 'Roofer',
        'contractor' => 'General contractor',
        'moving' => 'Moving company',
        'appliance' => 'Appliance repair',
        'pest' => 'Pest control',
    ];
}

function category_label(string $key): string
{
    $all = quote_categories();
    return $all[$key] ?? ucfirst(str_replace('_', ' ', $key));
}

function subscription_is_active(array $user): bool
{
    return !empty($user['subscription_status']) && in_array($user['subscription_status'], ['active', 'trialing'], true);
}

function reports_per_month_for_plan(string $plan): int
{
    return $plan === 'pro' ? (int) cfg('stripe.monthly_subscription_report_credits', 60) : 0;
}

function verify_turnstile_or_fail(?string $token): void
{
    if (!cfg('turnstile.enabled', false)) {
        return;
    }
    $turnstile = new \QuoteCheck\Turnstile(true, (string)cfg('turnstile.secret_key', ''));
    if (!$turnstile->verify($token)) {
        set_flash('error', 'Security check failed. Please try again.');
        redirect(current_path());
    }
}

function rate_limit_or_fail(string $action, int $limit, int $windowSeconds, ?int $userId = null): void
{
    global $pdo;
    $limiter = new \QuoteCheck\RateLimiter($pdo, (string)cfg('app_key'));
    if ($limiter->tooMany($action, $limit, $windowSeconds, $userId)) {
        set_flash('error', 'Too many attempts. Please wait a bit and try again.');
        redirect(current_path());
    }
}

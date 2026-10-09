<?php

declare(strict_types=1);

namespace QuoteCheck;

class Helpers
{
    public static function log(string $message): void
    {
        $dir = dirname(__DIR__) . '/storage/logs';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @file_put_contents($dir . '/app.log', '[' . date('c') . '] ' . $message . PHP_EOL, FILE_APPEND);
    }

    public static function logThrowable(\Throwable $e): void
    {
        self::log($e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
    }

    public static function clientIp(): string
    {
        $keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $value = explode(',', (string) $_SERVER[$key])[0];
                return trim($value);
            }
        }
        return '0.0.0.0';
    }

    public static function ipHash(string $appKey): string
    {
        return hash('sha256', self::clientIp() . '|' . $appKey);
    }

    public static function userAgentHash(string $appKey): string
    {
        return hash('sha256', (string) ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown') . '|' . $appKey);
    }

    public static function browserToken(string $cookieName, int $days): string
    {
        if (empty($_COOKIE[$cookieName])) {
            $token = bin2hex(random_bytes(24));
            setcookie($cookieName, $token, [
                'expires' => time() + (86400 * $days),
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
                'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
            ]);
            $_COOKIE[$cookieName] = $token;
        }
        return (string) $_COOKIE[$cookieName];
    }

    public static function browserTokenHash(string $cookieName, int $days, string $appKey): string
    {
        return hash('sha256', self::browserToken($cookieName, $days) . '|' . $appKey);
    }

    public static function money(?float $amount): string
    {
        return '$' . number_format((float) $amount, 2);
    }
}

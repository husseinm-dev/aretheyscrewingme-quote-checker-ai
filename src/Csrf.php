<?php

declare(strict_types=1);

namespace QuoteCheck;

class Csrf
{
    public function token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public function verify(?string $token): bool
    {
        return isset($_SESSION['_csrf']) && is_string($token) && hash_equals($_SESSION['_csrf'], $token);
    }
}

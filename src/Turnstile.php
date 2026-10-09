<?php

declare(strict_types=1);

namespace QuoteCheck;

class Turnstile
{
    public function __construct(private bool $enabled, private string $secretKey)
    {
    }

    public function verify(?string $token): bool
    {
        if (!$this->enabled) {
            return true;
        }

        if (!$token) {
            return false;
        }

        $payload = http_build_query([
            'secret' => $this->secretKey,
            'response' => $token,
            'remoteip' => Helpers::clientIp(),
        ]);

        $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_TIMEOUT => 20,
        ]);

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false || $status >= 400) {
            return false;
        }

        $decoded = json_decode((string) $raw, true);
        return is_array($decoded) && !empty($decoded['success']);
    }
}

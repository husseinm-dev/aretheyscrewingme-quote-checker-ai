<?php

declare(strict_types=1);

namespace QuoteCheck;

use PDO;

class RateLimiter
{
    public function __construct(private PDO $pdo, private string $appKey)
    {
    }

    public function tooMany(string $action, int $limit, int $windowSeconds, ?int $userId = null): bool
    {
        $this->prune($windowSeconds);

        $fingerprint = hash('sha256', implode('|', [
            $action,
            Helpers::clientIp(),
            (string) ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'),
            (string) ($_COOKIE[cfg('trial.cookie_name', 'atsm_device')] ?? 'no-cookie'),
            (string) $userId,
            $this->appKey,
        ]));

        $insert = $this->pdo->prepare('INSERT INTO request_events (action_name, fingerprint_hash, user_id, created_at) VALUES (:action_name, :fingerprint_hash, :user_id, NOW())');
        $insert->execute([
            'action_name' => $action,
            'fingerprint_hash' => $fingerprint,
            'user_id' => $userId,
        ]);

        $countStmt = $this->pdo->prepare('SELECT COUNT(*) FROM request_events WHERE action_name = :action_name AND fingerprint_hash = :fingerprint_hash AND created_at >= (NOW() - INTERVAL :seconds SECOND)');
        $countStmt->bindValue(':action_name', $action);
        $countStmt->bindValue(':fingerprint_hash', $fingerprint);
        $countStmt->bindValue(':seconds', $windowSeconds, PDO::PARAM_INT);
        $countStmt->execute();

        return (int) $countStmt->fetchColumn() > $limit;
    }

    public function tooManyByIp(string $action, int $limit, int $windowSeconds): bool
    {
        $this->prune($windowSeconds);
        $fingerprint = hash('sha256', implode('|', [$action, Helpers::clientIp(), $this->appKey]));

        $insert = $this->pdo->prepare('INSERT INTO request_events (action_name, fingerprint_hash, created_at) VALUES (:action_name, :fingerprint_hash, NOW())');
        $insert->execute([
            'action_name' => $action,
            'fingerprint_hash' => $fingerprint,
        ]);

        $countStmt = $this->pdo->prepare('SELECT COUNT(*) FROM request_events WHERE action_name = :action_name AND fingerprint_hash = :fingerprint_hash AND created_at >= (NOW() - INTERVAL :seconds SECOND)');
        $countStmt->bindValue(':action_name', $action);
        $countStmt->bindValue(':fingerprint_hash', $fingerprint);
        $countStmt->bindValue(':seconds', $windowSeconds, PDO::PARAM_INT);
        $countStmt->execute();

        return (int) $countStmt->fetchColumn() > $limit;
    }

    private function prune(int $windowSeconds): void
    {
        $maxAge = max($windowSeconds * 2, 7200);
        $stmt = $this->pdo->prepare('DELETE FROM request_events WHERE created_at < (NOW() - INTERVAL :seconds SECOND)');
        $stmt->bindValue(':seconds', $maxAge, PDO::PARAM_INT);
        $stmt->execute();
    }
}

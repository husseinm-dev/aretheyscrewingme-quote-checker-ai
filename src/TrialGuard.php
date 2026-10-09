<?php

declare(strict_types=1);

namespace QuoteCheck;

use PDO;

class TrialGuard
{
    public function __construct(private PDO $pdo, private string $appKey, private string $cookieName, private int $cookieDays)
    {
    }

    public function allowFreeCredits(int $userId, int $defaultCredits): int
    {
        $ipHash = Helpers::ipHash($this->appKey);
        $uaHash = Helpers::userAgentHash($this->appKey);
        $deviceHash = Helpers::browserTokenHash($this->cookieName, $this->cookieDays, $this->appKey);

        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM trial_claims WHERE ip_hash = :ip_hash OR device_hash = :device_hash');
        $stmt->execute([
            'ip_hash' => $ipHash,
            'device_hash' => $deviceHash,
        ]);
        $alreadyClaimed = (int) $stmt->fetchColumn() > 0;

        $credits = $alreadyClaimed ? 0 : $defaultCredits;

        $insert = $this->pdo->prepare('INSERT INTO trial_claims (user_id, ip_hash, user_agent_hash, device_hash, granted_credits) VALUES (:user_id, :ip_hash, :ua_hash, :device_hash, :granted_credits)');
        $insert->execute([
            'user_id' => $userId,
            'ip_hash' => $ipHash,
            'ua_hash' => $uaHash,
            'device_hash' => $deviceHash,
            'granted_credits' => $credits,
        ]);

        return $credits;
    }

    public function consumeFreeCredit(int $userId): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET free_credits_remaining = free_credits_remaining - 1 WHERE id = :id AND free_credits_remaining > 0');
        $stmt->execute(['id' => $userId]);
        return $stmt->rowCount() > 0;
    }
}

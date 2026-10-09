<?php

declare(strict_types=1);

namespace QuoteCheck;

use PDO;

class Auth
{
    public function __construct(private PDO $pdo)
    {
    }

    public function login(string $email, string $password): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => strtolower(trim($email))]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        $_SESSION['user_id'] = (int) $user['id'];
        session_regenerate_id(true);
        $_SESSION['last_active'] = time();
        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        session_regenerate_id(true);
    }

    public function user(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function id(): ?int
    {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    public function check(): bool
    {
        return !empty($_SESSION['user_id']);
    }
}

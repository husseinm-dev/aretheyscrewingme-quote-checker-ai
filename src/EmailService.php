<?php

declare(strict_types=1);

namespace QuoteCheck;

class EmailService
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sendNewUserNotification(string $userName, string $userEmail): bool
    {
        $to = $this->config['admin_email'];
        $subject = "New User Signup - Are They Screwing Me";
        
        // Use unique from address to avoid spam filters
        $fromId = date("His");
        $headers  = "From: Are They Screwing Me <help@aretheyscrewingme.com>\r\n";
        $headers .= "Reply-To: {$userEmail}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8";
        
        $timestamp = date('l, F j, Y \a\t g:i A T');
        
        $body  = "New User Signup Notification\n";
        $body .= "================================\n\n";
        $body .= "Full Name: {$userName}\n";
        $body .= "Email: {$userEmail}\n";
        $body .= "Signup Time: {$timestamp}\n\n";
        $body .= "---\n";
        $body .= "Automated notification from aretheyscrewingme.com\n";
        
        try {
            $result = mail($to, $subject, $body, $headers);
            if ($result) {
                error_log("✅ Signup email sent to {$to} for user: {$userEmail}");
                return true;
            } else {
                error_log("❌ mail() function returned false for user: {$userEmail}");
                return false;
            }
        } catch (\Throwable $e) {
            error_log("❌ Email exception for user {$userEmail}: " . $e->getMessage());
            return false;
        }
    }
}
<?php
require_once __DIR__ . '/../../config/bootstrap.php';
$user = $auth->user();
$metaDescription = $metaDescription ?? 'Upload a quote, estimate, or invoice and find out whether the price looks fair, inflated, or suspicious before you pay.';
$metaTitle = $title ?? cfg('app_name');
$metaKeywords = $metaKeywords ?? 'quote checker, estimate checker, price comparison, contractor quotes, mechanic quotes, plumber quotes, fair price check';
$metaImage = $metaImage ?? rtrim((string)cfg('base_url'), '/') . '/assets/img/og-image.png';
$currentUrl = rtrim((string)cfg('base_url'), '/') . current_path();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title><?= h($metaTitle) ?></title>
    <meta name="title" content="<?= h($metaTitle) ?>">
    <meta name="description" content="<?= h($metaDescription) ?>">
    <meta name="keywords" content="<?= h($metaKeywords) ?>">
    <meta name="author" content="<?= h(cfg('brand_domain')) ?>">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#3b82f6">
    <link rel="canonical" href="<?= h($currentUrl) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <link rel="shortcut icon" href="/assets/img/favicon.png">
    <link rel="apple-touch-icon" href="/assets/img/favicon.png">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= h($currentUrl) ?>">
    <meta property="og:title" content="<?= h($metaTitle) ?>">
    <meta property="og:description" content="<?= h($metaDescription) ?>">
    <meta property="og:image" content="<?= h($metaImage) ?>">
    <meta property="og:site_name" content="<?= h(cfg('app_name')) ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= h($currentUrl) ?>">
    <meta property="twitter:title" content="<?= h($metaTitle) ?>">
    <meta property="twitter:description" content="<?= h($metaDescription) ?>">
    <meta property="twitter:image" content="<?= h($metaImage) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css?v=1775628404760">
    <?php if (cfg('turnstile.enabled', false)): ?>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <?php endif; ?>
</head>

<body>
    <header class="site-header">
        <div class="container nav">
            <a href="/" class="logo">


                <img src="/assets/img/site-logo.png" alt="Are they screwing me website logo">
            </a>

            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle navigation menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <div class="nav-overlay" id="navOverlay"></div>

            <nav class="main-nav" id="mainNav">
                <div class="nav-content">
                    <a href="/upload" class="nav-link <?= is_active('/upload') ?>">
                        <span>Analyze</span>
                    </a>
                    <a href="/pricing" class="nav-link <?= is_active('/pricing') ?>">
                        <span>Pricing</span>
                    </a>
                    <a href="/tools" class="nav-link <?= str_starts_with(current_path(), '/tools/') ? 'active' : '' ?>">
                        <span>Tools</span>
                    </a>
                    <a href="/guides"
                        class="nav-link <?= str_starts_with(current_path(), '/guides/') ? 'active' : '' ?>">
                        <span>Guides</span>
                    </a>
                    <?php if ($user): ?>
                    <a href="/dashboard" class="nav-link <?= is_active('/dashboard') ?>">
                        <span>Dashboard</span>
                    </a>
                    <a href="/logout" class="nav-link">
                        <span>Logout</span>
                    </a>
                    <?php else: ?>
                    <a href="/login" class="nav-link <?= is_active('/login') ?>">
                        <span>Login</span>
                    </a>
                    <a href="/signup" class="btn btn-sm btn-nav">Get 2 free checks</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <script>
    (function() {
        const toggle = document.getElementById('mobileMenuToggle');
        const nav = document.getElementById('mainNav');
        const overlay = document.getElementById('navOverlay');
        const body = document.body;

        function toggleMenu() {
            const isOpen = nav.classList.contains('active');

            if (isOpen) {
                nav.classList.remove('active');
                toggle.classList.remove('active');
                overlay.classList.remove('active');
                body.style.overflow = '';
            } else {
                nav.classList.add('active');
                toggle.classList.add('active');
                overlay.classList.add('active');
                body.style.overflow = 'hidden';
            }
        }

        toggle.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && nav.classList.contains('active')) {
                toggleMenu();
            }
        });

        // Close menu when clicking nav links on mobile
        const navLinks = nav.querySelectorAll('.nav-link, .btn');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 1024 && nav.classList.contains('active')) {
                    toggleMenu();
                }
            });
        });
    })();
    </script>
    <main>
        <?php $flashes = flash(); if (!empty($flashes)): ?>
        <div class="container flash-wrap">
            <?php foreach ($flashes as $type => $message): ?>
            <div class="flash <?= h($type) ?>"><?= h($message) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
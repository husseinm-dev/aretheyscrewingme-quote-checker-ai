<?php
use QuoteCheck\TrialGuard;
use QuoteCheck\EmailService;
require_once __DIR__ . '/../config/bootstrap.php';
if ($auth->check()) redirect('/dashboard');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    rate_limit_or_fail('signup', (int)cfg('security.auth_limit_per_15m', 8), 900);
    if (!$csrf->verify($_POST['_csrf'] ?? null)) {
        set_flash('error', 'Session expired. Try again.');
        redirect('/signup');
    }
    verify_turnstile_or_fail($_POST['cf-turnstile-response'] ?? null);
    $fullName = trim((string)($_POST['full_name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (empty($fullName) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 10) {
        set_flash('error', 'Please provide your full name, a valid email, and a password with at least 10 characters.');
        redirect('/signup');
    }
    $exists = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
    $exists->execute(['email' => $email]);
    if ($exists->fetch()) {
        set_flash('error', 'That email already exists. Log in instead.');
        redirect('/login');
    }
    $insert = $pdo->prepare('INSERT INTO users (full_name, email, password_hash, free_credits_remaining) VALUES (:full_name, :email, :password_hash, 0)');
    $insert->execute(['full_name' => $fullName, 'email' => $email, 'password_hash' => password_hash($password, PASSWORD_DEFAULT)]);
    $userId = (int)$pdo->lastInsertId();
    $guard = new TrialGuard($pdo, cfg('app_key'), cfg('trial.cookie_name'), (int)cfg('trial.cookie_days'));
    $credits = $guard->allowFreeCredits($userId, (int)cfg('trial.free_credits'));
    $pdo->prepare('UPDATE users SET free_credits_remaining = :credits WHERE id = :id')->execute(['credits' => $credits, 'id' => $userId]);
    
    // Send signup notification email
    try {
        $emailService = new EmailService(cfg('email'));
        $emailService->sendNewUserNotification($fullName, $email);
    } catch (Throwable $e) {
        error_log("Signup email notification failed: " . $e->getMessage());
    }
    
    $auth->login($email, $password);
    set_flash('success', $credits > 0 ? "Account created. You got {$credits} free checks." : 'Account created. The free trial was already used on this device or network, but you can still buy credits anytime.');
    redirect('/dashboard');
}
$title='Sign Up Free - Get 2 Free Quote Checks | Are They Screwing Me?';
$metaDescription = 'Create your free account and get 2 free quote checks. No credit card required. Start analyzing mechanic, plumber, contractor, and repair estimates instantly.';
$metaKeywords = 'sign up free, free quote checker, free estimate analysis, create account, free repair quote checks';
include __DIR__.'/partials/header.php'; ?>
<section class="hero-simple compact-hero">
    <div class="container narrow">
        <span class="eyebrow">Get started free</span>
        <h1>Check your first quote in seconds.</h1>
        <p class="lead">New eligible accounts get up to <?= (int) cfg('trial.free_credits', 2) ?> free checks. </p>
    </div>
</section>
<section class="section section-tight">
    <div class="container split-auth">
        <div class="card card-soft auth-side">
            <h2>What you unlock</h2>
            <ul class="list clean-list">
                <li>Price range and verdict</li>
                <li>Clear red flags</li>
                <li>Questions to ask back</li>
                <li>A ready-to-send reply template</li>
            </ul>
        </div>
        <div class="card auth-card">
            <h2>Create account</h2>
            <form method="post">
                <input type="hidden" name="_csrf" value="<?= h($csrf->token()) ?>">
                <div class="field"><label>Full Name</label><input type="text" name="full_name" required
                        placeholder="John Doe"></div>
                <div class="field"><label>Email</label><input type="email" name="email" required
                        placeholder="you@example.com"></div>
                <div class="field"><label>Password</label><input type="password" name="password" required minlength="10"
                        placeholder="At least 10 characters"></div>
                <?php if (cfg('turnstile.enabled', false)): ?>
                <div class="field">
                    <div class="cf-turnstile" data-sitekey="<?= h((string)cfg('turnstile.site_key', '')) ?>"></div>
                </div>
                <?php endif; ?>
                <button class="btn btn-block" type="submit">Create account</button>
            </form>
            <p class="muted small" style="margin-top:12px">Already signed up? <a href="/login">Log in here</a>.</p>
        </div>
    </div>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>
<?php
require_once __DIR__ . '/../config/bootstrap.php';
if ($auth->check()) redirect('/dashboard');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    rate_limit_or_fail('login', (int)cfg('security.auth_limit_per_15m', 8), 900);
    if (!$csrf->verify($_POST['_csrf'] ?? null)) {
        set_flash('error', 'Session expired. Try again.');
        redirect('/login');
    }
    verify_turnstile_or_fail($_POST['cf-turnstile-response'] ?? null);
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if ($auth->login($email, $password)) {
        set_flash('success', 'Welcome back.');
        redirect('/dashboard');
    }
    set_flash('error', 'Invalid email or password.');
    redirect('/login');
}
$title='Login - Access Your Quote Analysis Dashboard | Are They Screwing Me?';
$metaDescription = 'Log in to access your saved quote analyses, check remaining credits, and analyze new repair estimates. Fast access to your price comparison dashboard.';
$metaKeywords = 'login, quote checker login, estimate analysis login, user dashboard';
include __DIR__.'/partials/header.php'; ?>
<section class="hero-simple compact-hero">
  <div class="container narrow">
    <span class="eyebrow">Welcome back</span>
    <h1>Log in and keep checking quotes.</h1>
    <p class="lead">Saved reports, one-off credits, 3-packs, and Pro all live in one clean dashboard.</p>
  </div>
</section>
<section class="section section-tight">
  <div class="container split-auth">
    <div class="card card-soft auth-side">
      <h2>Why people come back</h2>
      <ul class="list clean-list">
        <li>Compare multiple estimates faster</li>
        <li>Keep a record of suspicious pricing</li>
        <li>Reuse the product whenever a quote feels off</li>
      </ul>
    </div>
    <div class="card auth-card">
      <h2>Log in</h2>
      <form method="post">
        <input type="hidden" name="_csrf" value="<?= h($csrf->token()) ?>">
        <div class="field"><label>Email</label><input type="email" name="email" required></div>
        <div class="field"><label>Password</label><input type="password" name="password" required></div>
        <?php if (cfg('turnstile.enabled', false)): ?>
          <div class="field"><div class="cf-turnstile" data-sitekey="<?= h((string)cfg('turnstile.site_key', '')) ?>"></div></div>
        <?php endif; ?>
        <button class="btn btn-block" type="submit">Log in</button>
      </form>
      <p class="muted small" style="margin-top:12px">Need an account? <a href="/signup">Create one here</a>.</p>
    </div>
  </div>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>

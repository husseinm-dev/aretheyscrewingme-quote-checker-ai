<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
$user = $auth->user();
$stmt = $pdo->prepare('SELECT * FROM reports WHERE user_id = :user_id ORDER BY id DESC LIMIT 20');
$stmt->execute(['user_id' => $user['id']]);
$reports = $stmt->fetchAll();
$title='Dashboard - Your Quote Analysis History | Are They Screwing Me?';
$metaDescription='View your saved quote analyses, track free and paid credits, manage your subscription, and access past repair estimate reports in one clean dashboard.';
$metaKeywords='quote analysis dashboard, saved estimates, credit tracking, quote history, repair analysis reports';
include __DIR__.'/partials/header.php'; ?>
<section class="form-wrap">
  <div class="container">
    <div class="section-header" style="max-width:920px">
      <span class="eyebrow">Welcome back</span>
      <h2>Your suspicion dashboard.</h2>
      <p>Track your free checks, paid credits, active plan, and every report you’ve run so far. Clean, sharp, and not buried under junk.</p>
    </div>
    <div class="kpis">
      <div class="kpi"><span class="muted small">Free credits left</span><strong><?= (int)$user['free_credits_remaining'] ?></strong></div>
      <div class="kpi"><span class="muted small">Paid credits</span><strong><?= (int)$user['paid_credits_remaining'] ?></strong></div>
      <div class="kpi"><span class="muted small">Plan</span><strong><?= subscription_is_active($user) ? 'Pro' : 'Standard' ?></strong></div>
      <div class="kpi"><span class="muted small">Reports created</span><strong><?= count($reports) ?></strong></div>
    </div>
    <div class="hero-actions" style="margin-top:18px">
      <a href="/upload" class="btn">Analyze a quote</a>
      <a href="/pricing" class="btn btn-outline">Buy more checks</a>
    </div>
    <div class="grid-2" style="margin-top:22px">
      <div class="card card-soft">
        <div class="pill <?= subscription_is_active($user) ? 'good' : 'warn' ?>"><?= subscription_is_active($user) ? 'Pro active' : 'Free / pay as you go' ?></div>
        <h3 style="font-size:1.5rem;letter-spacing:-.04em;margin:14px 0 10px">Plan status</h3>
        <p class="muted"><?php if (subscription_is_active($user)): ?>You’re on Pro. New monthly credits should replenish through Stripe webhooks each billing cycle.<?php else: ?>You’re currently using free or one-time credits. Great for occasional checks. Upgrade if this turns into a habit.<?php endif; ?></p>        <?php if (subscription_is_active($user) && !empty($user['stripe_customer_id'])): ?>
          <a href="/manage-billing" class="btn btn-outline" style="margin-top:16px;display:inline-block;text-decoration:none;">Manage Subscription</a>
        <?php endif; ?>      </div>
      <div class="card card-soft">
        <h3 style="font-size:1.5rem;letter-spacing:-.04em;margin:0 0 10px">Quick reminder</h3>
        <ul class="list">
          <li>Free trial abuse is tracked by device + network fingerprinting.</li>
          <li>One-time packs do not expire.</li>
          <li>Each finished result is saved to your account for easy reference.</li>
        </ul>
      </div>
    </div>
    <div class="card" style="margin-top:22px">
      <div style="display:flex;justify-content:space-between;gap:18px;align-items:end;flex-wrap:wrap">
        <div>
          <h3 style="font-size:1.6rem;letter-spacing:-.04em;margin:0 0 8px">Recent reports</h3>
          <p class="muted" style="margin:0">Open any completed result and keep receipts on who tried to play you.</p>
        </div>
      </div>
      <div class="table-wrap" style="margin-top:16px">
        <table class="table">
          <thead><tr><th>Date</th><th>Category</th><th>Status</th><th>Score</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($reports as $report): ?>
            <tr>
              <td><?= h(date('M j, Y', strtotime($report['created_at']))) ?></td>
              <td><?= h(category_label((string)$report['category'])) ?></td>
              <td><?= h($report['analysis_status']) ?></td>
              <td><?= $report['score'] !== null ? (int)$report['score'] : '—' ?></td>
              <td><a href="/result.php?id=<?= (int)$report['id'] ?>">Open report</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>

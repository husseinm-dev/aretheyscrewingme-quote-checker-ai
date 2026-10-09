<?php
require_once __DIR__ . '/../config/bootstrap.php';
$scoreClass = static function (int $score): string {
    return $score >= 80 ? 'good' : ($score >= 45 ? 'warn' : 'bad');
};
require_login();
$reportId = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM reports WHERE id = :id AND user_id = :user_id LIMIT 1');
$stmt->execute(['id' => $reportId, 'user_id' => $auth->id()]);
$report = $stmt->fetch();
if (!$report) {
    set_flash('error', 'Report not found.');
    redirect('/dashboard');
}
$result = $report['result_json'] ? json_decode((string)$report['result_json'], true) : null;
$title='Quote Analysis Result | Are They Screwing Me?';
$metaDescription='View your detailed quote analysis with fair price range, red flags, and negotiation tips. Get actionable insights on your repair estimate.';
$metaKeywords='quote analysis result, estimate report, price analysis, repair quote breakdown';
include __DIR__.'/partials/header.php'; ?>
<section class="form-wrap">
    <div class="container">
        <?php if (!$result): ?>
        <div class="card">
            <?php if ($report['analysis_status'] === 'failed'): ?>
                <h1 class="page-title">Analysis Failed</h1>
                <p class="muted">The analysis encountered an error. This can happen due to server timeouts or AI service issues.</p>
                <p class="muted" style="margin-top: 12px;"><strong>Good news:</strong> You have not been charged. Your credit is still available.</p>
                <div class="hero-actions" style="margin-top: 24px;">
                    <a href="/analyze?id=<?= (int)$report['id'] ?>" class="btn">Try Again</a>
                    <a href="/upload" class="btn btn-outline">Upload New Quote</a>
                </div>
            <?php else: ?>
                <h1 class="page-title">Result not ready</h1>
                <p class="muted">This report has not been analyzed yet.</p>
                <div class="hero-actions" style="margin-top: 24px;">
                    <a href="/analyze?id=<?= (int)$report['id'] ?>" class="btn">Analyze Now</a>
                </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="result-grid">
            <div class="card result-score">
                <div class="pill <?= h($scoreClass((int)$result['score'])) ?>"><?= h($result['status']) ?></div>
                <h1 class="page-title" style="margin-bottom:20px;"><?= h($result['service_label']) ?></h1>
                <p class="muted" style="margin-top:0">This is the shareable verdict page. Big score. Clear data. Strong
                    explanation. No vague AI mush.</p>
                <div class="score-ring <?= h($scoreClass((int)$result['score'])) ?>">
                    <span><?= (int)$result['score'] ?></span>
                </div>
                <div class="data-points">
                    <div class="data-point"><span class="muted">Quoted
                            price</span><strong><?= h(QuoteCheck\Helpers::money((float)$result['quoted_price'])) ?></strong>
                    </div>
                    <?php if ((float)$result['fair_high'] > 0): ?>
                    <div class="data-point"><span class="muted">Typical
                            range</span><strong><?= h(QuoteCheck\Helpers::money((float)$result['fair_low'])) ?> –
                            <?= h(QuoteCheck\Helpers::money((float)$result['fair_high'])) ?></strong></div>
                    <div class="data-point"><span class="muted">Estimated over
                            market</span><strong><?= (int)$result['overpriced_percent'] ?>%</strong></div>
                    <?php endif; ?>
                    <div class="data-point"><span class="muted">Credit
                            used</span><strong><?= h((string)$report['used_credit_type']) ?></strong></div>
                </div>
            </div>
            <div class="card">
                <h2 style="font-size:1.8rem;letter-spacing:-.04em;margin:0 0 10px">Verdict</h2>
                <p><?= h($result['summary']) ?></p>
                <div class="divider"></div>
                <h3>Red flags</h3>
                <ul class="list"><?php foreach (($result['red_flags'] ?? []) as $item): ?><li><?= h((string)$item) ?>
                    </li><?php endforeach; ?></ul>
                <?php if (!empty($result['unit_analysis'])): ?>
                <div class="divider"></div>
                <h3>Unit pricing analysis</h3>
                <div class="unit-analysis-grid">
                    <?php foreach ($result['unit_analysis'] as $item): 
            // Skip items without valid market pricing data
            if ($item['typical_high'] <= 0) continue;
            
            // Calculate how far over/under market this is
            $overMarketPct = 0;
            if ($item['typical_high'] > 0) {
                $overMarketPct = (($item['unit_price'] - $item['typical_high']) / $item['typical_high']) * 100;
            }
            
            $statusClass = match($item['status']) {
              'below_market' => 'good',
              'fair' => 'good',
              'expensive' => 'warn',
              'red_flag' => 'bad',
              default => 'warn'
            };
            
            // More descriptive status labels
            if ($item['status'] === 'red_flag' && $overMarketPct > 200) {
                $statusLabel = 'Extreme ripoff';
            } elseif ($item['status'] === 'red_flag' && $overMarketPct > 75) {
                $statusLabel = 'Major red flag';
            } elseif ($item['status'] === 'red_flag') {
                $statusLabel = 'Red flag';
            } else {
                $statusLabel = match($item['status']) {
                  'below_market' => 'Below market',
                  'fair' => 'Fair',
                  'expensive' => 'Expensive',
                  default => 'Unknown'
                };
            }
          ?>
                    <div class="unit-item">
                        <div class="unit-item-header">
                            <strong><?= h($item['name']) ?></strong>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <?php if ($overMarketPct > 0): ?>
                                <span class="muted small" style="font-weight:600;"><?= round($overMarketPct) ?>%
                                    over</span>
                                <?php endif; ?>
                                <span class="pill <?= h($statusClass) ?>"><?= h($statusLabel) ?></span>
                            </div>
                        </div>
                        <div class="unit-item-details">
                            <div class="unit-detail">
                                <span class="muted small">Quoted price</span>
                                <strong><?= h(QuoteCheck\Helpers::money($item['unit_price'])) ?> each</strong>
                            </div>
                            <div class="unit-detail">
                                <span class="muted small">Market range</span>
                                <strong><?= h(QuoteCheck\Helpers::money($item['typical_low'])) ?> –
                                    <?= h(QuoteCheck\Helpers::money($item['typical_high'])) ?></strong>
                            </div>
                            <div class="unit-detail">
                                <span class="muted small">Quantity</span>
                                <strong><?= (int)$item['quantity'] ?></strong>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="divider"></div>
                <h3>Questions to ask</h3>
                <ul class="list"><?php foreach (($result['questions_to_ask'] ?? []) as $item): ?><li>
                        <?= h((string)$item) ?></li><?php endforeach; ?></ul>
                <div class="divider"></div>
                <h3>What to say back</h3>
                <div class="copy-box"><?= h((string)$result['reply_template']) ?></div>
                <div class="hero-actions" style="margin-top:18px">
                    <a class="btn" href="/upload">Analyze another</a>
                    <a class="btn btn-outline" href="/pricing">Buy more checks</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>
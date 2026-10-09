<?php
$title = 'Pricing - Quote Checker Plans | Are They Screwing Me?';
$metaDescription = 'Simple, transparent pricing for quote analysis. Start with 2 free checks, then choose pay-per-report or Pro monthly plan. No subscriptions required. Save money on repair estimates.';
$metaKeywords = 'quote checker pricing, estimate analysis cost, repair quote plans, contractor quote pricing, subscription free pricing';
include __DIR__.'/partials/header.php';
?>
<section class="hero-simple compact-hero">
    <div class="container narrow">
        <span class="eyebrow">Pricing</span>
        <h1>Don’t overpay by hundreds on your next quote.</h1>
        <p class="lead">Use the free checks first. Then buy exactly what fits how you use the product.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="pricing-grid">
            <a href="/signup" class="price-card price-card-link">
                <div class="pill good">Free</div>
                <h3>Starter</h3>
                <div class="price"><strong>$0</strong><span>new users</span></div>
                <div class="price-list">
                    <div><?= (int)cfg('trial.free_credits', 2) ?> free checks</div>
                    <div>Full result experience</div>
                    <div>Best first step</div>
                </div>
            </a>
            <a href="/checkout.php?plan=single" class="price-card price-card-link">
                <div class="pill warn">One-off</div>
                <h3>Single report</h3>
                <div class="price">
                    <strong>$<?= number_format(cfg('stripe.single_report_price_cents') / 100, 2) ?></strong><span>one
                        time</span>
                </div>
                <div class="price-list">
                    <div>1 paid check</div>
                    <div>No subscription</div>
                    <div>Perfect for one suspicious quote</div>
                </div>
            </a>
            <a href="/checkout.php?plan=pack3" class="price-card price-card-link popular">
                <div class="badge-top">Most practical</div>
                <div class="pill warn">Bundle</div>
                <h3>3-report pack</h3>
                <div class="price">
                    <strong>$<?= number_format(cfg('stripe.pack_3_price_cents') / 100, 2) ?></strong><span>one
                        time</span>
                </div>
                <div class="price-list">
                    <div>3 credits</div>
                    <div>Compare quotes side by side</div>
                    <div>Credits do not expire</div>
                </div>
            </a>
            <a href="/checkout.php?plan=pro" class="price-card price-card-link">
                <div class="pill good">Subscription</div>
                <h3>Pro monthly</h3>
                <div class="price"><strong>$19</strong><span>/month</span></div>
                <div class="price-list">
                    <div><?= (int)cfg('stripe.monthly_subscription_report_credits', 60) ?> checks every month</div>
                    <div>Best for repeat users, landlords, PMs, flippers</div>
                    <div>Monthly reset via Stripe</div>
                </div>
            </a>
        </div>
    </div>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>
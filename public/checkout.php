<?php
use QuoteCheck\StripeService;
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
$reportId = (int)($_GET['id'] ?? 0);
$allowed = ['single', 'pack3', 'pro'];
$selectedPlan = in_array($_GET['plan'] ?? '', $allowed, true) ? (string)$_GET['plan'] : 'pack3';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$csrf->verify($_POST['_csrf'] ?? null)) {
        set_flash('error', 'Session expired.');
        redirect('/checkout?id=' . $reportId);
    }
    $mode = in_array($_POST['purchase_mode'] ?? 'single', $allowed, true) ? (string)$_POST['purchase_mode'] : 'single';
    $stripe = new StripeService(cfg('stripe'));
    $success = rtrim(cfg('base_url'), '/') . '/checkout.php?success=1&id=' . $reportId;
    $cancel = rtrim(cfg('base_url'), '/') . '/checkout.php?id=' . $reportId;
    $url = $stripe->checkoutUrl($reportId, (int)$auth->id(), $success, $cancel, $mode);
    redirect($url);
}
if (isset($_GET['success'])) {
    set_flash('success', 'Payment received. If webhook processing is delayed for a moment, refresh in a few seconds.');
    redirect('/dashboard');
}
$title='Checkout - Purchase Quote Analysis Credits | Are They Screwing Me?';
$metaDescription='Purchase quote analysis credits or upgrade to Pro plan. Secure checkout for analyzing repair estimates from mechanics, contractors, plumbers, and more.';
$metaKeywords='checkout, purchase credits, quote checker pricing, buy analysis credits, pro plan subscription';
include __DIR__.'/partials/header.php';
?>
<section class="hero-simple">
    <div class="container">
        <span class="eyebrow">Out of free checks?</span>
        <h1>Pick the paid option that actually fits how people use this.</h1>
        <p class="lead">One quote, one unlock. Comparing estimates, grab the pack. Doing this all the time, go Pro.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <form method="post">
            <input type="hidden" name="_csrf" value="<?= h($csrf->token()) ?>">
            <div class="pricing-grid checkout-pricing-grid">
                <label class="price-card price-card-selectable <?= $selectedPlan === 'single' ? 'selected' : '' ?>">
                    <input type="radio" name="purchase_mode" value="single"
                        <?= $selectedPlan === 'single' ? 'checked' : '' ?> class="price-card-radio">
                    <div class="selection-indicator"></div>
                    <div class="pill warn">One-off</div>
                    <h3>Single report</h3>
                    <div class="price">
                        <strong>$<?= number_format(cfg('stripe.single_report_price_cents') / 100, 2) ?></strong><span>one
                            time</span>
                    </div>
                    <div class="price-list">
                        <div>1 paid check</div>
                        <div>Best for one suspicious estimate</div>
                        <div>No subscription attached</div>
                    </div>
                </label>
                <label
                    class="price-card price-card-selectable <?= $selectedPlan === 'pack3' ? 'selected' : '' ?> popular">
                    <input type="radio" name="purchase_mode" value="pack3"
                        <?= $selectedPlan === 'pack3' ? 'checked' : '' ?> class="price-card-radio">
                    <div class="selection-indicator"></div>
                    <div class="badge-top">Most practical</div>
                    <div class="pill good">Bundle</div>
                    <h3>3-report pack</h3>
                    <div class="price">
                        <strong>$<?= number_format(cfg('stripe.pack_3_price_cents') / 100, 2) ?></strong><span>one
                            time</span>
                    </div>
                    <div class="price-list">
                        <div>3 credits</div>
                        <div>Great for side-by-side comparisons</div>
                        <div>Credits do not expire</div>
                    </div>
                </label>
                <label class="price-card price-card-selectable <?= $selectedPlan === 'pro' ? 'selected' : '' ?>">
                    <input type="radio" name="purchase_mode" value="pro" <?= $selectedPlan === 'pro' ? 'checked' : '' ?>
                        class="price-card-radio">
                    <div class="selection-indicator"></div>
                    <div class="pill good">Subscription</div>
                    <h3>Pro monthly</h3>
                    <div class="price"><strong>$19</strong><span>/month</span></div>
                    <div class="price-list">
                        <div><?= (int) cfg('stripe.monthly_subscription_report_credits', 60) ?> checks every month</div>
                        <div>Better for repeat users</div>
                        <div>Stripe recurring billing</div>
                    </div>
                </label>
            </div>
            <button class="btn" type="submit" style="margin-top:20px">Continue to secure checkout</button>
        </form>
    </div>
</section>

<script>
(function() {
    const cards = document.querySelectorAll('.price-card-selectable');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            cards.forEach(c => c.classList.remove('selected'));

            // Add selected class to clicked card
            this.classList.add('selected');

            // Check the radio button inside this card
            const radio = this.querySelector('.price-card-radio');
            if (radio) {
                radio.checked = true;
            }
        });
    });
})();
</script>

<?php include __DIR__.'/partials/footer.php'; ?>
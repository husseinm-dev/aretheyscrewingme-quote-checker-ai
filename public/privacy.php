<?php
$title='Privacy Policy | Are They Screwing Me?';
$metaDescription = 'Privacy policy for quote analysis service. Learn how we protect your data, handle uploads, and secure payment information through Stripe.';
$metaKeywords = 'privacy policy, data protection, quote checker privacy, secure estimates';
include __DIR__.'/partials/header.php';
?>
<section class="form-wrap"><div class="container"><div class="card"><h1 class="page-title">Privacy</h1><p class="muted">We store account data, uploaded quote content, analysis results, and anti-abuse fingerprints needed to protect the free trial. Abuse prevention uses hashed IP, device token, and user-agent values rather than raw public-facing disclosure. Payment details are handled by Stripe, not stored directly in this app.</p></div></div></section>
<?php include __DIR__.'/partials/footer.php'; ?>

<?php
$title = "Electrician Quote Checker - Panel Upgrade & Outlet Installation Estimates | Are They Screwing Me?";
$metaDescription = "Check electrician quotes for panel upgrades, outlet installation, lighting, breaker work, and wiring. Compare electrical repair estimates and avoid overpriced service calls.";
$metaKeywords = 'electrician quote checker, electrical work estimate, panel upgrade cost, outlet installation price, breaker repair quote, electrical estimate tool';
include __DIR__.'/../partials/header.php';
?>
<section class="hero-simple">
  <div class="container">
    <span class="eyebrow">Electrician quote checker</span>
    <h1>Electrician quote checker</h1>
    <p class="lead">Electrical work should be clear and itemized, especially when safety is involved. Use this page to compare outlets, lighting, fan installs, and breaker work.</p>
    <div class="hero-actions">
      <a href="/upload?category=electrician" class="btn">Check this type of quote</a>
      <a href="/pricing" class="btn btn-outline">See pricing</a>
    </div>
  </div>
</section>
<section class="section">
  <div class="container example-shell">
    <div class="quote-box">
      <div class="section-header" style="margin-bottom:14px">
        <h2>Typical price range</h2>
        <p>Most jobs in this category land somewhere around <strong>$120 to $2,200 depending on the service</strong>, but the exact number depends on scope, labor, urgency, and material quality.</p>
      </div>
      <h3 style="margin-bottom:10px">Common red flags</h3>
      <ul class="list">
        <li>No permit or panel details when relevant</li>
        <li>Travel or minimum service fee is inflated</li>
        <li>No clear explanation of labor scope</li>
      </ul>
      <div class="divider"></div>
      <h3 style="margin-bottom:10px">What this tool helps you answer</h3>
      <ul class="list">
        <li>Does the quote look fair for the category?</li>
        <li>What feels vague, padded, or hard to justify?</li>
        <li>What should you ask before you approve the work?</li>
      </ul>
    </div>
    <div class="mockup"><img src="/assets/img/quote-sheet.svg" alt="Invoice and quote illustration"></div>
  </div>
</section>
<section class="section">
  <div class="container grid-3">
    <div class="card card-outline"><h3>Upload the quote</h3><p class="muted">Drop in a PDF, photo, or screenshot and let the analyzer do the first pass.</p></div>
    <div class="card card-outline"><h3>See the likely fair range</h3><p class="muted">Get a cleaner frame for whether the number looks normal, high, or way out of line.</p></div>
    <div class="card card-outline"><h3>Ask better questions</h3><p class="muted">Use the follow-up prompts and reply template to push back without sounding lost.</p></div>
  </div>
</section>
<?php include __DIR__.'/../partials/footer.php'; ?>

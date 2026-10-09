<?php
$title = "Pest Control Quote Checker - Termite, Bed Bug Treatment Estimates | Are They Screwing Me?";
$metaDescription = "Analyze pest control quotes for termite treatment, bed bug extermination, rodent control, and general pest services. Compare pricing before signing contracts.";
$metaKeywords = 'pest control quote, termite treatment cost, bed bug extermination estimate, rodent control pricing, pest service quotes, exterminator estimate';
include __DIR__.'/../partials/header.php';
?>
<section class="hero-simple">
  <div class="container">
    <span class="eyebrow">Pest control quote checker</span>
    <h1>Pest control quote checker</h1>
    <p class="lead">Pest control pricing is usually recurring, bundled, or upsold. This page helps people compare general treatment, termite work, bed bug treatment, and rodent control pricing.</p>
    <div class="hero-actions">
      <a href="/upload?category=pest" class="btn">Check this type of quote</a>
      <a href="/pricing" class="btn btn-outline">See pricing</a>
    </div>
  </div>
</section>
<section class="section">
  <div class="container example-shell">
    <div class="quote-box">
      <div class="section-header" style="margin-bottom:14px">
        <h2>Typical price range</h2>
        <p>Most jobs in this category land somewhere around <strong>$120 to $3,500 depending on treatment type</strong>, but the exact number depends on scope, labor, urgency, and material quality.</p>
      </div>
      <h3 style="margin-bottom:10px">Common red flags</h3>
      <ul class="list">
        <li>Long-term commitment buried in the quote</li>
        <li>Inspection fee rolled into unclear treatment cost</li>
        <li>No treatment scope or follow-up detail shown</li>
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

<?php
$title = 'Check Quotes by Service | Are They Screwing Me?';
$metaDescription = 'Check if you’re overpaying for mechanics, plumbers, electricians, HVAC, roofing, and more. See real price ranges, red flags, and what to say before you agree.';
$metaKeywords = 'check contractor quote, fair price estimate, mechanic quote check, plumber pricing, HVAC cost, contractor estimate checker';
include __DIR__.'/../partials/header.php';
?>
<section class="hero-simple">
    <div class="container">
        <span class="eyebrow">Check by service</span>
        <h1>Are they screwing you? Let’s find out.</h1>
        <p class="lead">Pick a service to see typical price ranges, common red flags, and what you should be paying
            before you agree to anything.</p>
    </div>
</section>
<section class="section">
    <div class="container tool-grid">
        <?php 
    $icons = [
        'mechanic' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>',
        'plumber' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"/><circle cx="12" cy="12" r="3"/></svg>',
        'electrician' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/></svg>',
        'hvac' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"/><circle cx="12" cy="12" r="5"/></svg>',
        'landscaper' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M3 12c0-2.5 2-4 4-4s4 1.5 4 4-2 4-4 4-4-1.5-4-4zm10 0c0-2.5 2-4 4-4s4 1.5 4 4-2 4-4 4-4-1.5-4-4z"/></svg>',
        'roofer' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l9-9 9 9M5 10v10h14V10"/><path d="M9 21v-6h6v6"/></svg>',
        'contractor' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
        'moving' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
        'appliance' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="18" r="1"/><path d="M8 6h8M8 10h8"/></svg>',
        'pest' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2c-1.5 0-2.5 1-2.5 2.5S10.5 7 12 7s2.5-1 2.5-2.5S13.5 2 12 2zm-6 8c0-1.5 1-3 3-3s3 1.5 3 3v4c0 2 1 4 3 4s3-2 3-4v-4c0-1.5 1-3 3-3s3 1.5 3 3"/><circle cx="12" cy="12" r="2"/></svg>',
    ];
    foreach (quote_categories() as $key => $label): 
    ?>
        <a href="/tools/<?= h($key) ?>-quote-checker" class="service-card">
            <div class="service-icon"><?= $icons[$key] ?? '💼' ?></div>
            <h3><?= h($label) ?></h3>
            <p>Typical ranges, common red flags, and direct CTA.</p>
            <span class="service-arrow">→</span>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__.'/../partials/footer.php'; ?>
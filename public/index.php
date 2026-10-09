<?php
$title = 'Are They Screwing Me? | Free Quote & Estimate Checker Tool';
$metaDescription = 'Upload mechanic, plumber, electrician, HVAC, contractor quotes and instantly check if the price is fair. AI-powered quote analysis helps you avoid overpriced estimates and save money on repairs.';
$metaKeywords = 'quote checker, estimate checker, price comparison tool, mechanic quote checker, plumber estimate, contractor prices, HVAC quote, fair price check, overpriced quote detector, repair cost analyzer';
include __DIR__.'/partials/header.php';
?>
<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Mechanic • plumber • electrician • HVAC • landscaper • more</span>
            <h1>Upload your quote. Find out if they’re screwing you.</h1>
            <p class="lead">Fast quote checks for service invoices, estimates, and repair bills. We show the likely fair
                range, the red flags, and what to say back before you agree to anything.</p>
            <div class="hero-actions">
                <a href="/signup" class="btn">Get 2 free checks</a>
                <a href="/upload" class="btn btn-outline">Analyze a quote</a>
            </div>
            <div class="subtle-row">
                <span><strong>No subscription required</strong> to start</span>
                <span><strong>Useful in under a minute</strong></span>
                <span><strong>Built for real invoices</strong></span>
            </div>
        </div>
        <div class="hero-card">
            <div class="panel-head">
                <div>
                    <div class="pill good" id="heroPill">Analyzing...</div>
                    <div style="font-size:1.45rem;font-weight:900;letter-spacing:-.04em;margin-top:10px">Brake pad +
                        rotor quote</div>
                </div>
                <div class="score-orb" id="heroScore" data-target="28"
                    style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-color: rgba(34, 197, 94, 0.2); color: #15803d; box-shadow: 0 6px 20px rgba(34, 197, 94, 0.25), inset 0 2px 0 rgba(255, 255, 255, 0.6);">
                    100</div>
            </div>
            <div class="panel-body">
                <div class="kv hero-anim-item">
                    <div class="mini"><span class="muted small">Quoted price</span><strong>$780</strong></div>
                    <div class="mini"><span class="muted small">Typical range</span><strong>$320–$450</strong></div>
                </div>
                <ul class="list hero-anim-item">
                    <li>No labor breakdown.</li>
                    <li>Parts pricing looks inflated.</li>
                    <li>You get questions to ask and a copy-paste reply.</li>
                </ul>
                <div class="divider hero-anim-item"></div>
                <div class="score-legend hero-anim-item">
                    <span class="pill good">80–100 fair</span>
                    <span class="pill warn">45–79 maybe high</span>
                    <span class="pill bad">0–44 red flag</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-tight steps-section">
    <div class="container">
        <div class="section-header compact-center fade-up">
            <h2>Three simple steps.</h2>
            <p>Upload the quote, get the verdict, and know what to say back.</p>
        </div>
        <div class="how-grid">
            <div class="how-card fade-up stagger-1">
                <div class="feature-number">1</div>
                <h3>Upload the quote</h3>
                <p class="muted">PDF, screenshot, photo, or pasted estimate text.</p>
            </div>
            <div class="how-card fade-up stagger-2">
                <div class="feature-number">2</div>
                <h3>Get the verdict</h3>
                <p class="muted">We estimate a fair range and flag vague or padded line items.</p>
            </div>
            <div class="how-card fade-up stagger-3">
                <div class="feature-number">3</div>
                <h3>Know what to say</h3>
                <p class="muted">Get direct follow-up questions and a reply template you can actually send.</p>
            </div>
        </div>
    </div>
</section>

<section class="video-section">
    <div class="container">
        <div class="video-section-header">
            <h2>Ever wonder if you're being overcharged?</h2>
            <p>See how our tool catches inflated quotes and gives you the confidence to push back.</p>
        </div>
        <div class="video-wrapper">
            <div class="video-placeholder" id="videoPlaceholder">
                <img src="/assets/video/aretheyscrewingme-placeholder.jpg" alt="Video preview"
                    class="placeholder-image">
                <button class="play-button" aria-label="Play video">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="60" cy="60" r="60" fill="white" fill-opacity="0.95" />
                        <path d="M48 37.5L82.5 60L48 82.5V37.5Z" fill="#0a0e1a" />
                    </svg>
                </button>
            </div>
            <video id="promoVideo" src="/assets/video/aretheyscrewingme-promovid.mp4" controls
                style="display: none;"></video>
        </div>
    </div>
</section>

<section class="section section-tight">
    <div class="container example-shell fade-up">
        <div class="quote-box">
            <div class="section-header" style="margin-bottom:18px">
                <h2>What the result looks like.</h2>
                <p>Big score. Clear price range. Useful next step.</p>
            </div>
            <div class="data-points">
                <div class="data-point"><span class="muted">Service</span><strong>Brake pad + rotor quote</strong></div>
                <div class="data-point"><span class="muted">Quoted price</span><strong>$780</strong></div>
                <div class="data-point"><span class="muted">Typical range</span><strong>$320–$450</strong></div>
                <div class="data-point"><span class="muted">Estimated over market</span><strong>49%</strong></div>
            </div>
            <div class="divider"></div>
            <h3 style="margin-bottom:10px">Sample red flags</h3>
            <ul class="list">
                <li>No parts brand listed.</li>
                <li>No labor hours shown.</li>
                <li>Rotor replacement appears bundled without explanation.</li>
            </ul>
        </div>
        <div class="mockup">
            <div class="mockup-slider">
                <div class="slider-track">
                    <!-- Slide 1: Brake repair (red flag) -->
                    <div class="slider-item active">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill bad">Major red flag</div>
                                    <div class="mini-title">Brake pad + rotor</div>
                                </div>
                                <div class="mini-score-orb bad-score">28</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$780</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$320–$450</strong></div>
                                </div>
                                <div class="mini-badge over-badge">+73% over market</div>
                                <div class="mini-notes">
                                    <strong>Key issues:</strong>
                                    <ul>
                                        <li>No labor breakdown provided</li>
                                        <li>Parts pricing appears inflated</li>
                                        <li>Missing brand/quality details</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: HVAC (fair) -->
                    <div class="slider-item">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill good">Fair price</div>
                                    <div class="mini-title">AC unit replacement</div>
                                </div>
                                <div class="mini-score-orb good-score">88</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$4,200</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$3,800–$4,500</strong></div>
                                </div>
                                <div class="mini-badge fair-badge">Within market range</div>
                                <div class="mini-notes">
                                    <strong>Good indicators:</strong>
                                    <ul>
                                        <li>Itemized labor and parts</li>
                                        <li>SEER rating clearly specified</li>
                                        <li>Warranty info included</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Plumber (slightly high) -->
                    <div class="slider-item">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill warn">Slightly high</div>
                                    <div class="mini-title">Water heater install</div>
                                </div>
                                <div class="mini-score-orb warn-score">67</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$1,850</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$1,200–$1,600</strong></div>
                                </div>
                                <div class="mini-badge warn-badge">+16% over market</div>
                                <div class="mini-notes">
                                    <strong>Watch out for:</strong>
                                    <ul>
                                        <li>Permit costs not mentioned</li>
                                        <li>Disposal fee unclear</li>
                                        <li>No payment schedule included</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Electrician (expensive) -->
                    <div class="slider-item">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill bad">Overpriced</div>
                                    <div class="mini-title">Panel upgrade + outlets</div>
                                </div>
                                <div class="mini-score-orb bad-score">34</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$5,800</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$3,200–$4,100</strong></div>
                                </div>
                                <div class="mini-badge over-badge">+41% over market</div>
                                <div class="mini-notes">
                                    <strong>Issues detected:</strong>
                                    <ul>
                                        <li>Amp upgrade not specified</li>
                                        <li>City inspection cost missing</li>
                                        <li>Timeline expectations vague</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5: Roofer (fair) -->
                    <div class="slider-item">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill good">Fair price</div>
                                    <div class="mini-title">Roof leak repair</div>
                                </div>
                                <div class="mini-score-orb good-score">82</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$950</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$800–$1,100</strong></div>
                                </div>
                                <div class="mini-badge fair-badge">Within market range</div>
                                <div class="mini-notes">
                                    <strong>Good indicators:</strong>
                                    <ul>
                                        <li>Includes warranty on repairs</li>
                                        <li>Material specs provided</li>
                                        <li>Licensed and insured contractor</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 6: Landscaper (slightly high) -->
                    <div class="slider-item">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill warn">Slightly high</div>
                                    <div class="mini-title">Garden bed installation</div>
                                </div>
                                <div class="mini-score-orb warn-score">71</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$2,400</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$1,800–$2,200</strong></div>
                                </div>
                                <div class="mini-badge warn-badge">+9% over market</div>
                                <div class="mini-notes">
                                    <strong>Minor issues:</strong>
                                    <ul>
                                        <li>Soil type not specified</li>
                                        <li>Plant count seems low</li>
                                        <li>Ask for maintenance plan details</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 7: Moving (extreme ripoff) -->
                    <div class="slider-item">
                        <div class="mini-hero-card">
                            <div class="mini-panel-head">
                                <div>
                                    <div class="pill bad">Extreme ripoff</div>
                                    <div class="mini-title">Local move (2 bedroom)</div>
                                </div>
                                <div class="mini-score-orb bad-score">12</div>
                            </div>
                            <div class="mini-panel-body">
                                <div class="mini-kv">
                                    <div class="mini-data"><span>Quoted</span><strong>$3,200</strong></div>
                                    <div class="mini-data"><span>Fair range</span><strong>$800–$1,200</strong></div>
                                </div>
                                <div class="mini-badge over-badge">+167% over market</div>
                                <div class="mini-notes">
                                    <strong>Critical red flags:</strong>
                                    <ul>
                                        <li>Massive upcharge for local move</li>
                                        <li>No insurance details provided</li>
                                        <li>Hourly rate not disclosed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation arrows -->
                <button class="slider-nav slider-prev" aria-label="Previous slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <button class="slider-nav slider-next" aria-label="Next slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
<section class="stats-strip">
    <div class="container">

        <div class="stats-grid">

            <div class="stat-item">
                <div class="stat-number" data-target="12400" data-suffix="+">0</div>
                <div class="stat-label">Quotes analyzed</div>
            </div>

            <div class="stat-item">
                <div class="stat-number" data-target="1.8" data-prefix="$" data-suffix="M">$0M</div>
                <div class="stat-label">Overpriced quotes flagged</div>
            </div>

            <div class="stat-item">
                <div class="stat-number" data-target="347" data-prefix="$">$0</div>
                <div class="stat-label">Average savings</div>
            </div>

            <div class="stat-item">
                <div class="stat-number" data-target="6200" data-suffix="+">0</div>
                <div class="stat-label">Homeowners helped</div>
            </div>

        </div>

    </div>
</section>
<section class="section section-tight quote-type-section">
    <br />
    <div class="container">
        <div class="section-header compact-center fade-up">
            <h2>Popular quote types we support.</h2>
            <p>Built for the stuff people actually pay for all the time.</p>
        </div>
        <div class="tool-grid">
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
            <a href="/tools/<?= h($key) ?>-quote-checker" class="service-card fade-up stagger-grid">
                <div class="service-icon">
                    <?= $icons[$key] ?? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M12 8v8M8 12h8"/></svg>' ?>
                </div>
                <h3><?= h($label) ?></h3>
                <p>Fair pricing ranges & red flags</p>
                <span class="service-arrow">→</span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>







<section class="section pricing-section-home">
    <div class="container">
        <div class="section-header compact-center fade-up">
            <h2>Don’t overpay by hundreds on your next quote.</h2>
            <p>Try it free, buy one report, compare a few, or go Pro if you use it constantly.</p>
        </div>
        <div class="pricing-grid">
            <a href="/signup" class="price-card price-card-link fade-up stagger-1">
                <div class="pill good">Free</div>
                <h3>Starter</h3>
                <div class="price"><strong>$0</strong><span>new users</span></div>
                <div class="price-list">
                    <div>Up to <?= (int) cfg('trial.free_credits', 2) ?> checks</div>
                    <div>Fair-range verdict</div>
                    <div>Red flags + reply template</div>
                </div>
            </a>
            <a href="/checkout.php?plan=single" class="price-card price-card-link fade-up stagger-2">
                <div class="pill warn">One-off</div>
                <h3>Single report</h3>
                <div class="price">
                    <strong>$<?= number_format(cfg('stripe.single_report_price_cents') / 100, 2) ?></strong><span>one
                        time</span>
                </div>
                <div class="price-list">
                    <div>1 paid check</div>
                    <div>No subscription</div>
                    <div>Fastest unlock</div>
                </div>
            </a>
            <a href="/checkout.php?plan=pack3" class="price-card price-card-link popular fade-up stagger-3">
                <div class="badge-top">Best value</div>
                <div class="pill warn">Bundle</div>
                <h3>3-report pack</h3>
                <div class="price">
                    <strong>$<?= number_format(cfg('stripe.pack_3_price_cents') / 100, 2) ?></strong><span>one
                        time</span>
                </div>
                <div class="price-list">
                    <div>3 credits</div>
                    <div>Perfect for comparing quotes</div>
                    <div>Credits do not expire</div>
                </div>
            </a>
            <a href="/checkout.php?plan=pro" class="price-card price-card-link fade-up stagger-4">
                <div class="pill good">Subscription</div>
                <h3>Pro monthly</h3>
                <div class="price"><strong>$19</strong><span>/month</span></div>
                <div class="price-list">
                    <div><?= (int) cfg('stripe.monthly_subscription_report_credits', 60) ?> checks per month</div>
                    <div>Best for repeat users</div>
                    <div>Cleaner economics than buying singles over and over</div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="section" style="padding-bottom:78px">
    <div class="container card card-soft cta-banner scale-in">
        <div class="cta-badge" style="margin:0 auto 14px">Ready to test it?</div>
        <h2 style="font-size:clamp(2rem,4vw,3rem);margin-bottom:12px">Stop paying the “I didn’t know any better” tax.
        </h2>
        <p class="lead" style="margin:0 auto;max-width:760px">Create an account, use the free checks, and make the
            product prove itself.</p>
        <div class="hero-actions" style="justify-content:center">
            <a href="/signup" class="btn">Get started free</a>
            <a href="/tools" class="btn btn-outline">Browse tool pages</a>
        </div>
    </div>
</section>
<script>
// Intersection Observer for scroll animations
(function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                // Optionally unobserve after animation
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    const animatedElements = document.querySelectorAll('.fade-up, .scale-in');
    animatedElements.forEach(el => observer.observe(el));
})();

// Stats counter animation on scroll
(function() {
    const statsNumbers = document.querySelectorAll('.stat-number[data-target]');

    if (statsNumbers.length === 0) return;

    let hasAnimated = false;

    function animateNumber(element) {
        const target = parseFloat(element.dataset.target);
        const prefix = element.dataset.prefix || '';
        const suffix = element.dataset.suffix || '';
        const duration = 2000; // 2 seconds
        const steps = 60;
        const increment = target / steps;
        const stepDuration = duration / steps;

        let current = 0;

        const timer = setInterval(() => {
            current += increment;

            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            // Format the number
            let displayValue;
            if (suffix === 'M') {
                // For 1.8M, show one decimal
                displayValue = current.toFixed(1);
            } else if (target >= 1000) {
                // For numbers >= 1000, add comma
                displayValue = Math.floor(current).toLocaleString('en-US');
            } else {
                // Regular numbers
                displayValue = Math.floor(current);
            }

            element.textContent = prefix + displayValue + suffix;
        }, stepDuration);
    }

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !hasAnimated) {
                hasAnimated = true;
                // Stagger the animations slightly
                statsNumbers.forEach((num, index) => {
                    setTimeout(() => {
                        animateNumber(num);
                    }, index * 100);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.3
    });

    const statsStrip = document.querySelector('.stats-strip');
    if (statsStrip) {
        statsObserver.observe(statsStrip);
    }
})();

// Hero card score counter animation with color transitions
(function() {
    const scoreOrb = document.getElementById('heroScore');
    const heroPill = document.getElementById('heroPill');

    if (!scoreOrb || !heroPill) return;

    const targetScore = parseInt(scoreOrb.dataset.target) || 28;
    let currentScore = 100;
    const duration = 2000; // 2 seconds
    const startDelay = 800; // Start after initial fade-in
    const steps = 60;
    const decrement = (100 - targetScore) / steps;
    const stepDuration = duration / steps;

    function getScoreColor(score) {
        if (score >= 80) {
            return {
                bg: 'linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)',
                border: 'rgba(34, 197, 94, 0.2)',
                color: '#15803d',
                shadow: 'rgba(34, 197, 94, 0.25)',
                glow: 'rgba(34, 197, 94, 0.15)'
            };
        } else if (score >= 45) {
            return {
                bg: 'linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%)',
                border: 'rgba(245, 158, 11, 0.2)',
                color: '#92400e',
                shadow: 'rgba(245, 158, 11, 0.25)',
                glow: 'rgba(245, 158, 11, 0.15)'
            };
        } else {
            return {
                bg: 'linear-gradient(135deg, #fff5f4 0%, #ffe8e6 100%)',
                border: 'rgba(225, 82, 65, 0.15)',
                color: '#dc2626',
                shadow: 'rgba(225, 82, 65, 0.2)',
                glow: 'rgba(225, 82, 65, 0.15)'
            };
        }
    }

    function getPillState(score) {
        if (score >= 80) {
            return {
                text: 'Fair price',
                className: 'good'
            };
        } else if (score >= 45) {
            return {
                text: 'Slightly high',
                className: 'warn'
            };
        } else {
            return {
                text: 'Likely overpriced',
                className: 'bad'
            };
        }
    }

    function updateScore() {
        const colors = getScoreColor(Math.round(currentScore));
        const pillState = getPillState(Math.round(currentScore));

        // Update score display
        scoreOrb.textContent = Math.round(currentScore);

        // Update colors with smooth transitions
        scoreOrb.style.background = colors.bg;
        scoreOrb.style.borderColor = colors.border;
        scoreOrb.style.color = colors.color;
        scoreOrb.style.boxShadow = `0 6px 20px ${colors.shadow}, inset 0 2px 0 rgba(255, 255, 255, 0.6)`;

        const orbBefore = scoreOrb.querySelector('::before') || scoreOrb;
        if (orbBefore) {
            orbBefore.style.background = `radial-gradient(circle, ${colors.glow}, transparent 70%)`;
        }

        // Update pill
        heroPill.textContent = pillState.text;
        heroPill.className = 'pill ' + pillState.className;

        // Continue countdown
        if (currentScore > targetScore) {
            currentScore -= decrement;
            if (currentScore < targetScore) currentScore = targetScore;
            setTimeout(updateScore, stepDuration);
        }
    }

    // Start animation after delay
    setTimeout(updateScore, startDelay);
})();

// Mockup slider functionality
(function() {
    const sliderTrack = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.slider-item');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');

    if (!sliderTrack || slides.length === 0) return;

    let currentIndex = 0;
    let autoplayInterval;
    let isTransitioning = false;
    const autoplayDelay = 4000; // 4 seconds

    function goToSlide(newIndex) {
        if (newIndex === currentIndex || isTransitioning) return;

        isTransitioning = true;

        // Clean up all slides first
        slides.forEach(slide => {
            slide.classList.remove('exiting');
        });

        // Mark current slide as exiting
        slides[currentIndex].classList.add('exiting');
        slides[currentIndex].classList.remove('active');

        // Small delay to ensure exiting animation starts
        setTimeout(() => {
            // Activate new slide
            currentIndex = newIndex;
            slides[currentIndex].classList.remove('exiting');
            slides[currentIndex].classList.add('active');

            // Add mini animation to the card
            const card = slides[currentIndex].querySelector('.mini-hero-card');
            if (card) {
                card.style.animation = 'none';
                setTimeout(() => {
                    card.style.animation =
                        'cardSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
                }, 10);
            }
        }, 50);

        // Reset transition lock after animation completes
        setTimeout(() => {
            isTransitioning = false;
            // Clean up any lingering exiting classes
            slides.forEach(slide => {
                if (!slide.classList.contains('active')) {
                    slide.classList.remove('exiting');
                }
            });
        }, 550);
    }

    function nextSlide() {
        const newIndex = (currentIndex + 1) % slides.length;
        goToSlide(newIndex);
    }

    function prevSlide() {
        const newIndex = (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(newIndex);
    }

    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, autoplayDelay);
    }

    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }

    function restartAutoplay() {
        stopAutoplay();
        startAutoplay();
    }

    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            restartAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            restartAutoplay();
        });
    }

    // Pause on hover
    sliderTrack.addEventListener('mouseenter', stopAutoplay);
    sliderTrack.addEventListener('mouseleave', startAutoplay);

    // Touch support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    sliderTrack.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
    });

    sliderTrack.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startAutoplay();
    });

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            nextSlide();
        }
        if (touchEndX > touchStartX + 50) {
            prevSlide();
        }
    }

    // Start autoplay
    startAutoplay();
})();

// Video placeholder click-to-play functionality
(function() {
    const videoPlaceholder = document.getElementById('videoPlaceholder');
    const promoVideo = document.getElementById('promoVideo');

    if (!videoPlaceholder || !promoVideo) return;

    videoPlaceholder.addEventListener('click', function() {
        // Hide placeholder
        videoPlaceholder.style.display = 'none';

        // Show and play video
        promoVideo.style.display = 'block';
        promoVideo.play();
    });

    // Optional: Reset to placeholder when video ends
    promoVideo.addEventListener('ended', function() {
        promoVideo.style.display = 'none';
        videoPlaceholder.style.display = 'block';
    });
})();
</script>
<?php include __DIR__.'/partials/footer.php'; ?>
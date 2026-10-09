<?php
require_once __DIR__ . '/../config/bootstrap.php';

$title = 'Complete Site Map - All Pages | Are They Screwing Me?';
$metaDescription = 'Browse our complete sitemap to find mechanic quotes, plumber estimates, contractor pricing tools, helpful guides, and all other pages on Are They Screwing Me.';
$metaKeywords = 'sitemap, site navigation, quote checker tools, pricing guides, all pages';

include __DIR__ . '/partials/header.php';
?>

<section class="hero-simple compact-hero">
    <div class="container narrow">
        <span class="eyebrow">Site Navigation</span>
        <h1>Sitemap</h1>
        <p class="lead">Browse all pages and tools available on Are They Screwing Me. Find quote checkers, pricing
            guides, and helpful resources.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto;">

            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; font-weight: 700; color: var(--text);">Main Pages
                </h3>
                <ul class="clean-list" style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="/" style="color: var(--text-soft); transition: color 0.2s;">Home</a></li>
                    <li><a href="/upload" style="color: var(--text-soft); transition: color 0.2s;">Upload & Analyze
                            Quote</a></li>
                    <li><a href="/pricing" style="color: var(--text-soft); transition: color 0.2s;">Pricing Plans</a>
                    </li>
                    <li><a href="/signup" style="color: var(--text-soft); transition: color 0.2s;">Sign Up Free</a></li>
                    <li><a href="/login" style="color: var(--text-soft); transition: color 0.2s;">Login</a></li>
                    <li><a href="/dashboard" style="color: var(--text-soft); transition: color 0.2s;">Dashboard</a></li>
                </ul>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; font-weight: 700; color: var(--text);">Quote Checker
                    Tools</h3>
                <ul class="clean-list" style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="/tools" style="color: var(--text-soft); transition: color 0.2s;">All Tools</a></li>
                    <li><a href="/tools/mechanic-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Mechanic Quote Checker</a></li>
                    <li><a href="/tools/plumber-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Plumber Quote Checker</a></li>
                    <li><a href="/tools/electrician-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Electrician Quote Checker</a></li>
                    <li><a href="/tools/contractor-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Contractor Quote Checker</a></li>
                    <li><a href="/tools/hvac-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">HVAC Quote Checker</a></li>
                    <li><a href="/tools/appliance-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Appliance Quote Checker</a></li>
                    <li><a href="/tools/roofer-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Roofer Quote Checker</a></li>
                    <li><a href="/tools/landscaper-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Landscaper Quote Checker</a></li>
                    <li><a href="/tools/pest-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Pest Control Quote Checker</a></li>
                    <li><a href="/tools/moving-quote-checker"
                            style="color: var(--text-soft); transition: color 0.2s;">Moving Quote Checker</a></li>
                </ul>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; font-weight: 700; color: var(--text);">Helpful Guides
                </h3>
                <ul class="clean-list" style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="/guides" style="color: var(--text-soft); transition: color 0.2s;">All Guides</a></li>
                    <li><a href="/guides/how-to-read-mechanic-estimate"
                            style="color: var(--text-soft); transition: color 0.2s;">How to Read a Mechanic Estimate</a>
                    </li>
                    <li><a href="/guides/how-to-spot-overpriced-contractors"
                            style="color: var(--text-soft); transition: color 0.2s;">How to Spot Overpriced
                            Contractors</a></li>
                    <li><a href="/guides/how-to-negotiate-repair-quotes"
                            style="color: var(--text-soft); transition: color 0.2s;">How to Negotiate Repair Quotes</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; font-weight: 700; color: var(--text);">Cost & Pricing Guides</h3>
                <ul class="clean-list" style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="/plumber-cost" style="color: var(--text-soft); transition: color 0.2s;">Plumber Cost Guide</a></li>
                    <li><a href="/hvac-repair-cost" style="color: var(--text-soft); transition: color 0.2s;">HVAC Repair Cost Guide</a></li>
                    <li><a href="/mechanic-repair-cost" style="color: var(--text-soft); transition: color 0.2s;">Mechanic Repair Cost Guide</a></li>
                    <li><a href="/roof-repair-cost" style="color: var(--text-soft); transition: color 0.2s;">Roof Repair Cost Guide</a></li>
                    <li><a href="/contractor-estimate" style="color: var(--text-soft); transition: color 0.2s;">Contractor Estimate Guide</a></li>
                    <li><a href="/repair-estimate" style="color: var(--text-soft); transition: color 0.2s;">Repair Estimate Guide</a></li>
                    <li><a href="/auto-repair-estimate" style="color: var(--text-soft); transition: color 0.2s;">Auto Repair Estimate Guide</a></li>
                    <li><a href="/plumbing-inspection-cost" style="color: var(--text-soft); transition: color 0.2s;">Plumbing Inspection Cost Guide</a></li>
                    <li><a href="/car-repair-estimate" style="color: var(--text-soft); transition: color 0.2s;">Car Repair Estimate Guide</a></li>
                    <li><a href="/contractor-cost-estimator" style="color: var(--text-soft); transition: color 0.2s;">Contractor Cost Estimator</a></li>
                </ul>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; font-weight: 700; color: var(--text);">Legal &
                    Support</h3>
                <ul class="clean-list" style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="/terms" style="color: var(--text-soft); transition: color 0.2s;">Terms of Service</a>
                    </li>
                    <li><a href="/privacy" style="color: var(--text-soft); transition: color 0.2s;">Privacy Policy</a>
                    </li>
                    <li><a href="mailto:help@aretheyscrewingme.com"
                            style="color: var(--text-soft); transition: color 0.2s;">Email Support</a></li>
                </ul>
            </div>



        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
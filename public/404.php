<?php
http_response_code(404);
require_once __DIR__ . '/../config/bootstrap.php';

$title = 'Page Not Found (404) | Are They Screwing Me?';
$metaDescription = 'The page you are looking for could not be found. Check out our quote analysis tools or return to the homepage.';
$metaKeywords = '404, page not found, error';

include __DIR__ . '/partials/header.php';
?>

<section class="hero-simple" style="padding: 80px 0 60px;">
    <div class="container" style="max-width: 700px; margin: 0 auto; text-align: center;">
        <div
            style="font-size: clamp(80px, 15vw, 140px); font-weight: 900; line-height: 1; background: linear-gradient(135deg, var(--blue) 0%, var(--purple) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 24px;">
            404</div>
        <h1 style="margin-bottom: 16px; font-size: clamp(1.8rem, 5vw, 2.4rem); margin-left: auto; margin-right: auto;">
            Page Not Found</h1>
        <p class="lead" style="margin-bottom: 40px; max-width: 500px; margin-left: auto; margin-right: auto;">Sorry, the
            page you're looking for doesn't exist or has been moved.</p>

        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 56px;">
            <a href="/" class="btn" style="text-decoration: none;">Go to Homepage</a>
            <a href="/upload" class="btn btn-secondary" style="text-decoration: none;">Analyze a Quote</a>
        </div>

        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; text-align: center; font-weight: 700;">Quick Links</h3>
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; text-align: left;">
                <a href="/tools"
                    style="color: var(--text-soft); transition: color 0.2s; padding: 8px 12px; border-radius: 8px; background: var(--surface-alt); display: block;">Quote
                    Checker Tools</a>
                <a href="/pricing"
                    style="color: var(--text-soft); transition: color 0.2s; padding: 8px 12px; border-radius: 8px; background: var(--surface-alt); display: block;">Pricing</a>
                <a href="/guides"
                    style="color: var(--text-soft); transition: color 0.2s; padding: 8px 12px; border-radius: 8px; background: var(--surface-alt); display: block;">Helpful
                    Guides</a>
                <a href="/signup"
                    style="color: var(--text-soft); transition: color 0.2s; padding: 8px 12px; border-radius: 8px; background: var(--surface-alt); display: block;">Sign
                    Up Free</a>
                <a href="/login"
                    style="color: var(--text-soft); transition: color 0.2s; padding: 8px 12px; border-radius: 8px; background: var(--surface-alt); display: block;">Login</a>
                <a href="/sitemap"
                    style="color: var(--text-soft); transition: color 0.2s; padding: 8px 12px; border-radius: 8px; background: var(--surface-alt); display: block;">Complete
                    Sitemap</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
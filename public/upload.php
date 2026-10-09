<?php
use QuoteCheck\OpenAIService;
use QuoteCheck\PricingEngine;
use QuoteCheck\QuoteAnalyzer;

require_once __DIR__ . '/../config/bootstrap.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    rate_limit_or_fail('upload', (int)cfg('security.upload_limit_per_hour', 20), 3600, $auth->id());
    if (!$csrf->verify($_POST['_csrf'] ?? null)) {
        set_flash('error', 'Session expired. Try again.');
        redirect('/upload');
    }
    verify_turnstile_or_fail($_POST['cf-turnstile-response'] ?? null);
    $categories = array_keys(quote_categories());
    $category = (string)($_POST['category'] ?? 'mechanic');
    $zip = preg_replace('/[^0-9]/', '', (string)($_POST['zip_code'] ?? ''));
    $pasted = trim((string)($_POST['quote_text'] ?? ''));
    if ($zip === '' || !in_array($category, $categories, true)) {
        set_flash('error', 'Pick a category and enter a ZIP code.');
        redirect('/upload');
    }

    try {
        $openAI = new OpenAIService(cfg('openai.api_key'), cfg('openai.model'));
        $pricing = new PricingEngine($pdo);
        $analyzer = new QuoteAnalyzer($openAI, $pricing);
        $extracted = $analyzer->extractText($_FILES['quote_file'] ?? null, $pasted);

        $stmt = $pdo->prepare('INSERT INTO reports (user_id, category, zip_code, analysis_status, raw_text, uploaded_file_path, uploaded_original_name) VALUES (:user_id, :category, :zip_code, :analysis_status, :raw_text, :uploaded_file_path, :uploaded_original_name)');
        $stmt->execute([
            'user_id' => $auth->id(),
            'category' => $category,
            'zip_code' => $zip,
            'analysis_status' => 'queued',
            'raw_text' => $extracted['text'],
            'uploaded_file_path' => $extracted['stored_path'],
            'uploaded_original_name' => $extracted['original_name'],
        ]);

        $reportId = (int)$pdo->lastInsertId();
        redirect('/analyze?id=' . $reportId);
    } catch (Throwable $e) {
        \QuoteCheck\Helpers::logThrowable($e);
        set_flash('error', $e->getMessage());
        redirect('/upload');
    }
}
$title='Upload Quote - Instant Price Analysis | Are They Screwing Me?';
$metaDescription='Upload your repair quote, estimate, or invoice for instant AI-powered price analysis. Check mechanic, plumber, contractor, HVAC, and service quotes in under a minute.';
$metaKeywords='upload quote, analyze estimate, repair quote upload, price check tool, quote analysis, estimate checker';
include __DIR__.'/partials/header.php';
?>
<section class="hero-simple compact-hero">
    <div class="container narrow">
        <span class="eyebrow">Fast upload. Clear answer.</span>
        <h1>Analyze the quote that’s making you suspicious.</h1>
        <p class="lead">Upload a PDF or image, add the ZIP code, choose the category, and get a verdict that’s actually
            useful.</p>
    </div>
</section>
<section class="section section-tight">
    <div class="container split-upload">
        <div class="card card-soft">
            <h2>Supported quote types</h2>
            <div class="chips-grid">
                <?php foreach (quote_categories() as $key => $label): ?>
                <span class="chip" data-category="<?= h($key) ?>"><?= h($label) ?></span>
                <?php endforeach; ?>
            </div>
            <div class="callout" style="margin-top:18px"><strong>Supported files:</strong> PDF, PNG, JPG, WEBP, and TXT.
                Keep uploads under <?= (int)cfg('security.max_upload_mb', 8) ?>MB.</div>
        </div>
        <div class="card auth-card">
            <h2>Run an analysis</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="_csrf" value="<?= h($csrf->token()) ?>">
                <div class="field">
                    <label>Category</label>
                    <select name="category" id="categorySelect" required>
                        <?php foreach (quote_categories() as $key => $label): ?>
                        <option value="<?= h($key) ?>"><?= h($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field"><label>ZIP code</label><input name="zip_code" maxlength="10" required
                        placeholder="08857"></div>
                <div class="field">
                    <label>Upload file</label>
                    <div class="file-drop" id="fileDrop">
                        <strong id="fileDropLabel">Drag & drop your quote here or click to browse</strong>
                        <div class="muted small" style="margin:8px 0 14px" id="fileDropHint">PDF, invoice screenshot,
                            estimate photo, or text file</div>
                        <input type="file" name="quote_file" id="fileInput" accept=".pdf,.png,.jpg,.jpeg,.webp,.txt"
                            style="display: none;">
                    </div>
                </div>
                <div class="field"><label>Paste quote text instead / in addition</label><textarea name="quote_text"
                        placeholder="Paste the estimate, invoice, or notes here..."></textarea></div>
                <?php if (cfg('turnstile.enabled', false)): ?>
                <div class="field">
                    <div class="cf-turnstile" data-sitekey="<?= h((string)cfg('turnstile.site_key', '')) ?>"></div>
                </div>
                <?php endif; ?>
                <button class="btn btn-block" type="submit" id="analyzeBtn">
                    <span id="btnText">Analyze this quote</span>
                </button>
            </form>
        </div>
    </div>
</section>
<script>
(function() {
    const categorySelect = document.getElementById('categorySelect');
    const chips = document.querySelectorAll('.chip[data-category]');
    const form = document.querySelector('.split-upload form');

    // Function to update active chip based on select value
    function updateActiveChip(value) {
        chips.forEach(chip => {
            if (chip.dataset.category === value) {
                chip.classList.add('active');
            } else {
                chip.classList.remove('active');
            }
        });
    }

    // Handle chip clicks
    chips.forEach(chip => {
        chip.addEventListener('click', function() {
            const category = this.dataset.category;
            categorySelect.value = category;
            updateActiveChip(category);
        });
    });

    // Handle select change
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            updateActiveChip(this.value);
        });
    }

    // Check for URL parameter and pre-select category
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    if (categoryParam && categorySelect) {
        categorySelect.value = categoryParam;
        updateActiveChip(categoryParam);
    } else if (categorySelect) {
        // Initialize with current select value
        updateActiveChip(categorySelect.value);
    }

    // Handle form submission with spinner
    if (form) {
        form.addEventListener('submit', function(e) {
            const btn = document.getElementById('analyzeBtn');
            const btnText = document.getElementById('btnText');

            if (btn && btnText) {
                btn.classList.add('loading');
                btn.disabled = true;
                btn.style.opacity = '0.8';
                btn.style.pointerEvents = 'none';
                btnText.innerHTML = 'Analyzing... <span class="btn-spinner"></span>';
            }
        });
    }

    // Drag and drop file upload functionality
    const fileDrop = document.getElementById('fileDrop');
    const fileInput = document.getElementById('fileInput');
    const fileDropLabel = document.getElementById('fileDropLabel');
    const fileDropHint = document.getElementById('fileDropHint');

    if (fileDrop && fileInput) {
        // Click anywhere in the drop zone to open file picker
        fileDrop.addEventListener('click', function() {
            fileInput.click();
        });

        // Update label when file is selected
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const fileName = this.files[0].name;
                fileDropLabel.textContent = fileName;
                fileDropHint.textContent = 'File selected. Ready to analyze!';
                fileDrop.classList.add('file-selected');
            }
        });

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileDrop.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Highlight drop zone when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            fileDrop.addEventListener(eventName, function() {
                fileDrop.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileDrop.addEventListener(eventName, function() {
                fileDrop.classList.remove('drag-over');
            });
        });

        // Handle dropped files
        fileDrop.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files && files.length > 0) {
                // Transfer dropped file to the input element
                fileInput.files = files;

                // Trigger change event to update UI
                const event = new Event('change', {
                    bubbles: true
                });
                fileInput.dispatchEvent(event);
            }
        });
    }
})();
</script>

<?php include __DIR__.'/partials/footer.php'; ?>
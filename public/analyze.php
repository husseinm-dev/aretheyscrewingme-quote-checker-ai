<?php
use QuoteCheck\OpenAIService;
use QuoteCheck\PricingEngine;
use QuoteCheck\QuoteAnalyzer;
use QuoteCheck\TrialGuard;

require_once __DIR__ . '/../config/bootstrap.php';
require_login();
// Temporarily disabled rate limiting for development
// rate_limit_or_fail('analyze', (int)cfg('security.analyze_limit_per_hour', 12), 3600, $auth->id());
$reportId = (int)($_GET['id'] ?? 0);
$user = $auth->user();
$stmt = $pdo->prepare('SELECT * FROM reports WHERE id = :id AND user_id = :user_id LIMIT 1');
$stmt->execute(['id' => $reportId, 'user_id' => $user['id']]);
$report = $stmt->fetch();
if (!$report) {
    set_flash('error', 'Report not found.');
    redirect('/dashboard');
}
if ($report['analysis_status'] === 'complete') {
    redirect('/result?id=' . $reportId);
}

// Check if credit was already consumed for this report
if ($report['used_credit_type']) {
    // Already consumed, allow retry without charging again
    $usedType = $report['used_credit_type'];
} else {
    // First attempt - check if user has credits but don't consume yet
    $hasCredit = (int)$user['free_credits_remaining'] > 0 || (int)$user['paid_credits_remaining'] > 0;
    if (!$hasCredit) {
        redirect('/checkout?id=' . $reportId);
    }
    $usedType = null; // Will be set after successful analysis
}

// Show loading page first, then process
$shouldProcess = isset($_GET['process']) && $_GET['process'] === '1';

if (!$shouldProcess) {
    // Show loading page with progress modal
    $title = 'Analyzing Quote... | Are They Screwing Me?';
    $metaDescription = 'Analyzing your quote with AI-powered price intelligence.';
    $metaKeywords = 'quote analysis, price check';
    include __DIR__.'/partials/header.php';
    ?>
<div id="progressModal" class="progress-modal active">
    <div class="progress-modal-content">
        <div class="progress-bar-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>
        <div class="progress-modal-icon">
            <div class="spinner-large"></div>
        </div>
        <h2 id="progressTitle">Analyzing with AI...</h2>
        <p id="progressMessage" class="muted">Processing your quote and checking market prices</p>
        <div class="progress-steps">
            <div class="progress-step complete" id="step1">
                <div class="progress-step-icon"></div>
                <div class="progress-step-text">Quote received</div>
            </div>
            <div class="progress-step active" id="step2">
                <div class="progress-step-icon"><svg width="20" height="20" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9" fill="none" stroke="currentColor" stroke-width="2" />
                    </svg></div>
                <div class="progress-step-text">AI analyzing pricing</div>
            </div>
            <div class="progress-step" id="step3">
                <div class="progress-step-icon"><svg width="20" height="20" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9" fill="none" stroke="currentColor" stroke-width="2" />
                    </svg></div>
                <div class="progress-step-text">Checking red flags</div>
            </div>
            <div class="progress-step" id="step4">
                <div class="progress-step-icon"><svg width="20" height="20" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9" fill="none" stroke="currentColor" stroke-width="2" />
                    </svg></div>
                <div class="progress-step-text">Finalizing report</div>
            </div>
        </div>
        <p class="muted small" style="margin-top: 24px; font-size: 0.875rem;">This may take up to 60 seconds...</p>
    </div>
</div>

<style>
.progress-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.progress-modal.active {
    display: flex;
}

.progress-modal-content {
    background: var(--surface);
    border: 1.5px solid rgba(226, 231, 239, 0.8);
    border-radius: var(--radius-lg);
    padding: 0;
    max-width: 500px;
    width: 90%;
    text-align: center;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
}

.progress-bar-container {
    width: 100%;
    height: 4px;
    background: var(--line);
    position: relative;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--blue) 0%, #60a5fa 100%);
    width: 0%;
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-modal-icon {
    margin-bottom: 24px;
    padding-top: 48px;
}

.spinner-large {
    width: 48px;
    height: 48px;
    margin: 0 auto;
    border: 3px solid var(--line);
    border-top-color: var(--blue);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

#progressTitle {
    font-size: 1.5rem;
    margin: 0 0 8px;
    font-weight: 650;
    color: var(--text);
    letter-spacing: -0.02em;
}

#progressMessage {
    margin: 0 0 32px;
    font-size: 0.9375rem;
    color: var(--muted);
    padding: 0 40px;
}

.progress-steps {
    display: flex;
    flex-direction: column;
    gap: 12px;
    text-align: left;
    padding: 0 40px 48px 40px;
}

.progress-step {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
    background: transparent;
    border: 1.5px solid transparent;
    border-radius: var(--radius-sm);
    opacity: 0.3;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-step.active {
    opacity: 1;
    background: var(--blue-soft);
    border-color: rgba(59, 130, 246, 0.3);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.02);
    }
}

.progress-step.complete {
    opacity: 1;
    background: var(--surface);
    border-color: transparent;
    animation: none;
}

.progress-step-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted-light);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
}

.progress-step.active .progress-step-icon {
    color: var(--blue);
}

.progress-step.complete .progress-step-icon svg {
    display: none;
}

.progress-step.complete .progress-step-icon::after {
    content: '✓';
    font-size: 18px;
    font-weight: 700;
    color: var(--green);
    animation: checkmark-pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes checkmark-pop {
    0% {
        transform: scale(0);
        opacity: 0;
    }

    50% {
        transform: scale(1.2);
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.progress-step-text {
    font-weight: 500;
    font-size: 0.9375rem;
    color: var(--muted-light);
    letter-spacing: -0.01em;
    transition: color 0.3s ease;
}

.progress-step.active .progress-step-text {
    color: var(--text);
}

.progress-step.complete .progress-step-text {
    color: var(--text-soft);
}

@media (max-width: 600px) {
    .progress-modal-content {
        padding: 36px 28px;
    }

    #progressTitle {
        font-size: 1.375rem;
    }

    #progressMessage {
        font-size: 0.875rem;
    }

    .progress-step {
        padding: 12px 14px;
        gap: 12px;
    }

    .progress-step-text {
        font-size: 0.875rem;
    }

    .progress-steps {
        padding: 0 28px 36px 28px;
    }

    #progressMessage {
        padding: 0 28px;
    }
}
</style>

<script>
// Animate progress steps while processing
(function() {
    const steps = [{
            id: 'step2',
            title: 'Analyzing with AI...',
            message: 'Reviewing market prices and comparing',
            duration: 8000
        },
        {
            id: 'step3',
            title: 'Checking red flags...',
            message: 'Identifying potential overcharges',
            duration: 8000
        },
        {
            id: 'step4',
            title: 'Finalizing report...',
            message: 'Preparing your results',
            duration: 5000
        }
    ];

    let currentStepIndex = 0;
    const titleEl = document.getElementById('progressTitle');
    const messageEl = document.getElementById('progressMessage');

    function activateStep(index) {
        if (index >= steps.length) return;

        const step = steps[index];
        const stepEl = document.getElementById(step.id);
        const progressBar = document.getElementById('progressBar');

        // Mark previous as complete
        if (index > 0) {
            const prevStep = document.getElementById(steps[index - 1].id);
            if (prevStep) {
                prevStep.classList.remove('active');
                prevStep.classList.add('complete');
            }
        }

        // Activate current
        if (stepEl) {
            stepEl.classList.add('active');
            titleEl.textContent = step.title;
            messageEl.textContent = step.message;
        }

        // Update progress bar (step1 is already complete, so index 0 = step2 = 50%)
        const progress = ((index + 2) / (steps.length + 1)) * 100;
        if (progressBar) progressBar.style.width = progress + '%';
    }

    // Initialize progress bar (step1 already complete = 25%)
    const progressBar = document.getElementById('progressBar');
    if (progressBar) progressBar.style.width = '25%';


    // Actually trigger the processing
    setTimeout(function() {
        window.location.href = '/analyze?id=<?= $reportId ?>&process=1';
    }, 500);
})();
</script>

<?php
    include __DIR__.'/partials/footer.php';
    exit;
}

// Process the analysis
try {
    $openAI = new OpenAIService(cfg('openai.api_key'), cfg('openai.model'));
    $pricing = new PricingEngine($pdo);
    $analyzer = new QuoteAnalyzer($openAI, $pricing);
    $result = $analyzer->run((string)$report['raw_text'], (string)$report['category'], (string)$report['zip_code']);

    // Analysis succeeded - NOW consume the credit if not already consumed
    if (!$report['used_credit_type']) {
        if ((int)$user['free_credits_remaining'] > 0) {
            $guard = new TrialGuard($pdo, cfg('app_key'), cfg('trial.cookie_name'), (int)cfg('trial.cookie_days'));
            if ($guard->consumeFreeCredit((int)$user['id'])) {
                $usedType = 'free';
            }
        }
        if ($usedType === null && (int)$user['paid_credits_remaining'] > 0) {
            $usePaid = $pdo->prepare('UPDATE users SET paid_credits_remaining = paid_credits_remaining - 1 WHERE id = :id AND paid_credits_remaining > 0');
            $usePaid->execute(['id' => $user['id']]);
            if ($usePaid->rowCount() > 0) {
                $usedType = 'paid';
            }
        }
        if ($usedType === null) {
            // Edge case: credits disappeared between check and consumption
            redirect('/checkout?id=' . $reportId);
        }
    } else {
        // Use the already-consumed credit type
        $usedType = $report['used_credit_type'];
    }

    $update = $pdo->prepare('UPDATE reports SET analysis_status = :analysis_status, score = :score, used_credit_type = :used_credit_type, service_key = :service_key, service_label = :service_label, quoted_price = :quoted_price, fair_low = :fair_low, fair_high = :fair_high, overpriced_percent = :overpriced_percent, result_json = :result_json WHERE id = :id');
    $update->execute([
        'analysis_status' => 'complete',
        'score' => $result['score'],
        'used_credit_type' => $usedType,
        'service_key' => $result['service_key'],
        'service_label' => $result['service_label'],
        'quoted_price' => $result['quoted_price'],
        'fair_low' => $result['fair_low'],
        'fair_high' => $result['fair_high'],
        'overpriced_percent' => $result['overpriced_percent'],
        'result_json' => json_encode($result),
        'id' => $reportId,
    ]);

    set_flash('success', 'Analysis complete.');
    redirect('/result?id=' . $reportId);
} catch (Throwable $e) {
    \QuoteCheck\Helpers::logThrowable($e);
    $pdo->prepare('UPDATE reports SET analysis_status = :status WHERE id = :id')->execute(['status' => 'failed', 'id' => $reportId]);
    
    // Determine error type for better messaging
    $errorMsg = $e->getMessage();
    if (strpos($errorMsg, 'timed out') !== false || strpos($errorMsg, 'timeout') !== false) {
        set_flash('error', 'Analysis timed out. Our AI service is taking longer than expected. Please try again - you have not been charged.');
    } elseif (strpos($errorMsg, 'OpenAI') !== false) {
        set_flash('error', 'AI service temporarily unavailable. Please try again in a moment - you have not been charged.');
    } else {
        set_flash('error', 'Analysis failed. Please try again or use a clearer file/text - you have not been charged.');
    }
    
    redirect('/result?id=' . $reportId);
}
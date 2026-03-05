{{-- resources/views/student/admission/payment/iframe.blade.php --}}
@extends('admin.admin_dashboard')

@section('title', 'Complete Payment')

@section('admin')

<style>
    :root {
        --primary: #3b2818;
        --primary-light: #5a3d2b;
        --primary-dark: #2a1a0f;
        --accent: #f9a90f;
        --success: #099139;
        --danger: #b3261e;
        --border-light: #e8e8e8;
        --shadow-md: 0 6px 18px rgba(59, 40, 24, 0.08);
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-sm: 8px;
    }

    .payment-page {
        max-width: 960px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    /* ── Breadcrumb ── */
    .breadcrumb-wrap {
        margin-bottom: 1.25rem;
    }

    /* ── Summary Card ── */
    .summary-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .summary-card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: #fff;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .summary-card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    .summary-card-header .amount-badge {
        background: var(--accent);
        color: #000;
        font-weight: 800;
        font-size: 1.1rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .summary-card-body {
        padding: 1rem 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem 1.5rem;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .summary-item .s-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #858585;
        font-weight: 500;
    }

    .summary-item .s-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--primary);
    }

    /* ── Gateway Card ── */
    .gateway-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .gateway-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: #fafafa;
    }

    .gateway-card-header h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .gateway-badge {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: var(--success);
        font-weight: 600;
    }

    .gateway-badge i {
        font-size: 0.85rem;
    }

    /* ── Launch Button ── */
    .launch-section {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #fffdf8, #fff);
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .launch-section p {
        margin: 0;
        font-size: 0.88rem;
        color: #858585;
        max-width: 480px;
    }

    .btn-launch {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-launch:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59,40,24,0.25);
    }

    .btn-launch:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* ── iFrame Container ── */
    .iframe-container {
        position: relative;
        background: #f5f5f5;
    }

    .iframe-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        color: #aaa;
        text-align: center;
        gap: 0.75rem;
    }

    .iframe-placeholder i {
        font-size: 3rem;
        color: var(--border-light);
    }

    .iframe-placeholder p {
        margin: 0;
        font-size: 0.95rem;
    }

    #payment-iframe {
        width: 100%;
        height: 680px;
        border: none;
        display: none; /* hidden until form submitted */
    }

    /* ── Security Footer ── */
    .security-footer {
        padding: 0.75rem 1.5rem;
        background: #fafafa;
        border-top: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .security-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.78rem;
        color: #858585;
    }

    .security-item i {
        color: var(--success);
        font-size: 0.85rem;
    }

    /* ── Alert info ── */
    .alert-info-custom {
        background: rgba(249,169,15,0.1);
        border-left: 4px solid var(--accent);
        border-radius: var(--radius-sm);
        padding: 0.75rem 1rem;
        font-size: 0.88rem;
        color: var(--primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 640px) {
        .payment-page { padding: 1rem 0.75rem; }
        .summary-card-header { flex-direction: column; align-items: flex-start; }
        .launch-section { flex-direction: column; }
        .btn-launch { width: 100%; justify-content: center; }
        #payment-iframe { height: 580px; }
    }
</style>

<div class="page-content">
<div class="payment-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('student.student_dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('student.fees.index') }}">Fees</a>
                </li>
                <li class="breadcrumb-item active">Complete Payment</li>
            </ol>
        </nav>
    </div>

    {{-- Session info --}}
    @if(session('info'))
        <div class="alert-info-custom">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
        </div>
    @endif

    {{-- Payment Summary --}}
    <div class="summary-card">
        <div class="summary-card-header">
            <h5><i class="fas fa-receipt me-2"></i>Payment Summary</h5>
            <span class="amount-badge">KES {{ number_format($amountExpected, 2) }}</span>
        </div>
        <div class="summary-card-body">
            <div class="summary-item">
                <span class="s-label">Student Name</span>
                <span class="s-value">{{ $clientName }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">ID Number</span>
                <span class="s-value">{{ $clientIDNumber }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">Email</span>
                <span class="s-value">{{ $clientEmail }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">Phone</span>
                <span class="s-value">{{ $clientMSISDN ?: '—' }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">Reference No.</span>
                <span class="s-value">{{ $billRefNumber }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">Description</span>
                <span class="s-value">{{ $billDesc }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">Invoice No.</span>
                <span class="s-value">{{ $invoice->invoice_number ?? '—' }}</span>
            </div>
            <div class="summary-item">
                <span class="s-label">Amount</span>
                <span class="s-value" style="color:var(--danger);font-size:1.05rem;">
                    KES {{ number_format($amountExpected, 2) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Gateway Card --}}
    <div class="gateway-card">

        <div class="gateway-card-header">
            <h6><i class="fas fa-university"></i> eCitizen Payment Gateway</h6>
            <div class="gateway-badge">
                <i class="fas fa-shield-alt"></i> Secure SSL Connection
            </div>
        </div>

        {{-- Hidden form that posts to eCitizen --}}
        <form
            id="paymentForm"
            action="https://payments.ecitizen.go.ke/PaymentAPI/iframev2.1.php"
            method="POST"
            target="my_iframe"
        >
            <input type="hidden" name="secureHash"           value="{{ $my_secureHash }}">
            <input type="hidden" name="apiClientID"          value="{{ $apiClientID }}">
            <input type="hidden" name="sendSTK"              value="True">
            <input type="hidden" name="format"               value="iframe">
            <input type="hidden" name="billDesc"             value="{{ $billDesc }}">
            <input type="hidden" name="billRefNumber"        value="{{ $billRefNumber }}">
            <input type="hidden" name="currency"             value="KES">
            <input type="hidden" name="serviceID"            value="{{ $serviceID }}">
            <input type="hidden" name="clientMSISDN"         value="{{ $clientMSISDN }}">
            <input type="hidden" name="clientName"           value="{{ $clientName }}">
            <input type="hidden" name="clientIDNumber"       value="{{ $clientIDNumber }}">
            <input type="hidden" name="clientEmail"          value="{{ $clientEmail }}">
            <input type="hidden" name="callBackURLOnSuccess" value="{{ $callBackURLOnSuccess }}">
            <input type="hidden" name="notificationURL"      value="{{ $notificationURL }}">
            <input type="hidden" name="amountExpected"       value="{{ $amountExpected }}">

            <div class="launch-section">
                <p>
                    <i class="fas fa-info-circle me-1" style="color:var(--accent)"></i>
                    Click the button to load the secure payment form. You will receive an
                    M-Pesa STK push on <strong>{{ $clientMSISDN ?: 'your registered phone' }}</strong>.
                </p>
                <button type="submit" class="btn-launch" id="launchBtn">
                    <i class="fas fa-lock"></i>
                    Launch Payment Form
                </button>
            </div>
        </form>

        {{-- iFrame renders here after form submit --}}
        <div class="iframe-container">
            <div class="iframe-placeholder" id="iframePlaceholder">
                <i class="fas fa-mobile-alt"></i>
                <p>The payment form will appear here after you click <strong>Launch Payment Form</strong>.</p>
            </div>
            <iframe
                name="my_iframe"
                id="payment-iframe"
                title="eCitizen Payment Gateway"
                allowpaymentrequest
            ></iframe>
        </div>

        <div class="security-footer">
            <div class="security-item"><i class="fas fa-lock"></i> 256-bit SSL Encryption</div>
            <div class="security-item"><i class="fas fa-shield-alt"></i> Verified by eCitizen</div>
            <div class="security-item"><i class="fas fa-university"></i> Pesaflow Secure Gateway</div>
        </div>

    </div>

</div>
</div>

<script>
    document.getElementById('paymentForm').addEventListener('submit', function () {
        const btn     = document.getElementById('launchBtn');
        const iframe  = document.getElementById('payment-iframe');
        const holder  = document.getElementById('iframePlaceholder');

        // Show iframe, hide placeholder
        holder.style.display  = 'none';
        iframe.style.display  = 'block';

        // Disable button to prevent double submission
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading Gateway...';

        // Re-enable after 5s in case of network issues
        setTimeout(function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-redo"></i> Reload Payment Form';
        }, 5000);
    });
</script>

@endsection
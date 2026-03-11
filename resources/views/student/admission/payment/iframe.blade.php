@extends('admin.admin_dashboard')
@section('title', 'Fee Payment')
@section('admin')

<style>
    :root {
        --primary: #3b2818;
        --primary-dark: #2a1a0f;
        --accent: #f9a90f;
        --border-light: #e8e8e8;
        --shadow-md: 0 6px 18px rgba(59,40,24,0.08);
        --radius-lg: 16px;
        --radius-md: 12px;
    }

    .iframe-page {
        padding: 1.5rem;
        max-width: 960px;
        margin: 0 auto;
    }

    /* ── Top summary bar ── */
    .payment-summary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.75rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
        box-shadow: var(--shadow-md);
    }

    .payment-summary .summary-left h5 {
        margin: 0 0 0.2rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
    }

    .payment-summary .summary-left p {
        margin: 0;
        font-size: 0.88rem;
        opacity: 0.85;
    }

    .payment-summary .summary-amount {
        text-align: right;
    }

    .payment-summary .summary-amount .label {
        font-size: 0.8rem;
        opacity: 0.75;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .payment-summary .summary-amount .value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--accent);
        line-height: 1;
    }

    /* ── Status bar ── */
    .payment-status-bar {
        background: rgba(249,169,15,0.1);
        border: 1px solid rgba(249,169,15,0.3);
        border-radius: var(--radius-md);
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        color: var(--primary);
        font-weight: 600;
    }

    .payment-status-bar .spinner-border {
        width: 1.1rem;
        height: 1.1rem;
        border-width: 2px;
        color: var(--accent);
    }

    /* ── Iframe wrapper ── */
    .iframe-wrapper {
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        min-height: 680px;
    }

    .iframe-wrapper iframe {
        width: 100%;
        height: 680px;
        border: none;
        display: block;
    }

    /* ── Security footer ── */
    .security-footer {
        text-align: center;
        padding: 1rem 0 0.5rem;
        font-size: 0.82rem;
        color: #888;
    }

    .security-footer i { color: #099139; margin-right: 4px; }

    /* ── Hidden form ── */
    #pesaflowForm { display: none; }

    @media (max-width: 575px) {
        .iframe-page { padding: 0.75rem; }
        .payment-summary { flex-direction: column; text-align: center; }
        .payment-summary .summary-amount { text-align: center; }
        .iframe-wrapper iframe { height: 580px; }
    }
</style>

<div class="page-content">
<div class="iframe-page">

    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Payments</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.student_dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.fees.index') }}">Fees</a>
                    </li>
                    <li class="breadcrumb-item active">Pay Now</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Summary bar ── shows invoice details at a glance ── --}}
    <div class="payment-summary">
        <div class="summary-left">
            <h5><i class="bx bx-receipt me-2"></i>{{ $billDesc }}</h5>
            <p>Ref: {{ $billRefNumber }} &nbsp;·&nbsp; {{ $clientName }}</p>
        </div>
        <div class="summary-amount">
            <div class="label">Amount</div>
            <div class="value">KES {{ number_format($amountExpected, 2) }}</div>
        </div>
    </div>

    {{-- Loading status ── swaps to "loaded" once iframe fires ── --}}
    <div class="payment-status-bar" id="statusBar">
        <div class="spinner-border" role="status" id="loadingSpinner"></div>
        <span id="statusText">Connecting to eCitizen payment gateway…</span>
    </div>

    {{-- eCitizen iframe ── form auto-submits into it ── --}}
    <div class="iframe-wrapper">
        <iframe name="ecitizen_frame" id="ecitizenFrame" title="eCitizen Payment Gateway"
                onload="onIframeLoad()"></iframe>
    </div>

    <div class="security-footer">
        <i class="fas fa-lock"></i>
        <strong>SSL Secured</strong> &nbsp;·&nbsp; Payments processed securely via eCitizen / Pesaflow
        &nbsp;·&nbsp;
        <a href="{{ route('student.fees.index') }}" style="color:#3b2818;">Back to Fees</a>
    </div>

</div>
</div>

{{-- Hidden form — auto-submits into the iframe on page load ── --}}
<form id="pesaflowForm"
      action="https://payments.ecitizen.go.ke/PaymentAPI/iframev2.1.php"
      method="POST"
      target="ecitizen_frame">
    <input type="hidden" name="secureHash"          value="{{ $my_secureHash }}">
    <input type="hidden" name="apiClientID"         value="{{ $apiClientID }}">
    <input type="hidden" name="sendSTK"             value="True">
    <input type="hidden" name="format"              value="iframe">
    <input type="hidden" name="billDesc"            value="{{ $billDesc }}">
    <input type="hidden" name="billRefNumber"       value="{{ $billRefNumber }}">
    <input type="hidden" name="currency"            value="KES">
    <input type="hidden" name="serviceID"           value="{{ $serviceID }}">
    <input type="hidden" name="clientMSISDN"        value="{{ $clientMSISDN }}">
    <input type="hidden" name="clientName"          value="{{ $clientName }}">
    <input type="hidden" name="clientIDNumber"      value="{{ $clientIDNumber }}">
    <input type="hidden" name="clientEmail"         value="{{ $clientEmail }}">
    <input type="hidden" name="callBackURLOnSuccess" value="{{ $callBackURLOnSuccess }}">
    <input type="hidden" name="notificationURL"     value="{{ $notificationURL }}">
    <input type="hidden" name="amountExpected"      value="{{ $amountExpected }}">
</form>

<script>
    // Auto-submit the hidden form into the iframe as soon as the page loads
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('pesaflowForm').submit();
    });

    // Once iframe loads (eCitizen responded), update the status bar
    var iframeLoaded = false;
    function onIframeLoad() {
        if (iframeLoaded) return; // ignore the initial blank load
        iframeLoaded = true;
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('statusText').innerHTML =
            '<i class="bx bx-check-circle" style="color:#099139;font-size:1.1rem;margin-right:4px;"></i>' +
            'Payment gateway loaded. Complete your payment below.';
    }
</script>

@endsection
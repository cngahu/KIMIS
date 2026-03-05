{{-- resources/views/student/payments/initiate.blade.php --}}
@extends('admin.admin_dashboard')

@section('title', 'Initiate Payment')

@section('admin')

<style>
    :root {
        --primary: #3b2818;
        --primary-light: #5a3d2b;
        --accent: #f9a90f;
        --success: #099139;
        --danger: #b3261e;
        --border-light: #e8e8e8;
        --shadow-md: 0 6px 18px rgba(59, 40, 24, 0.08);
        --radius-lg: 16px;
        --radius-md: 12px;
    }

    .payment-wrapper {
        max-width: 600px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .payment-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .payment-card-header {
        background: linear-gradient(135deg, var(--primary), #5a3d2b);
        color: #fff;
        padding: 1.5rem 2rem;
    }

    .payment-card-header h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .payment-card-header p {
        margin: 0.25rem 0 0;
        opacity: 0.8;
        font-size: 0.9rem;
    }

    .payment-card-body {
        padding: 2rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.95rem;
    }

    .info-row:last-of-type {
        border-bottom: none;
    }

    .info-row .label {
        color: #858585;
        font-weight: 500;
    }

    .info-row .value {
        font-weight: 600;
        color: var(--primary);
    }

    .info-row .value.outstanding {
        color: var(--danger);
        font-size: 1.1rem;
    }

    .amount-section {
        background: #f9f6f2;
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-top: 1.5rem;
        border: 2px solid var(--accent);
    }

    .amount-section label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
        display: block;
    }

    .amount-input-group {
        display: flex;
        align-items: center;
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: #fff;
        transition: border-color 0.2s;
    }

    .amount-input-group:focus-within {
        border-color: var(--accent);
    }

    .amount-input-group .currency {
        background: var(--primary);
        color: #fff;
        padding: 0.75rem 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        white-space: nowrap;
    }

    .amount-input-group input {
        border: none;
        outline: none;
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        width: 100%;
        color: var(--primary);
    }

    .amount-hint {
        font-size: 0.82rem;
        color: #858585;
        margin-top: 0.4rem;
    }

    .quick-amounts {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .quick-btn {
        border: 2px solid var(--primary);
        background: transparent;
        color: var(--primary);
        border-radius: 999px;
        padding: 0.3rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }

    .quick-btn:hover {
        background: var(--primary);
        color: #fff;
    }

    .btn-pay {
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, var(--primary), #5a3d2b);
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 700;
        margin-top: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59,40,24,0.25);
    }

    .btn-pay:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .alert-info-custom {
        background: rgba(249,169,15,0.1);
        border-left: 4px solid var(--accent);
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        font-size: 0.88rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .error-msg {
        color: var(--danger);
        font-size: 0.82rem;
        margin-top: 0.3rem;
    }
</style>

<div class="page-content">

    <div class="payment-wrapper">

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
                        <li class="breadcrumb-item active">Initiate Payment</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Info notice --}}
        @if(session('info'))
            <div class="alert-info-custom mb-3">
                <i class="fas fa-info-circle me-1"></i> {{ session('info') }}
            </div>
        @endif

        <div class="payment-card">

            {{-- Header --}}
            <div class="payment-card-header">
                <h4><i class="fas fa-credit-card me-2"></i>Initiate Fee Payment</h4>
                <p>Pay your tuition fees securely via eCitizen gateway</p>
            </div>

            <div class="payment-card-body">

                {{-- Student Info --}}
                <div class="info-row">
                    <span class="label">Student Name</span>
                    <span class="value">{{ auth()->user()->firstname }} {{ auth()->user()->surname }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Admission No</span>
                    <span class="value">{{ $student->student_number ?? auth()->user()->username }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Course</span>
                    <span class="value">{{ $student->course->course_name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Current Cycle</span>
                    <span class="value">{{ $cycleTerm }} {{ $cycleYear }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Outstanding Balance</span>
                    <span class="value outstanding">KES {{ number_format($outstanding, 2) }}</span>
                </div>

                                    {{-- Existing pending invoice notice --}}
                    @if(isset($existingInvoice) && $existingInvoice)
                        <div class="alert-info-custom mb-3" style="background:rgba(179,38,30,0.08);border-left-color:#b3261e;">
                            <i class="fas fa-exclamation-circle" style="color:#b3261e;"></i>
                            <div>
                                <strong>You have a pending payment</strong> for 
                                KES {{ number_format($existingInvoice->amount, 2) }} 
                                (Ref: {{ $existingInvoice->invoice_number }}).
                                <div style="margin-top:0.4rem;">
                                    <a href="{{ route('student.payments.iframe', $existingInvoice->id) }}" 
                                    style="color:#b3261e;font-weight:700;text-decoration:underline;">
                                        Resume that payment →
                                    </a>
                                    &nbsp; or enter a new amount below to create a fresh payment.
                                </div>
                            </div>
                        </div>
                    @endif

                {{-- Amount Form --}}
                <form method="POST" action="{{ route('student.payments.create') }}" id="paymentForm">
                    @csrf

                    <div class="amount-section">
                        <label for="amount">Amount to Pay (KES)</label>

                        <div class="amount-input-group">
                            <span class="currency">KES</span>
                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                min="1"
                                max="{{ $outstanding }}"
                                step="1"
                                value="{{ old('amount', $outstanding) }}"
                                placeholder="Enter amount"
                                required
                            />
                        </div>

                        <div class="amount-hint">
                            Maximum payable: KES {{ number_format($outstanding, 2) }}
                        </div>

                        @error('amount')
                            <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror

                        {{-- Quick amount buttons --}}
                        @if($outstanding > 0)
                            <div class="quick-amounts">
                                <span style="font-size:0.82rem;color:#858585;align-self:center;">Quick select:</span>
                                @php
                                    $half = round($outstanding / 2);
                                    $quarter = round($outstanding / 4);
                                @endphp
                                @if($quarter >= 1)
                                    <button type="button" class="quick-btn" onclick="setAmount({{ $quarter }})">
                                        KES {{ number_format($quarter) }}
                                    </button>
                                @endif
                                @if($half >= 1)
                                    <button type="button" class="quick-btn" onclick="setAmount({{ $half }})">
                                        KES {{ number_format($half) }}
                                    </button>
                                @endif
                                <button type="button" class="quick-btn" onclick="setAmount({{ $outstanding }})">
                                    Full Amount
                                </button>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn-pay" id="submitBtn">
                        <i class="fas fa-lock"></i>
                        Proceed to eCitizen Payment
                    </button>

                </form>

                <p style="text-align:center;font-size:0.8rem;color:#858585;margin-top:1rem;">
                    <i class="fas fa-shield-alt"></i>
                    Payments are processed securely via the eCitizen / Pesaflow gateway
                </p>

            </div>
        </div>

    </div>
</div>

<script>
    function setAmount(val) {
        document.getElementById('amount').value = val;
    }

    document.getElementById('paymentForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    });
</script>

@endsection
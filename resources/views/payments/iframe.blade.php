@extends('layouts.public')
@section('title', 'Student Dashboard')
@section('content')
    @php
        $convenience = 50;
        $serviceID = 234330;
        $total = 50000 + $convenience;
        
        $curl = curl_init();
        $clientMSISDN = '0700123456';
        $clientEmail = 'canjetan.ngahu@icta.go.ke';
        $callBackURLOnSuccess = 'https://portal.pck.go.ke/applicant/dashboard';
        $notificationURL = "https://portal.pck.go.ke/api/pesaflow/confirm";
        $apiClientID = '35';
        $amountExpected = 1;
        $serviceIDd = $serviceID;
        $clientIDNumber = 'A12345678';
        $currency = "KES";
        $billRefNumber = 'PCK2024001';
        $billDesc = 'KIBI TEST PAYMENT';
        $clientName = 'Canjetan Ngahu';
        $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";
        $key = "Fhtuo4tuMATrqmtL";
        $stk = true;
        $format = 'iframe';

        $data_string = "$apiClientID"."$amountExpected"."$serviceID"."$clientIDNumber"."$currency"."$billRefNumber"."$billDesc" . "$clientName"."$secret";
        $hash = hash_hmac('sha256', $data_string, $key);
        $my_secureHash = base64_encode($hash);
    @endphp

    <style>
        /* ================= CSS VARIABLES - KIHBT BROWN THEME ================= */
        :root {
            /* Brand Colors */
            --primary: #3b2818;           /* KIHBT Brown */
            --primary-light: #5a3d2b;     /* Lighter Brown */
            --primary-dark: #2a1a0f;      /* Darker Brown */
            --accent: #f9a90f;            /* KIHBT Gold */
            --accent-hover: #d18b00;      /* Darker Gold */
            
            /* Semantic Colors */
            --secondary: #858585;
            --success: #099139;
            --warning: #f9a90f;
            --danger: #b3261e;
            --info: #3b2818;
            
            /* Backgrounds */
            --bg-card: #ffffff;
            --bg-soft: #f5f6f5;
            --bg-gradient: linear-gradient(135deg, #fffefc, #ffffff);
            --bg-accent: rgba(249, 169, 15, 0.1);
            --bg-primary: rgba(59, 40, 24, 0.05);
            
            /* Borders */
            --border-light: #e8e8e8;
            --border-primary: rgba(59, 40, 24, 0.2);
            --border-accent: rgba(249, 169, 15, 0.3);
            
            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(59, 40, 24, 0.06);
            --shadow-md: 0 6px 18px rgba(59, 40, 24, 0.08);
            --shadow-lg: 0 10px 25px rgba(59, 40, 24, 0.1);
            --shadow-hover: 0 12px 32px rgba(59, 40, 24, 0.15);
            
            /* Text */
            --text-primary: #26211d;
            --text-secondary: #858585;
            --text-on-primary: #ffffff;
            --text-on-accent: #000000;
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            
            /* Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            
            /* Transitions */
            --transition-fast: 0.15s ease;
            --transition-normal: 0.25s ease;
        }

        /* ================= PAGE WRAPPER ================= */
        .payment-page {
            min-height: 100vh;
            background: var(--bg-gradient);
            padding: var(--spacing-xl) 0;
        }

        /* ================= PAYMENT CARD ================= */
        .payment-card {
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-light);
            border-top: 4px solid var(--accent);
            max-width: 600px;
            margin: 0 auto var(--spacing-xl);
            overflow: hidden;
        }

        .payment-card .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--text-on-primary);
            padding: var(--spacing-lg) var(--spacing-xl);
            text-align: center;
        }

        .payment-card .card-header h3 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }

        .payment-card .card-header .text-muted {
            color: rgba(255,255,255,0.9) !important;
            font-size: 0.95rem;
        }

        .payment-card .card-body {
            padding: var(--spacing-xl);
        }

        /* ================= PAYMENT DETAILS ================= */
        .payment-details {
            background: var(--bg-soft);
            border-radius: var(--radius-md);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            border-left: 4px solid var(--accent);
        }

        .payment-details .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-sm) 0;
            border-bottom: 1px dashed var(--border-light);
        }

        .payment-details .detail-row:last-child {
            border-bottom: none;
        }

        .payment-details .detail-label {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .payment-details .detail-value {
            font-weight: 600;
            color: var(--primary);
            font-size: 1rem;
        }

        .payment-details .detail-value.total {
            font-size: 1.25rem;
            color: var(--accent);
        }

        /* ================= CENTERED BUTTON ================= */
        .payment-actions {
            text-align: center;
            padding: var(--spacing-lg) 0;
        }

        .payment-actions .btn {
            min-width: 200px;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
            box-shadow: 0 2px 4px rgba(59, 40, 24, 0.2);
        }

        .payment-actions .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: var(--text-on-primary);
        }

        .payment-actions .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-on-primary);
        }

        .payment-actions .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ================= IFRAME CONTAINER ================= */
        .iframe-container {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            padding: var(--spacing-md);
            margin-top: var(--spacing-lg);
        }

        .iframe-container iframe {
            width: 100%;
            height: 650px;
            border: none;
            border-radius: var(--radius-md);
        }

        /* ================= SECURITY BADGE ================= */
        .security-badge {
            text-align: center;
            padding: var(--spacing-md);
            color: var(--secondary);
            font-size: 0.9rem;
        }

        .security-badge i {
            color: var(--success);
            margin-right: var(--spacing-xs);
        }

        /* ================= ALERTS ================= */
        .alert {
            border-radius: var(--radius-md);
            padding: var(--spacing-md) var(--spacing-lg);
            border: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .alert-info {
            background: var(--bg-primary);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .alert-warning {
            background: var(--bg-accent);
            color: var(--primary);
            border-left: 4px solid var(--accent);
        }

        /* ================= MOBILE RESPONSIVE ================= */
        @media (max-width: 767px) {
            .payment-page { padding: var(--spacing-md) 0; }
            .payment-card { margin: 0 var(--spacing-sm) var(--spacing-xl); }
            .payment-card .card-header,
            .payment-card .card-body { padding: var(--spacing-md); }
            .payment-details { padding: var(--spacing-md); }
            .payment-actions .btn { width: 100%; min-width: auto; }
            .iframe-container iframe { height: 500px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }

        .btn:focus, a:focus {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }
    </style>

    <div class="payment-page">
        <div class="container">
            
            {{-- Payment Card --}}
            <div class="payment-card">
                <div class="card-header">
                    <h3><i class="fas fa-credit-card me-2"></i>Secure Payment</h3>
                    <p class="text-muted mb-0">KNEC Application Fee</p>
                </div>
                
                <div class="card-body">
                    
                    {{-- Payment Details --}}
                    <div class="payment-details">
                        <div class="detail-row">
                            <span class="detail-label">Application Reference</span>
                            <span class="detail-value">{{ $billRefNumber }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Description</span>
                            <span class="detail-value">{{ $billDesc }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount</span>
                            <span class="detail-value">KES {{ number_format($amountExpected, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Convenience Fee</span>
                            <span class="detail-value">KES {{ number_format($convenience, 2) }}</span>
                        </div>
                        <div class="detail-row" style="border-top: 2px solid var(--border-primary); padding-top: var(--spacing-sm); margin-top: var(--spacing-sm);">
                            <span class="detail-label" style="font-weight: 700;">Total Payable</span>
                            <span class="detail-value total">KES {{ number_format($amountExpected + $convenience, 2) }}</span>
                        </div>
                    </div>

                    {{-- Security Notice --}}
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-shield-alt"></i>
                        <strong>Secure Payment:</strong> Your transaction is encrypted and processed securely via PesaFlow.
                    </div>

                    {{-- Centered Payment Button --}}
                    <div class="payment-actions">
                        <form action="https://test.pesaflow.com/PaymentAPI/iframev2.1.php" method="post" target="my_iframe">
                            <input type="hidden" name="secureHash" value="{{ $my_secureHash }}">
                            <input type="hidden" name="apiClientID" value="{{ $apiClientID }}">
                            <input type="hidden" name="sendSTK" value="True">
                            <input type="hidden" name="format" value="iframe">
                            <input type="hidden" name="billDesc" value="{{ $billDesc }}">
                            <input type="hidden" name="billRefNumber" value="{{ $billRefNumber }}">
                            <input type="hidden" name="currency" value="KES">
                            <input type="hidden" name="serviceID" value="{{ $serviceID }}">
                            <input type="hidden" name="clientMSISDN" value="{{ $clientMSISDN }}">
                            <input type="hidden" name="clientName" value="{{ $clientName }}">
                            <input type="hidden" name="clientIDNumber" value="{{ $clientIDNumber }}">
                            <input type="hidden" name="clientEmail" value="{{ $clientEmail }}">
                            <input type="hidden" name="callBackURLOnSuccess" value="{{ $callBackURLOnSuccess }}">
                            <input type="hidden" name="notificationURL" value="{{ $notificationURL }}">
                            <input type="hidden" name="amountExpected" value="{{ $amountExpected }}">
                            
                            {{-- ✅ CENTERED BUTTON --}}
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-lock me-2"></i>Initiate Payment
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- Payment Iframe --}}
            <div class="iframe-container">
                <iframe name="my_iframe" title="Payment Gateway"></iframe>
            </div>

            {{-- Security Badge --}}
            <div class="security-badge">
                <i class="fas fa-lock"></i>
                <strong>SSL Secured</strong> · Your payment information is encrypted and protected
            </div>

        </div>
    </div>

    {{-- Optional: Auto-submit second form if needed --}}
    @if(false) {{-- Set to true if you want auto-submit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit the second form if needed
            const secondForm = document.getElementById('pesaflowForm');
            if (secondForm) {
                setTimeout(() => {
                    secondForm.submit();
                }, 1000);
            }
        });
    </script>
    @endif

@endsection
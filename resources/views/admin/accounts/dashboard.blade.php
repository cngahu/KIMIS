@extends('admin.admin_dashboard')
@section('admin')

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

    /* ================= PAGE CONTENT ================= */
    .page-content {
        padding: calc(var(--header-height, 60px) + var(--spacing-lg)) var(--spacing-lg) var(--spacing-lg);
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= DASHBOARD HEADER ================= */
    .dashboard-header {
        margin-bottom: var(--spacing-xl);
        padding-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--border-light);
    }

    .dashboard-header h4 {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .dashboard-header .text-muted {
        color: var(--secondary) !important;
        font-size: 0.95rem;
    }

    /* ================= KPI CARD ================= */
    .kpi-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        border-left: 4px solid var(--accent);
        transition: transform var(--transition-normal), box-shadow var(--transition-normal);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .kpi-card .kpi-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--text-on-primary);
        flex-shrink: 0;
    }

    .kpi-card .kpi-icon.bg-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); }
    .kpi-card .kpi-icon.bg-success { background: linear-gradient(135deg, var(--success), #067a30); }
    .kpi-card .kpi-icon.bg-warning { background: linear-gradient(135deg, var(--warning), var(--accent-hover)); }
    .kpi-card .kpi-icon.bg-info { background: linear-gradient(135deg, var(--info), var(--primary-light)); }
    .kpi-card .kpi-icon.bg-secondary { background: linear-gradient(135deg, var(--secondary), #6c757d); }
    .kpi-card .kpi-icon.bg-dark { background: linear-gradient(135deg, #343a40, #1d2124); }

    .kpi-card .kpi-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: var(--spacing-xs);
    }

    .kpi-card .kpi-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
        line-height: 1.2;
    }

    .kpi-card .kpi-subtitle {
        font-size: 0.85rem;
        color: var(--secondary);
    }

    /* ================= FINANCIAL CARD ================= */
    .financial-card {
        background: var(--bg-gradient);
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        border-top: 4px solid var(--accent);
        height: 100%;
        text-align: center;
    }

    .financial-card .card-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: var(--spacing-sm);
    }

    .financial-card .card-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
        font-family: 'SF Mono', 'Monaco', 'Courier New', monospace;
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

    .alert-success {
        background: rgba(9, 145, 57, 0.1);
        color: var(--success);
        border-left: 4px solid var(--success);
    }

    .alert-warning {
        background: var(--bg-accent);
        color: var(--primary);
        border-left: 4px solid var(--accent);
    }

    .alert-info {
        background: var(--bg-primary);
        color: var(--primary);
        border-left: 4px solid var(--primary);
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 991px) {
        .page-content { padding: var(--spacing-md); }
        .kpi-card { padding: var(--spacing-md); }
        .kpi-card .kpi-value { font-size: 1.5rem; }
        .financial-card { padding: var(--spacing-md); }
        .financial-card .card-value { font-size: 1.25rem; }
    }

    @media (max-width: 767px) {
        :root { --spacing-lg: 1.25rem; --spacing-xl: 1.5rem; }
        .page-content { padding: var(--spacing-sm); }
        .dashboard-header h4 { font-size: 1.2rem; }
        .kpi-card .kpi-icon { width: 48px; height: 48px; font-size: 1.25rem; }
        .kpi-card .kpi-value { font-size: 1.25rem; }
        .financial-card .card-value { font-size: 1.1rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    a:focus, button:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .kpi-card, .financial-card { border: 2px solid var(--primary); }
    }
</style>

<div class="page-content">

    {{-- Dashboard Header --}}
    <div class="dashboard-header">
        <h4 class="fw-bold mb-1">Accounts Dashboard</h4>
        <p class="text-muted mb-0">
            Manage invoices, payments, and financial reports
        </p>
    </div>

    {{-- KPI Cards Row --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['Total Invoices', $totalInvoices, 'bx-receipt', 'bg-primary'],
            ['Paid', $paidInvoices, 'bx-check-circle', 'bg-success'],
            ['Pending', $pendingInvoices, 'bx-time-five', 'bg-warning'],
            ['Sponsor Pending', $sponsorPending, 'bx-user-voice', 'bg-info'],
            ['Pay-Later Requests', $payLaterPending, 'bx-help-circle', 'bg-secondary'],
            ['Partial Payments', $partialPending, 'bx-bitcoin', 'bg-dark'],
        ] as $card)
            <div class="col-md-4">
                <div class="kpi-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="kpi-icon {{ $card[3] }}">
                            <i class="bx {{ $card[2] }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="kpi-title">{{ $card[0] }}</div>
                            <div class="kpi-value">{{ number_format($card[1]) }}</div>
                            <div class="kpi-subtitle">
                                @if($card[0] === 'Total Invoices')
                                    All invoices in system
                                @elseif($card[0] === 'Paid')
                                    Fully settled invoices
                                @elseif($card[0] === 'Pending')
                                    Awaiting payment
                                @elseif($card[0] === 'Sponsor Pending')
                                    Sponsor verification
                                @elseif($card[0] === 'Pay-Later Requests')
                                    Deferred payment requests
                                @else
                                    Partially paid invoices
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Financial Summary Row --}}
    <div class="row g-3">
        <div class="col-md-4">
            <div class="financial-card">
                <div class="card-title">Total Invoiced</div>
                <div class="card-value">KES {{ number_format($totalInvoiced, 2) }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="financial-card">
                <div class="card-title">Total Paid</div>
                <div class="card-value">KES {{ number_format($totalPaid, 2) }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="financial-card">
                <div class="card-title">Total Pending</div>
                <div class="card-value">KES {{ number_format($totalPending, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions (Optional) --}}
    <div class="mt-4">
        <div class="alert alert-info">
            <i class="bx bx-info-circle"></i>
            <strong>Tip:</strong> Use the sidebar to access detailed invoice reports, payment reconciliation, and financial statements.
        </div>
    </div>

</div>

@endsection
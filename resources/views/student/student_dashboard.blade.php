@extends('admin.admin_dashboard')

@section('title', 'Student Dashboard')

@section('admin')

    <style>
        /* ================= CSS VARIABLES - KIHBT BROWN THEME ================= */
        :root {
            /* Brand Colors */
            --primary: #3b2818;
            --primary-light: #5a3d2b;
            --primary-dark: #2a1a0f;
            --accent: #f9a90f;
            --accent-hover: #d18b00;
            
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
            
            /* ⭐ Header height for layout calculations */
            --header-height: 60px;
        }

        /* ================= PAGE CONTENT - Fixed Padding ================= */
        .page-content {
            padding: calc(var(--header-height, 60px) + var(--spacing-lg, 1.5rem)) var(--spacing-lg, 1.5rem) var(--spacing-lg, 1.5rem);
            max-width: 1400px;
            margin: 0 auto;
            box-sizing: border-box;
            width: 100%;
        }

        /* ================= HEADER ================= */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
            padding: var(--spacing-md) 0;
            border-bottom: 1px solid var(--primary);
        }

        .dashboard-header h4 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
            color: var(--primary);
        }

        .dashboard-header .text-muted {
            font-size: 0.95rem;
            color: var(--secondary) !important;
        }

        /* ================= BADGE ================= */
        .badge-soft {
            background: var(--bg-accent);
            color: var(--primary);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid var(--border-accent);
        }

        .badge-soft i {
            color: var(--accent);
        }

        /* ================= STAT CARDS ================= */
        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            opacity: 0;
            transition: opacity var(--transition-fast);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: var(--border-accent);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card small {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--secondary);
            font-weight: 500;
            margin-bottom: var(--spacing-xs);
            display: block;
        }

        .stat-card h6 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: var(--primary);
            line-height: 1.3;
        }

        .stat-card .text-danger {
            color: var(--danger) !important;
        }

        /* ================= ACTION CARD ================= */
        .action-card {
            background: var(--bg-gradient);
            border-radius: var(--radius-xl);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            margin-bottom: var(--spacing-xl);
            border: 1px solid var(--primary);
        }

        .action-card h5 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: var(--spacing-md);
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-card h5 i {
            color: var(--accent);
        }

        .action-card .text-muted {
            font-size: 0.95rem;
            line-height: 1.5;
            color: var(--secondary) !important;
        }

        .action-card .alert {
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-md);
            border: none;
            font-size: 0.9rem;
            padding: 0.875rem 1rem;
        }

        .action-card .alert-info {
            background: var(--bg-primary);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .action-card .alert-warning {
            background: var(--bg-accent);
            color: var(--primary);
            border-left: 4px solid var(--accent);
        }

        .action-card .alert-success {
            background: rgba(9, 145, 57, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        /* ================= FORMS ================= */
        .action-card .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: var(--spacing-xs);
            color: var(--primary);
        }

        .action-card .form-control {
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-light);
            font-size: 0.95rem;
            transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
            background: #fff;
        }

        .action-card .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(249, 169, 15, 0.15);
            outline: none;
        }

        /* ================= BUTTONS ================= */
        .btn {
            border-radius: var(--radius-md);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
        }

        .btn-lg {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--text-on-primary);
            box-shadow: 0 2px 4px rgba(59, 40, 24, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-on-primary);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-warning {
            background: var(--accent);
            color: var(--text-on-accent);
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(249, 169, 15, 0.2);
        }

        .btn-warning:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-on-accent);
        }

        .btn-outline-warning {
            border: 2px solid var(--accent);
            color: var(--primary);
            background: transparent;
            font-weight: 600;
        }

        .btn-outline-warning:hover {
            background: var(--accent);
            color: var(--text-on-accent);
            transform: translateY(-2px);
        }

        /* ================= TIMELINE ================= */
        .timeline-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            border: 2px solid var(--accent);
        }

        .timeline-card h5 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            color: var(--primary);
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timeline-card h5 i {
            color: var(--accent);
        }

        .timeline-item {
            padding: var(--spacing-md) var(--spacing-lg);
            border-radius: var(--radius-md);
            background: var(--bg-soft);
            margin-bottom: var(--spacing-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: var(--spacing-md);
            transition: all var(--transition-fast);
            border-left: 3px solid transparent;
        }

        .timeline-item:hover {
            background: var(--bg-primary);
            transform: translateX(4px);
            border-left-color: var(--accent);
        }

        .timeline-item.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--text-on-primary);
            border-left-color: var(--accent);
            font-weight: 600;
        }

        .timeline-item.active span {
            color: var(--text-on-primary);
        }

        .timeline-item.active small {
            color: rgba(255,255,255,0.9) !important;
        }

        .timeline-item span {
            flex: 1;
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .timeline-item small {
            color: var(--secondary);
            font-size: 0.85rem;
            white-space: nowrap;
        }

        /* ================= MOBILE RESPONSIVE ================= */
        @media (max-width: 991px) {
            .page-content { 
                padding: calc(var(--header-height, 60px) + var(--spacing-md, 1rem)) var(--spacing-md, 1rem) var(--spacing-md, 1rem); 
            }
            .dashboard-header { flex-direction: column; align-items: flex-start; gap: var(--spacing-sm); }
            .dashboard-header .badge-soft { align-self: flex-start; }
            .stat-card { padding: var(--spacing-md); }
            .stat-card h6 { font-size: 1rem; }
            .action-card { padding: var(--spacing-lg); }
            .timeline-item { flex-direction: column; align-items: flex-start; gap: var(--spacing-xs); padding: var(--spacing-md); }
            .timeline-item small { align-self: flex-end; }
        }

        @media (max-width: 767px) {
            :root { --spacing-lg: 1.25rem; --spacing-xl: 1.5rem; }
            .page-content { 
                padding: calc(var(--header-height, 60px) + var(--spacing-sm, 0.5rem)) var(--spacing-sm, 0.5rem) var(--spacing-sm, 0.5rem); 
            }
            .dashboard-header h4 { font-size: 1.2rem; }
            .stat-card { padding: var(--spacing-md); text-align: center; }
            .stat-card small { margin-bottom: var(--spacing-xs); }
            .action-card { padding: var(--spacing-md); }
            .action-card .btn { width: 100%; justify-content: center; }
            .action-card .alert { font-size: 0.85rem; padding: 0.75rem; }
            .timeline-card h5 { font-size: 1.05rem; margin-bottom: var(--spacing-md); }
            .timeline-item { padding: var(--spacing-sm) var(--spacing-md); font-size: 0.9rem; }
            .timeline-item small { font-size: 0.8rem; }
            .btn, .form-control, .timeline-item { min-height: 44px; }
        }

        @media (max-width: 575px) {
            .dashboard-header { padding: var(--spacing-sm) 0; }
            .badge-soft { font-size: 0.8rem; padding: 0.4rem 0.8rem; }
            .stat-card h6 { font-size: 0.95rem; }
            .action-card h5 { font-size: 1.05rem; }
            .timeline-item { flex-direction: column; text-align: center; gap: var(--spacing-xs); }
            .timeline-item small { align-self: center; }
        }

        /* ================= ACCESSIBILITY ================= */
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
        .btn:focus, .form-control:focus, a:focus {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }
        @media (prefers-contrast: high) {
            .stat-card, .action-card, .timeline-card { border: 2px solid var(--primary); }
        }
    </style>

    <div class="page-content">

        {{-- ================= HEADER ================= --}}
        <div class="dashboard-header">
            <div>
                <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->firstname ?? 'Student' }}</h4>
                <p class="text-muted mb-0">
                    Student Portal · {{ $student?->course?->course_name ?? '—' }}
                </p>
            </div>

            @if(isset($cycle))
                <span class="badge-soft">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $cycle['term'] ?? '—' }} {{ $cycle['year'] ?? '—' }} Cycle
                </span>
            @endif
        </div>

                        {{-- ================= STATS GRID ================= --}}
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small>Admission No.</small>
                            <h6 class="fw-bold mb-0">{{ $student?->student_number ?? '—' }}</h6>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small>Campus</small>
                            <h6 class="fw-bold mb-0">{{ $student?->campus?->name ?? '—' }}</h6>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small>Current Stage</small>
                            <h6 class="fw-bold mb-0">{{ $current_stage?->code ?? '—' }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ $current_stage?->name ?? '—' }}
                            </small>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small>Outstanding Balance</small>
                            {{-- ✅ FIXED: Safe method call with fallback --}}
                            <h6 class="fw-bold text-danger mb-0">
                                KES {{ number_format($student && method_exists($student, 'outstandingBalance') ? $student->outstandingBalance() : ($student?->outstanding_balance ?? 0), 2) }}
                            </h6>
                        </div>
                    </div>
                </div>
        {{-- ================= REGISTRATION ACTION CARD ================= --}}
        <div class="action-card">
            <h5 class="fw-bold mb-2">
                <i class="fas fa-clipboard-list"></i>
                {{ $cycle['term'] ?? '—' }} {{ $cycle['year'] ?? '—' }} Registration
            </h5>

            @if(!($cycle_registration ?? null))
                <p class="text-muted mb-3">
                    You have not registered for this cycle. Registration is required to appear on the nominal roll.
                </p>
                <form method="POST" action="{{ route('student.cycle.register') }}" onsubmit="this.querySelector('button').disabled=true;">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-100 w-md-auto">
                        <i class="fas fa-check-circle"></i>
                        Register & Proceed to Payment
                    </button>
                </form>
            @elseif(($cycle_registration?->status ?? null) === 'pending_payment')
                <p class="text-danger mb-2">
                    <i class="fas fa-exclamation-circle"></i>
                    You have initiated registration for this cycle. Payment is required to confirm registration.
                </p>

                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle"></i>
                    Outstanding Balance: <strong>KES {{ number_format($student?->outstandingBalance() ?? 0, 2) }}</strong>
                </div>

                @if($pendingInvoice)
                    <div class="alert alert-warning mb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <div>
                                <p class="mb-1 fw-bold">
                                    <i class="fas fa-file-invoice"></i>
                                    Pending Invoice: {{ $pendingInvoice->invoice_number }}
                                </p>
                                <p class="mb-0">
                                    Amount: <strong>KES {{ number_format($pendingInvoice->amount, 2) }}</strong>
                                </p>
                            </div>
                            <a href="{{ route('student.payments.iframe', $pendingInvoice->id) }}" class="btn btn-warning">
                                <i class="fas fa-credit-card"></i>
                                Resume Payment
                            </a>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('student.payments.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Enter Amount to Pay</label>
                            <input type="number" name="amount" class="form-control" 
                                   min="1" max="{{ $student?->outstandingBalance() ?? 0 }}" required
                                   placeholder="Enter amount in KES">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-arrow-right"></i>
                            Proceed to Payment
                        </button>
                    </form>
                @endif

            @elseif(($cycle_registration?->status ?? null) === 'confirmed')
                @if(($student?->outstandingBalance() ?? 0) > 0)
                    <p class="text-success fw-bold mb-2">
                        <i class="fas fa-check-circle"></i>
                        You are registered for this cycle but still have a pending balance.
                    </p>
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        Outstanding Balance: <strong>KES {{ number_format($student?->outstandingBalance() ?? 0, 2) }}</strong>
                    </div>

                    @if($pendingInvoice)
                        <div class="alert alert-warning mb-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                                <div>
                                    <p class="mb-1 fw-bold">
                                        <i class="fas fa-file-invoice"></i>
                                        Pending Invoice: {{ $pendingInvoice->invoice_number }}
                                    </p>
                                    <p class="mb-0">
                                        Amount: <strong>KES {{ number_format($pendingInvoice->amount, 2) }}</strong>
                                    </p>
                                </div>
                                <a href="{{ route('student.payments.iframe', $pendingInvoice->id) }}" class="btn btn-warning">
                                    <i class="fas fa-credit-card"></i>
                                    Resume Payment
                                </a>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('student.payments.create') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Enter Amount to Pay</label>
                                <input type="number" name="amount" class="form-control" 
                                       min="1" max="{{ $student?->outstandingBalance() ?? 0 }}" required
                                       placeholder="Enter amount in KES">
                            </div>
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <i class="fas fa-plus"></i>
                                Make Another Payment
                            </button>
                        </form>
                    @endif
                @else
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-check-circle"></i>
                        You are fully registered for this cycle, appear on the nominal roll, and your fees are settled.
                    </div>
                @endif
            @endif
        </div>

        {{-- ================= COURSE TIMELINE ================= --}}
        <div class="timeline-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-route"></i>
                Course Progress Timeline
            </h5>

            @forelse($timeline as $row)
                @php
                    $isActive = $row->id === ($current_stage->id ?? null);
                @endphp
                <div class="timeline-item {{ $isActive ? 'active' : '' }}">
                    <span>
                        <strong>{{ $row->code ?? '—' }}</strong> – {{ $row->name ?? 'Unknown Stage' }}
                    </span>
                    <small>
                        {{ optional($row->start_date)->format('M Y') ?? '—' }} → {{ optional($row->end_date)->format('M Y') ?? '—' }}
                    </small>
                </div>
            @empty
                <p class="text-muted text-center py-3">No timeline data available.</p>
            @endforelse
        </div>

    </div>

@endsection
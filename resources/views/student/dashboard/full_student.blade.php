@extends('admin.admin_dashboard')

@section('title', 'Student Dashboard')

@section('admin')

    <style>
        /* ================= CSS VARIABLES FOR CONSISTENCY ================= */
        :root {
            --primary: #3b2818;
            --primary-light: #009FE3;
            --secondary: #6c757d;
            --success: #198754;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #0dcaf0;
            --bg-card: #ffffff;
            --bg-soft: #f8fafc;
            --bg-gradient: linear-gradient(135deg, #f9fafb, #ffffff);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow-md: 0 6px 18px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.08);
            --shadow-hover: 0 12px 32px rgba(0,0,0,0.1);
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition-fast: 0.15s ease;
            --transition-normal: 0.25s ease;
            --transition-slow: 0.35s ease;
        }

        .page-content {
            padding: var(--spacing-lg);
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
            padding: var(--spacing-md) 0;
            border-bottom: 1px solid rgba(0,0,0,0.06);
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

        .badge-soft {
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid rgba(13, 110, 253, 0.2);
        }

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
            border: 1px solid rgba(0,0,0,0.04);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(13, 110, 253, 0.3);
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

        .action-card {
            background: var(--bg-gradient);
            border-radius: var(--radius-xl);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.04);
            margin-bottom: var(--spacing-xl);
        }

        .action-card h5 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: var(--spacing-md);
            color: var(--primary);
        }

        .action-card .text-muted {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .action-card .alert {
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-md);
            border: none;
            font-size: 0.9rem;
        }

        .action-card .alert-info {
            background: rgba(13, 202, 240, 0.1);
            color: #055160;
        }

        .action-card .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #664d03;
        }

        .action-card .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: var(--spacing-xs);
            color: var(--primary);
        }

        .action-card .form-control {
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            border: 1px solid rgba(0,0,0,0.1);
            font-size: 0.95rem;
            transition: border-color var(--transition-fast);
        }

        .action-card .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(0, 159, 227, 0.15);
            outline: none;
        }

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
        }

        .btn-lg {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: #fff;
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-warning {
            background: var(--warning);
            border: none;
            color: #000;
            font-weight: 600;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: #000;
        }

        .btn-outline-warning {
            border: 2px solid var(--warning);
            color: #856404;
            background: transparent;
            font-weight: 600;
        }

        .btn-outline-warning:hover {
            background: var(--warning);
            color: #000;
        }

        .timeline-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .timeline-card h5 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            color: var(--primary);
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid rgba(0,0,0,0.06);
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
            background: rgba(13, 110, 253, 0.05);
            transform: translateX(4px);
        }

        .timeline-item.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #fff;
            border-left-color: #fff;
            font-weight: 600;
        }

        .timeline-item small {
            color: var(--secondary);
            font-size: 0.85rem;
        }
    </style>

    <div class="page-content">

        {{-- ================= HEADER ================= --}}
        <div class="dashboard-header">
            <div>
                <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->firstname }}</h4>
                <p class="text-muted mb-0">
                    Student Portal · {{ $enrollment->course->course_name ?? '—' }}
                </p>
            </div>

            @if($cycle)
                <span class="badge-soft">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ $cycle['term'] ?? '—' }} {{ $cycle['year'] ?? '—' }} Cycle
                </span>
            @endif
        </div>

        {{-- ================= STATS GRID ================= --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <small>Admission No.</small>
                    <h6 class="fw-bold mb-0">{{ $student->student_number ?? '—' }}</h6>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <small>Campus</small>
                    <h6 class="fw-bold mb-0">{{ $enrollment->campus->name ?? '—' }}</h6>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <small>Current Stage</small>
                    <h6 class="fw-bold mb-0">{{ $current_stage->code ?? '—' }}</h6>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        {{ $current_stage->name ?? '' }}
                    </small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <small>Outstanding Balance</small>
                    <h6 class="fw-bold text-danger mb-0">
                        KES {{ number_format($student->outstandingBalance() ?? 0, 2) }}
                    </h6>
                </div>
            </div>
        </div>

        {{-- ================= ACTION CARD ================= --}}
        <div class="action-card">
            <h5 class="fw-bold mb-2">
                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                {{ $cycle['term'] ?? '—' }} {{ $cycle['year'] ?? '—' }} Registration
            </h5>

            {{-- Registration Forms/Alerts --}}
            @include('student.partials.registration_card', [
                'cycle_registration' => $cycle_registration,
                'pendingInvoice' => $pendingInvoice,
                'student' => $student
            ])
        </div>

        {{-- ================= TIMELINE ================= --}}
        <div class="timeline-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-route me-2 text-primary"></i>
                Course Progress Timeline
            </h5>

            @forelse($timeline ?? [] as $row)
                <div class="timeline-item {{ $row->course_stage_id == ($current_stage->id ?? null) ? 'active' : '' }}">
                    <span>
                        <strong>{{ $row->stage->code ?? '—' }}</strong> – {{ $row->stage->name ?? 'Unknown Stage' }}
                    </span>
                    <small>
                        {{ $row->start_date?->format('M Y') ?? '—' }} → {{ $row->end_date?->format('M Y') ?? '—' }}
                    </small>
                </div>
            @empty
                <p class="text-muted text-center py-3">No timeline data available.</p>
            @endforelse
        </div>

    </div>

@endsection
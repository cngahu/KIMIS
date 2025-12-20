{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}

{{--    <style>--}}
{{--        .stat-card {--}}
{{--            background: rgba(255, 255, 255, 0.88);--}}
{{--            backdrop-filter: blur(10px);--}}
{{--            border-radius: 14px;--}}
{{--            padding: 16px;--}}
{{--            box-shadow: 0 10px 25px rgba(0,0,0,.06);--}}
{{--            transition: all .25s ease;--}}
{{--            height: 100%;--}}
{{--        }--}}
{{--        .stat-card:hover {--}}
{{--            transform: translateY(-4px);--}}
{{--            box-shadow: 0 20px 40px rgba(0,0,0,.08);--}}
{{--        }--}}
{{--        .stat-label {--}}
{{--            font-size: 12px;--}}
{{--            text-transform: uppercase;--}}
{{--            letter-spacing: .04em;--}}
{{--            color: #6c757d;--}}
{{--        }--}}
{{--        .stat-value {--}}
{{--            font-size: 18px;--}}
{{--            font-weight: 700;--}}
{{--            margin-top: 4px;--}}
{{--        }--}}
{{--        .stat-sub {--}}
{{--            font-size: 13px;--}}
{{--            color: #6c757d;--}}
{{--        }--}}
{{--        .timeline-item {--}}
{{--            border-left: 4px solid transparent;--}}
{{--            padding-left: 12px;--}}
{{--        }--}}
{{--        .timeline-item.active {--}}
{{--            background: linear-gradient(90deg, #e8f3ff, transparent);--}}
{{--            border-left-color: #0d6efd;--}}
{{--            font-weight: 600;--}}
{{--        }--}}
{{--        .status-panel {--}}
{{--            border-radius: 14px;--}}
{{--            background: #f8f9fa;--}}
{{--            padding: 20px;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="page-content">--}}

{{--        --}}{{-- ================= HEADER ================= --}}
{{--        <div class="mb-4">--}}
{{--            <h4 class="fw-bold mb-1">--}}
{{--                Welcome, {{ auth()->user()->firstname }}--}}
{{--            </h4>--}}
{{--            <p class="text-muted mb-0">--}}
{{--                Student Dashboard · {{ $enrollment->course->course_name }}--}}
{{--            </p>--}}
{{--        </div>--}}

{{--        --}}{{-- ================= KEY STATS ================= --}}
{{--        <div class="row g-3 mb-4">--}}

{{--            <div class="col-md-3">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Admission Number</div>--}}
{{--                    <div class="stat-value">--}}
{{--                        {{ $student->student_number ?? 'Pending' }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-3">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Campus</div>--}}
{{--                    <div class="stat-value">--}}
{{--                        {{ $enrollment->campus->name ?? '—' }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-3">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Current Stage</div>--}}
{{--                    <div class="stat-value">--}}
{{--                        {{ $current_stage->code }}--}}
{{--                    </div>--}}
{{--                    <div class="stat-sub">--}}
{{--                        {{ $current_stage->name }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-3">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Cohort</div>--}}
{{--                    <div class="stat-value">--}}
{{--                        {{ $enrollment->cohort ?? '—' }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--        --}}{{-- ================= COURSE TIMELINE ================= --}}
{{--        <div class="card radius-10 mb-4 shadow-sm">--}}
{{--            <div class="card-body">--}}
{{--                <h6 class="fw-bold mb-3">Course Timeline</h6>--}}

{{--                <ul class="list-group list-group-flush">--}}
{{--                    @foreach($timeline as $row)--}}
{{--                        <li class="list-group-item timeline-item--}}
{{--                        {{ $row->course_stage_id == $current_stage->id ? 'active' : '' }}">--}}
{{--                            <div class="d-flex justify-content-between align-items-center">--}}
{{--                                <div>--}}
{{--                                    {{ $row->stage->code }} – {{ $row->stage->name }}--}}
{{--                                </div>--}}
{{--                                <small class="text-muted">--}}
{{--                                    {{ $row->start_date->format('M Y') }}--}}
{{--                                    →--}}
{{--                                    {{ $row->end_date->format('M Y') }}--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- ================= REGISTRATION STATUS ================= --}}
{{--        <div class="card radius-10 mb-4 shadow-sm">--}}
{{--            <div class="card-body status-panel">--}}

{{--                <h6 class="fw-bold mb-2">--}}
{{--                    {{ $cycle['term'] }} {{ $cycle['year'] }} Registration--}}
{{--                </h6>--}}

{{--                @if(!$cycle_registration)--}}
{{--                    <p class="text-muted mb-3">--}}
{{--                        You have not registered for this cycle.--}}
{{--                    </p>--}}
{{--                    <form method="POST" action="{{ route('student.cycle.register') }}">--}}
{{--                        @csrf--}}
{{--                        <button class="btn btn-primary">--}}
{{--                            Register for {{ $cycle['term'] }} {{ $cycle['year'] }}--}}
{{--                        </button>--}}
{{--                    </form>--}}

{{--                @endif--}}

{{--                @if($cycle_registration && $cycle_registration->status === 'pending_payment')--}}
{{--                    <p class="text-warning fw-bold mb-3">--}}
{{--                        ⚠ Registration pending payment--}}
{{--                    </p>--}}
{{--                    <a href="{{ route('student.cycle.payment', $cycle_registration->invoice_id) }}"--}}
{{--                       class="btn btn-warning">--}}
{{--                        Pay to Confirm Registration--}}
{{--                    </a>--}}

{{--                @endif--}}

{{--                @if($cycle_registration && $cycle_registration->status === 'confirmed')--}}
{{--                    <p class="text-success fw-bold mb-0">--}}
{{--                        ✔ You are registered and appear on the nominal roll--}}
{{--                    </p>--}}
{{--                @endif--}}

{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- ================= FINANCIAL SNAPSHOT ================= --}}
{{--        <div class="row g-3">--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Opening Balance</div>--}}
{{--                    <div class="stat-value text-danger">--}}
{{--                        KES {{ number_format($financials['opening_balance'], 2) }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Outstanding Balance</div>--}}
{{--                    <div class="stat-value text-danger">--}}
{{--                        KES {{ number_format($financials['outstanding'], 2) }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="stat-card">--}}
{{--                    <div class="stat-label">Statements</div>--}}
{{--                    <a href="#" class="fw-bold d-block mt-1">--}}
{{--                        Download Fee Statement--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}

{{--@endsection--}}


@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .stat-card {
            border-radius: 14px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
            transition: all .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .badge-soft {
            background: #eef4ff;
            color: #3559e0;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .timeline-item {
            padding: 14px 16px;
            border-radius: 10px;
            background: #f8fafc;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .timeline-item.active {
            background: linear-gradient(135deg,#003666,#009FE3);
            color: #fff;
        }

        .action-card {
            border-radius: 16px;
            background: linear-gradient(135deg,#f9fafb,#ffffff);
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
            padding: 24px;
        }
    </style>

    <div class="page-content">

        {{-- ================= HEADER ================= --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->firstname }}</h4>
                <p class="text-muted mb-0">
                    Student Portal · {{ $enrollment->course->course_name }}
                </p>
            </div>

            <span class="badge-soft">
            {{ $cycle['term'] }} {{ $cycle['year'] }} Cycle
        </span>
        </div>

        {{-- ================= STATS ================= --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="stat-card">
                    <small class="text-muted">Admission No.</small>
                    <h6 class="fw-bold mb-0">{{ $student->student_number }}</h6>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <small class="text-muted">Campus</small>
                    <h6 class="fw-bold mb-0">{{ $enrollment->campus->name ?? '—' }}</h6>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <small class="text-muted">Current Stage</small>
                    <h6 class="fw-bold mb-0">
                        {{ $current_stage->code }} – {{ $current_stage->name }}
                    </h6>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <small class="text-muted">Outstanding Balance</small>
                    <h6 class="fw-bold text-danger mb-0">
                        KES {{ number_format($student->outstandingBalance(), 2) }}
                    </h6>
                </div>
            </div>

        </div>

        {{-- ================= REGISTRATION ACTION ================= --}}
        <div class="action-card mb-4">

            <h5 class="fw-bold mb-2">
                {{ $cycle['term'] }} {{ $cycle['year'] }} Registration
            </h5>

            @if(!$cycle_registration)
                <p class="text-muted mb-3">
                    You have not registered for this cycle. Registration is required to appear on the nominal roll.
                </p>

                <form method="POST"
                      action="{{ route('student.cycle.register') }}"
                      onsubmit="this.querySelector('button').disabled=true;">
                    @csrf
                    <button class="btn btn-primary btn-lg">
                        Register & Proceed to Payment
                    </button>
                </form>
            @endif

            @if($cycle_registration && $cycle_registration->status === 'pending_payment')
                <p class="text-warning mb-2">
                    Registration pending payment.
                </p>

                <small class="text-muted d-block mb-3">
                    Invoice Ref:
                    <strong>{{ $cycle_registration->invoice->invoice_number }}</strong>
                </small>

                <a href="{{ route('student.payments.iframe', $cycle_registration->invoice_id) }}"
                   class="btn btn-warning btn-lg">
                    Pay to Confirm Registration
                </a>
            @endif

            @if($cycle_registration && $cycle_registration->status === 'confirmed')
                <p class="text-success fw-bold mb-0">
                    ✔ You are fully registered for this cycle and appear on the nominal roll.
                </p>
            @endif

        </div>

        {{-- ================= TIMELINE ================= --}}
        <div class="card radius-10 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Course Progress Timeline</h5>

                @foreach($timeline as $row)
                    <div class="timeline-item {{ $row->course_stage_id == $current_stage->id ? 'active' : '' }}">
                    <span>
                        {{ $row->stage->code }} – {{ $row->stage->name }}
                    </span>
                        <small>
                            {{ $row->start_date->format('M Y') }}
                            →
                            {{ $row->end_date->format('M Y') }}
                        </small>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection

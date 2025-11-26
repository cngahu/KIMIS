@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .kpi-value { font-weight: 700; font-size: 1.45rem; }
        .kpi-label { font-weight: 600; font-size: .95rem; }
        .kpi-change { font-weight: 600; font-size: .8rem; }
        .table thead th { font-weight: 700 !important; font-size: .9rem; }
        .table tbody td { font-weight: 500; }
        .toolbar-label { font-weight: 600; font-size: .8rem; text-transform: uppercase; color:#6b7280; }
        .card-role { border-left: 4px solid #3b2818; }
    </style>

    @php
        $displayName = $userName ?? Auth::user()->name;
        $roleLabel   = $primaryRole ?? optional(Auth::user()->getRoleNames())->first();
    @endphp

    <div class="page-content">

        {{-- WELCOME HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h4 class="mb-1 fw-bold">
                    Welcome back, {{ $displayName }}
                </h4>
                <p class="mb-0 text-muted">
                    You are logged in as
                    <span class="badge bg-dark text-white">
                        {{ strtoupper(str_replace('_',' ', $roleLabel ?? 'USER')) }}
                    </span>
                </p>
            </div>
        </div>

        {{-- ROLE-BASED KPI CARDS --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-3">

            {{-- SUPERADMIN: GLOBAL WORKFLOW --}}
            @if(Auth::user()->hasRole('superadmin'))
                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#3b2818,#5a3b23);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $draftCount }}</h5>
                                <div class="ms-auto"><i class='bx bx-edit fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Draft Trainings</p>
                            <small class="text-white-50">Created but not yet sent for approval</small>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#f9a90f,#ffcc4d);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $pendingCount }}</h5>
                                <div class="ms-auto"><i class='bx bx-time-five fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Pending Registrar</p>
                            <small class="text-white-50">Waiting campus registrar action</small>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#2b9348,#4bb368);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $approvedCount }}</h5>
                                <div class="ms-auto"><i class='bx bx-check-circle fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Approved Trainings</p>
                            <small class="text-white-50">Fully cleared through HQ & Director</small>
                        </div>
                        <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_APPROVED]) }}"
                           class="stretched-link"></a>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $rejectedCount }}</h5>
                                <div class="ms-auto"><i class='bx bx-x-circle fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Rejected / Returned</p>
                            <small class="text-white-50">Sent back with comments</small>
                            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}"
                               class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- HOD: MY OWN TRAININGS --}}
            @if(Auth::user()->hasRole('hod'))
                {{-- DRAFT --}}
                <div class="col">
                    <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_DRAFT]) }}"
                       class="text-decoration-none">
                        <div class="card radius-10 card-role"
                             style="background:linear-gradient(135deg,#3b2818,#5a3b23);">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 kpi-value">{{ $hodDraftTrainings }}</h5>
                                    <div class="ms-auto"><i class='bx bx-edit fs-3 text-white'></i></div>
                                </div>
                                <p class="mb-1 kpi-label">My Draft Trainings</p>
                                <small class="text-white-50">You can still edit these</small>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- PENDING REGISTRAR --}}
                <div class="col">
                    <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_PENDING_REGISTRAR]) }}"
                       class="text-decoration-none">
                        <div class="card radius-10 card-role"
                             style="background:linear-gradient(135deg,#f9a90f,#ffcc4d);">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 kpi-value">{{ $hodPendingRegistrar }}</h5>
                                    <div class="ms-auto"><i class='bx bx-time-five fs-3 text-white'></i></div>
                                </div>
                                <p class="mb-1 kpi-label">Awaiting Registrar</p>
                                <small class="text-white-50">Submitted and locked for editing</small>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- REJECTED --}}
                <div class="col">
                    <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}"
                       class="text-decoration-none">
                        <div class="card radius-10 card-role"
                             style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 kpi-value">{{ $hodRejectedTrainings }}</h5>
                                    <div class="ms-auto"><i class='bx bx-message-x fs-3 text-white'></i></div>
                                </div>
                                <p class="mb-1 kpi-label">Returned / Rejected</p>
                                <small class="text-white-50">Review comments & resubmit</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endif


            {{-- CAMPUS REGISTRAR --}}
            @if(Auth::user()->hasRole('campus_registrar'))
                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#f9a90f,#ffcc4d);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $registrarPendingTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-time-five fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Pending Registrar</p>
                            <small class="text-white-50">Waiting your approval / rejection</small>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#2b9348,#4bb368);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $registrarToHqTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-send fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Sent to HQ</p>
                            <small class="text-white-50">Approved & forwarded for HQ review</small>
                        </div>
                    </div>
                </div>
            @endif

            {{-- HQ REGISTRAR --}}
            {{-- HQ REGISTRAR --}}
            @if(Auth::user()->hasRole('kihbt_registrar'))
                {{-- Global Approved --}}
                <div class="col">
                    <div class="card radius-10 card-role position-relative"
                         style="background:linear-gradient(135deg,#2b9348,#4bb368);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $globalApprovedTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-check-circle fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">All Approved Trainings</p>
                            <small class="text-white-50">Across all campuses</small>
                        </div>
                        {{-- Link to list of all approved trainings --}}
                        <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_APPROVED]) }}"
                           class="stretched-link"></a>
                    </div>
                </div>

                {{-- Global Rejected --}}
                <div class="col">
                    <div class="card radius-10 card-role position-relative"
                         style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $globalRejectedTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-x-circle fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">All Rejected Trainings</p>
                            <small class="text-white-50">Across all campuses</small>
                        </div>
                        {{-- Link to list of all rejected trainings --}}
                        <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}"
                           class="stretched-link"></a>
                    </div>
                </div>

                {{-- Existing HQ queue card --}}
                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#3b5998,#5e7ec4);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $hqQueueTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-task fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">HQ Review Queue</p>
                            <small class="text-white-50">Awaiting HQ registrar action</small>
                        </div>
                    </div>
                </div>
            @endif


            {{-- DIRECTOR --}}
            {{-- DIRECTOR --}}
            @if(Auth::user()->hasRole('director'))
                {{-- Global Approved --}}
                <div class="col">
                    <div class="card radius-10 card-role position-relative"
                         style="background:linear-gradient(135deg,#2b9348,#4bb368);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $globalApprovedTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-check-circle fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">All Approved Trainings</p>
                            <small class="text-white-50">Across all campuses</small>
                        </div>
                        <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_APPROVED]) }}"
                           class="stretched-link"></a>
                    </div>
                </div>

                {{-- Global Rejected --}}
                <div class="col">
                    <div class="card radius-10 card-role position-relative"
                         style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $globalRejectedTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-x-circle fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">All Rejected Trainings</p>
                            <small class="text-white-50">Across all campuses</small>
                        </div>
                        <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}"
                           class="stretched-link"></a>
                    </div>
                </div>

                {{-- Existing Director queue card --}}
                <div class="col">
                    <div class="card radius-10 card-role" style="background:linear-gradient(135deg,#6c5ce7,#a29bfe);">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 kpi-value">{{ $directorQueueTrainings }}</h5>
                                <div class="ms-auto"><i class='bx bx-user-check fs-3 text-white'></i></div>
                            </div>
                            <p class="mb-1 kpi-label">Director Approval Queue</p>
                            <small class="text-white-50">Awaiting your final decision</small>
                        </div>
                    </div>
                </div>
            @endif


        </div><!-- end role KPIs row -->


        {{-- OPTIONAL SECTION: RECENT APPLICATIONS (still static for now) --}}
        {{-- RECENT TRAININGS (was: Recent Applications) --}}
        <div class="card radius-10 mt-3">
            <div class="card-body">

                @php
                    $dashboardUser = Auth::user();
                    $roleNames     = $dashboardUser->getRoleNames();
                    $primaryRole   = $roleNames->first();
                @endphp

                {{-- Header + small role hint + (optional) filters --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center mb-2 gap-3">

                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-bold">Recent Trainings</h5>
                        <small class="text-muted fw-semibold d-block">
                            Latest training schedules visible to you as
                            <span class="badge bg-dark text-white">
                        {{ strtoupper(str_replace('_', ' ', $primaryRole ?? 'USER')) }}
                    </span>
                        </small>
                    </div>

                    {{-- Simple filters (optional; can be wired later) --}}
                    <form method="GET" action="{{ route('all.trainings') }}" class="d-flex flex-wrap gap-2">
                        <div>
                            <label class="toolbar-label mb-1 d-block">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">All</option>
                                <option value="{{ \App\Models\Training::STATUS_DRAFT }}">Draft</option>
                                <option value="{{ \App\Models\Training::STATUS_PENDING_REGISTRAR }}">Pending Registrar</option>
                                <option value="{{ \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ }}">Approved to HQ</option>
                                <option value="{{ \App\Models\Training::STATUS_HQ_REVIEWED }}">HQ Reviewed</option>
                                <option value="{{ \App\Models\Training::STATUS_APPROVED }}">Approved</option>
                                <option value="{{ \App\Models\Training::STATUS_REJECTED }}">Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label class="toolbar-label mb-1 d-block">Search</label>
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Course / Code"
                            >
                        </div>

                        <div class="align-self-end">
                            <button type="submit" class="btn btn-sm btn-outline-secondary fw-semibold">
                                Open Trainings
                            </button>
                        </div>
                    </form>
                </div>

                <hr>

                {{-- Quick info row (no real bulk actions yet, just UI hint) --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div class="toolbar-label">
                        Latest {{ $recentTrainings->count() }} Trainings
                    </div>
                    <div class="d-flex flex-wrap gap-2 small text-muted">
                <span>
                    <span class="badge bg-secondary">&nbsp;</span> Draft
                </span>
                        <span>
                    <span class="badge bg-warning text-dark">&nbsp;</span> Pending Registrar
                </span>
                        <span>
                    <span class="badge bg-info text-dark">&nbsp;</span> Approved to HQ
                </span>
                        <span>
                    <span class="badge bg-primary">&nbsp;</span> HQ Reviewed
                </span>
                        <span>
                    <span class="badge bg-success">&nbsp;</span> Approved
                </span>
                        <span>
                    <span class="badge bg-danger">&nbsp;</span> Rejected
                </span>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th style="width:40px;">
                                <input type="checkbox" id="selectAllApps">
                            </th>
                            <th>Training ID</th>
                            <th>Course</th>
                            <th>College / Campus</th>
                            <th>Created By</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentTrainings as $training)
                            @php
                                $status = $training->status;

                                $badgeClass = match ($status) {
                                    \App\Models\Training::STATUS_DRAFT                 => 'badge bg-secondary',
                                    \App\Models\Training::STATUS_PENDING_REGISTRAR     => 'badge bg-warning text-dark',
                                    \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ => 'badge bg-info text-dark',
                                    \App\Models\Training::STATUS_HQ_REVIEWED           => 'badge bg-primary',
                                    \App\Models\Training::STATUS_APPROVED              => 'badge bg-success',
                                    \App\Models\Training::STATUS_REJECTED              => 'badge bg-danger',
                                    default                                            => 'badge bg-secondary',
                                };
                            @endphp

                            <tr>
                                {{-- Checkbox (for possible future bulk actions) --}}
                                <td>
                                    <input type="checkbox" class="app-row-checkbox">
                                </td>

                                {{-- Training ID --}}
                                <td class="fw-semibold">
                                    {{ 'TR-' . str_pad($training->id, 5, '0', STR_PAD_LEFT) }}
                                </td>

                                {{-- Course --}}
                                <td class="course-name">
                                    {{ optional($training->course)->course_name ?? 'N/A' }}
                                    @if(optional($training->course)->course_code)
                                        <br>
                                        <small class="text-muted">
                                            ({{ $training->course->course_code }})
                                        </small>
                                    @endif
                                </td>

                                {{-- College --}}
                                <td>
                                    {{ optional($training->college)->name ?? 'N/A' }}
                                </td>

                                {{-- Created By --}}
                                <td class="applicant-name">
                                    {{ optional($training->user)->name ?? 'N/A' }}
                                </td>

                                {{-- Start date --}}
                                <td>
                                    @if($training->start_date)
                                        {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                            <span class="{{ $badgeClass }} w-100 fw-semibold">
                                {{ $status }}
                            </span>

                                    @if($training->status === \App\Models\Training::STATUS_REJECTED && $training->rejection_comment)
                                        <span
                                            class="ms-1 text-warning"
                                            style="cursor:pointer;"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="
                                        <strong>Returned with comments</strong><br>
                                        Stage: {{ ucfirst(str_replace('_',' ', $training->rejection_stage)) }}<br>
                                        {{ $training->rejection_comment }}<br>
                                        @if($training->rejected_at)
                                            <small class='text-muted'>
                                                On {{ $training->rejected_at->format('d M Y H:i') }}
                                            </small>
                                        @endif
                                    "
                                        >
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                </span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="text-center">
                                    <a href="{{ route('trainings.show', $training) }}"
                                       class="text-primary"
                                       title="View training details">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    No recent trainings found for your role.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- Select all checkboxes for this table --}}
        <script>
            document.getElementById('selectAllApps')?.addEventListener('change', function () {
                const checked = this.checked;
                document.querySelectorAll('.app-row-checkbox').forEach(cb => cb.checked = checked);
            });

            // Enable Bootstrap tooltips if available
            document.addEventListener("DOMContentLoaded", function () {
                if (window.bootstrap) {
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            });
        </script>


        {{-- GLOBAL TRAINING STATUS SNAPSHOT (visible to all roles) --}}
        <div class="row mt-4">
            <div class="col-12 col-xl-7 mb-3">
                <div class="card radius-10 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 fw-bold">Training Workflow Overview</h5>
                            <span class="badge bg-light text-muted ms-2">All statuses</span>
                        </div>
                        <small class="text-muted fw-semibold d-block mb-3">
                            Visual snapshot (static data – you can wire this to real counts later)
                        </small>
                        <div style="height:260px;">
                            <canvas id="applicationsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary by status using your global counts --}}
            <div class="col-12 col-xl-5 mb-3">
                <div class="card radius-10 h-100">
                    <div class="card-body">
                        <h5 class="mb-0 fw-bold">Trainings by Status</h5>
                        <small class="text-muted fw-semibold d-block mb-3">
                            System-wide overview
                        </small>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Draft</span>
                            <span class="badge bg-light-secondary text-dark fw-semibold">
                                {{ $draftCount }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Pending Registrar Approval</span>
                            <span class="badge bg-light-warning text-warning fw-semibold">
                                {{ $pendingCount }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Approved (Final)</span>
                            <span class="badge bg-light-success text-success fw-semibold">
                                {{ $approvedCount }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Rejected</span>
                            <span class="badge bg-light-danger text-danger fw-semibold">
                                {{ $rejectedCount }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /.page-content --}}

    {{-- Chart + bulk checkbox JS --}}
    <script>
        // === Chart: Applications / Trainings by Month (still static sample data) ===
        const chartLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const chartData   = [35, 40, 32, 48, 55, 60, 70, 68, 62, 58, 50, 45];

        if (typeof Chart !== 'undefined') {
            const ctx = document.getElementById('applicationsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Trainings / Applications',
                        data: chartData,
                        backgroundColor: 'rgba(59,40,24,0.85)',
                        borderRadius: 6,
                        maxBarThickness: 26,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: '600' } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.06)' },
                            ticks: { font: { weight: '600' } }
                        }
                    }
                }
            });
        }

        // === Select all checkboxes ===
        document.getElementById('selectAllApps')?.addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.app-row-checkbox').forEach(cb => cb.checked = checked);
        });
    </script>

@endsection

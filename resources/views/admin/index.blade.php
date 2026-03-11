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

    .dashboard-header .badge {
        font-weight: 600;
        padding: 0.35rem 0.75rem;
    }

    /* ================= PROFILE CARD ================= */
    .profile-card {
        background: var(--bg-gradient);
        border-radius: var(--radius-xl);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        border-left: 4px solid var(--accent);
        height: 100%;
    }

    .profile-card h6 {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--secondary);
        margin-bottom: var(--spacing-xs);
    }

    .profile-card h5 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .profile-card .text-muted {
        color: var(--secondary) !important;
        font-size: 0.9rem;
    }

    .profile-card .badge {
        font-weight: 500;
        padding: 0.35rem 0.6rem;
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
        position: relative;
        overflow: hidden;
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

    .kpi-card .kpi-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
        line-height: 1.2;
    }

    .kpi-card .kpi-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: var(--spacing-xs);
    }

    .kpi-card .kpi-subtitle {
        font-size: 0.8rem;
        color: var(--secondary);
    }

    /* Role-specific gradient cards */
    .kpi-card.role-draft { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-left-color: var(--accent); }
    .kpi-card.role-draft .kpi-value,
    .kpi-card.role-draft .kpi-label { color: var(--text-on-primary); }
    .kpi-card.role-draft .kpi-subtitle { color: rgba(255,255,255,0.9); }

    .kpi-card.role-pending { background: linear-gradient(135deg, var(--warning), var(--accent-hover)); border-left-color: var(--accent); }
    .kpi-card.role-pending .kpi-value,
    .kpi-card.role-pending .kpi-label { color: var(--text-on-accent); }
    .kpi-card.role-pending .kpi-subtitle { color: rgba(0,0,0,0.8); }

    .kpi-card.role-approved { background: linear-gradient(135deg, var(--success), #067a30); border-left-color: var(--accent); }
    .kpi-card.role-approved .kpi-value,
    .kpi-card.role-approved .kpi-label { color: var(--text-on-primary); }
    .kpi-card.role-approved .kpi-subtitle { color: rgba(255,255,255,0.9); }

    .kpi-card.role-rejected { background: linear-gradient(135deg, var(--danger), #9a2a20); border-left-color: var(--accent); }
    .kpi-card.role-rejected .kpi-value,
    .kpi-card.role-rejected .kpi-label { color: var(--text-on-primary); }
    .kpi-card.role-rejected .kpi-subtitle { color: rgba(255,255,255,0.9); }

    .kpi-card.role-hq { background: linear-gradient(135deg, #3b5998, #5e7ec4); border-left-color: var(--accent); }
    .kpi-card.role-hq .kpi-value,
    .kpi-card.role-hq .kpi-label { color: var(--text-on-primary); }
    .kpi-card.role-hq .kpi-subtitle { color: rgba(255,255,255,0.9); }

    .kpi-card.role-director { background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-left-color: var(--accent); }
    .kpi-card.role-director .kpi-value,
    .kpi-card.role-director .kpi-label { color: var(--text-on-primary); }
    .kpi-card.role-director .kpi-subtitle { color: rgba(255,255,255,0.9); }

    /* ================= COURSE LIST CARD ================= */
    .course-list-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        height: 100%;
    }

    .course-list-card .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-md);
        padding-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .course-list-card .table {
        margin-bottom: 0;
        --bs-table-bg: transparent;
        --bs-table-color: var(--text-primary);
    }

    .course-list-card thead th {
        font-weight: 600 !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--primary);
        padding: var(--spacing-md) var(--spacing-lg);
        border: none;
        background: var(--bg-primary);
        border-bottom: 2px solid var(--border-primary);
    }

    .course-list-card tbody td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .course-list-card tbody tr:hover {
        background: var(--bg-accent);
    }

    .course-list-card code {
        background: var(--bg-soft);
        padding: 0.2rem 0.4rem;
        border-radius: var(--radius-sm);
        font-size: 0.8rem;
        color: var(--primary);
    }

    /* ================= RECENT TRAININGS TABLE ================= */
    .recent-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        margin-top: var(--spacing-lg);
    }

    .recent-card .card-header {
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--border-light);
    }

    .recent-card .card-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .recent-card .card-header .text-muted {
        color: var(--secondary) !important;
        font-size: 0.9rem;
    }

    .recent-card .table {
        margin-bottom: 0;
        --bs-table-bg: transparent;
        --bs-table-color: var(--text-primary);
    }

    .recent-card thead th {
        font-weight: 600 !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--primary);
        padding: var(--spacing-md) var(--spacing-lg);
        border: none;
        background: var(--bg-primary);
        border-bottom: 2px solid var(--border-primary);
    }

    .recent-card tbody td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .recent-card tbody tr:hover {
        background: var(--bg-accent);
    }

    .recent-card .badge {
        font-weight: 500;
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
    }

    .recent-card .badge.bg-secondary { background: var(--secondary) !important; color: #fff !important; }
    .recent-card .badge.bg-warning { background: var(--warning) !important; color: #000 !important; }
    .recent-card .badge.bg-info { background: var(--info) !important; color: #fff !important; }
    .recent-card .badge.bg-primary { background: var(--primary) !important; color: #fff !important; }
    .recent-card .badge.bg-success { background: var(--success) !important; color: #fff !important; }
    .recent-card .badge.bg-danger { background: var(--danger) !important; color: #fff !important; }

    /* ================= FILTERS & TOOLBAR ================= */
    .toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-md);
        align-items: flex-end;
        margin-bottom: var(--spacing-md);
    }

    .toolbar .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: var(--spacing-xs);
    }

    .toolbar .form-select,
    .toolbar .form-control {
        border-radius: var(--radius-md);
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border-light);
        font-size: 0.9rem;
        min-width: 180px;
    }

    .toolbar .form-select:focus,
    .toolbar .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(249, 169, 15, 0.15);
        outline: none;
    }

    .toolbar .btn {
        border-radius: var(--radius-md);
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* ================= STATUS LEGEND ================= */
    .status-legend {
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
        font-size: 0.85rem;
        color: var(--secondary);
    }

    .status-legend .badge {
        margin-right: var(--spacing-xs);
        font-weight: 500;
    }

    /* ================= CHART CARD ================= */
    .chart-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        height: 100%;
    }

    .chart-card .card-body {
        padding: var(--spacing-lg);
    }

    .chart-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .chart-card .text-muted {
        color: var(--secondary) !important;
        font-size: 0.9rem;
    }

    .chart-card canvas {
        max-height: 260px;
    }

    /* ================= SUMMARY LIST ================= */
    .summary-list {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        height: 100%;
    }

    .summary-list .card-body {
        padding: var(--spacing-lg);
    }

    .summary-list h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .summary-list .text-muted {
        color: var(--secondary) !important;
        font-size: 0.9rem;
    }

    .summary-list .d-flex {
        padding: var(--spacing-sm) 0;
        border-bottom: 1px dashed var(--border-light);
    }

    .summary-list .d-flex:last-child {
        border-bottom: none;
    }

    .summary-list .fw-semibold {
        font-weight: 600 !important;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .summary-list .badge {
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        font-size: 0.9rem;
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

    /* ================= BUTTONS ================= */
    .btn {
        border-radius: var(--radius-md);
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all var(--transition-fast);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
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

    .btn-outline-secondary {
        border: 2px solid var(--secondary);
        color: var(--secondary);
        background: transparent;
        font-weight: 600;
    }

    .btn-outline-secondary:hover {
        background: var(--secondary);
        color: var(--text-on-primary);
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* ================= LINKS ================= */
    a {
        color: var(--primary);
        transition: color var(--transition-fast);
    }

    a:hover {
        color: var(--accent);
        text-decoration: none;
    }

    .stretched-link::after {
        background: transparent;
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 991px) {
        .page-content { padding: var(--spacing-md); }
        .profile-card, .kpi-card, .course-list-card, .recent-card, .chart-card, .summary-list {
            padding: var(--spacing-md);
        }
        .kpi-card .kpi-value { font-size: 1.5rem; }
        .kpi-card .kpi-icon { width: 48px; height: 48px; font-size: 1.25rem; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .toolbar .form-select, .toolbar .form-control { min-width: 100%; }
        .status-legend { justify-content: center; }
    }

    @media (max-width: 767px) {
        :root { --spacing-lg: 1.25rem; --spacing-xl: 1.5rem; }
        .page-content { padding: var(--spacing-sm); }
        .dashboard-header h4 { font-size: 1.2rem; }
        .profile-card h5 { font-size: 1.1rem; }
        .kpi-card .kpi-value { font-size: 1.25rem; }
        .kpi-card .kpi-label { font-size: 0.85rem; }
        .course-list-card thead th,
        .course-list-card tbody td,
        .recent-card thead th,
        .recent-card tbody td {
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: 0.85rem;
        }
        .btn { width: 100%; justify-content: center; }
    }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    .btn:focus, .form-control:focus, .form-select:focus, a:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .kpi-card, .profile-card, .course-list-card, .recent-card, .chart-card, .summary-list {
            border: 2px solid var(--primary);
        }
    }
</style>

@php
$displayName = $userName ?? Auth::user()->name;
$roleLabel   = $primaryRole ?? optional(Auth::user()->getRoleNames())->first();
@endphp

<div class="page-content">

    {{-- WELCOME HEADER --}}
    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h4 class="mb-1 fw-bold">
                Welcome back, {{ $displayName }}
            </h4>
            <p class="mb-0 text-muted">
                You are logged in as
                <span class="badge bg-primary text-white">
                    {{ strtoupper(str_replace('_',' ', $roleLabel ?? 'USER')) }}
                </span>
            </p>
        </div>
    </div>

    {{-- ===================== --}}
    {{-- HOD DASHBOARD SNAPSHOT --}}
    {{-- ===================== --}}
    @if(Auth::user()->hasRole('hod'))
    {{-- HOD PROFILE + STATS --}}
    <div class="row g-3 mb-3">
        {{-- PROFILE CARD --}}
        <div class="col-12 col-xl-4">
            <div class="profile-card">
                <h6 class="mb-2">Head of Department</h6>
                <h5 class="fw-bold mb-1">{{ $hodOfficialName }}</h5>
                <p class="mb-2 text-muted small">{{ Auth::user()->email }}</p>
                <div class="mt-2">
                    <span class="fw-semibold small d-block mb-1">Academic Departments</span>
                    @forelse($hodDepartments as $dept)
                        <span class="badge bg-secondary me-1 mb-1">{{ $dept->name }}</span>
                    @empty
                        <span class="text-muted small">None assigned</span>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- KPI: TOTAL COURSES --}}
        <div class="col-12 col-md-4 col-xl-2">
            <div class="kpi-card role-draft">
                <div class="text-center">
                    <div class="kpi-value">{{ $hodTotalCourses }}</div>
                    <div class="kpi-label">Total Courses</div>
                    <small class="kpi-subtitle">Under your oversight</small>
                </div>
            </div>
        </div>

        {{-- KPI: LONG TERM --}}
        <div class="col-12 col-md-4 col-xl-3">
            <div class="kpi-card role-approved">
                <div class="text-center">
                    <div class="kpi-value">{{ $hodLongCourses }}</div>
                    <div class="kpi-label">Long Term Courses</div>
                    <small class="kpi-subtitle">Diploma / Craft / Grade</small>
                </div>
            </div>
        </div>

        {{-- KPI: SHORT TERM --}}
        <div class="col-12 col-md-4 col-xl-3">
            <div class="kpi-card role-pending">
                <div class="text-center">
                    <div class="kpi-value">{{ $hodShortCourses }}</div>
                    <div class="kpi-label">Short Term Courses</div>
                    <small class="kpi-subtitle">Trainings & certifications</small>
                </div>
            </div>
        </div>
    </div>

    {{-- COURSE LISTS --}}
    <div class="row g-3 mb-3">
        {{-- LONG TERM --}}
        <div class="col-12 col-xl-6">
            <div class="course-list-card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-book-open"></i>
                        Long Term Courses
                        <span class="badge bg-success ms-1">{{ $hodLongCourses }}</span>
                    </h6>
                    @if($hodLongCourses)
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Code</th>
                                    <th>Department</th>
                                    <th>Campus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hodCourses['Long Term'] as $course)
                                <tr>
                                    <td>{{ $course->course_name }}</td>
                                    <td><code>{{ $course->course_code }}</code></td>
                                    <td>{{ optional($course->academicDepartment)->name }}</td>
                                    <td>{{ optional($course->college)->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted mb-0">No long term courses.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- SHORT TERM --}}
        <div class="col-12 col-xl-6">
            <div class="course-list-card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-time"></i>
                        Short Term Courses
                        <span class="badge bg-warning text-dark ms-1">{{ $hodShortCourses }}</span>
                    </h6>
                    @if($hodShortCourses)
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Code</th>
                                    <th>Department</th>
                                    <th>Campus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hodCourses['Short Term'] as $course)
                                <tr>
                                    <td>{{ $course->course_name }}</td>
                                    <td><code>{{ $course->course_code }}</code></td>
                                    <td>{{ optional($course->academicDepartment)->name }}</td>
                                    <td>{{ optional($course->college)->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted mb-0">No short term courses.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ROLE-BASED KPI CARDS --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-3">
        {{-- SUPERADMIN: GLOBAL WORKFLOW --}}
        @if(Auth::user()->hasRole('superadmin'))
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_DRAFT]) }}" class="text-decoration-none">
                <div class="kpi-card role-draft">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $draftCount }}</div>
                            <div class="kpi-label">Draft Trainings</div>
                            <small class="kpi-subtitle">Created but not yet sent for approval</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-edit fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_PENDING_REGISTRAR]) }}" class="text-decoration-none">
                <div class="kpi-card role-pending">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $pendingCount }}</div>
                            <div class="kpi-label">Pending Registrar</div>
                            <small class="kpi-subtitle">Waiting campus registrar action</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-time-five fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_APPROVED]) }}" class="text-decoration-none">
                <div class="kpi-card role-approved">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $approvedCount }}</div>
                            <div class="kpi-label">Approved Trainings</div>
                            <small class="kpi-subtitle">Fully cleared through HQ & Director</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-check-circle fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}" class="text-decoration-none">
                <div class="kpi-card role-rejected">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $rejectedCount }}</div>
                            <div class="kpi-label">Rejected / Returned</div>
                            <small class="kpi-subtitle">Sent back with comments</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-x-circle fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        {{-- HOD: MY OWN TRAININGS --}}
        @if(Auth::user()->hasRole('hod'))
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_DRAFT]) }}" class="text-decoration-none">
                <div class="kpi-card role-draft">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $hodDraftTrainings }}</div>
                            <div class="kpi-label">My Draft Trainings</div>
                            <small class="kpi-subtitle">You can still edit these</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-edit fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_PENDING_REGISTRAR]) }}" class="text-decoration-none">
                <div class="kpi-card role-pending">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $hodPendingRegistrar }}</div>
                            <div class="kpi-label">Awaiting Registrar</div>
                            <small class="kpi-subtitle">Submitted and locked for editing</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-time-five fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}" class="text-decoration-none">
                <div class="kpi-card role-rejected">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $hodRejectedTrainings }}</div>
                            <div class="kpi-label">Returned / Rejected</div>
                            <small class="kpi-subtitle">Review comments & resubmit</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-message-x fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        {{-- CAMPUS REGISTRAR --}}
        @if(Auth::user()->hasRole('campus_registrar'))
        <div class="col">
            <div class="kpi-card role-pending">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $registrarPendingTrainings }}</div>
                        <div class="kpi-label">Pending Registrar</div>
                        <small class="kpi-subtitle">Waiting your approval / rejection</small>
                    </div>
                    <div class="ms-auto">
                        <i class='bx bx-time-five fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="kpi-card role-approved">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $registrarToHqTrainings }}</div>
                        <div class="kpi-label">Sent to HQ</div>
                        <small class="kpi-subtitle">Approved & forwarded for HQ review</small>
                    </div>
                    <div class="ms-auto">
                        <i class='bx bx-send fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- HQ REGISTRAR --}}
        @if(Auth::user()->hasRole('kihbt_registrar'))
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_APPROVED]) }}" class="text-decoration-none">
                <div class="kpi-card role-approved">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $globalApprovedTrainings }}</div>
                            <div class="kpi-label">All Approved Trainings</div>
                            <small class="kpi-subtitle">Across all campuses</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-check-circle fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}" class="text-decoration-none">
                <div class="kpi-card role-rejected">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $globalRejectedTrainings }}</div>
                            <div class="kpi-label">All Rejected Trainings</div>
                            <small class="kpi-subtitle">Across all campuses</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-x-circle fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <div class="kpi-card role-hq">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $hqQueueTrainings }}</div>
                        <div class="kpi-label">HQ Review Queue</div>
                        <small class="kpi-subtitle">Awaiting HQ registrar action</small>
                    </div>
                    <div class="ms-auto">
                        <i class='bx bx-task fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- DIRECTOR --}}
        @if(Auth::user()->hasRole('director'))
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_APPROVED]) }}" class="text-decoration-none">
                <div class="kpi-card role-approved">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $globalApprovedTrainings }}</div>
                            <div class="kpi-label">All Approved Trainings</div>
                            <small class="kpi-subtitle">Across all campuses</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-check-circle fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('all.trainings', ['status' => \App\Models\Training::STATUS_REJECTED]) }}" class="text-decoration-none">
                <div class="kpi-card role-rejected">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="kpi-value">{{ $globalRejectedTrainings }}</div>
                            <div class="kpi-label">All Rejected Trainings</div>
                            <small class="kpi-subtitle">Across all campuses</small>
                        </div>
                        <div class="ms-auto">
                            <i class='bx bx-x-circle fs-3'></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <div class="kpi-card role-director">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="kpi-value">{{ $directorQueueTrainings }}</div>
                        <div class="kpi-label">Director Approval Queue</div>
                        <small class="kpi-subtitle">Awaiting your final decision</small>
                    </div>
                    <div class="ms-auto">
                        <i class='bx bx-user-check fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- RECENT TRAININGS --}}
    <div class="recent-card">
        <div class="card-body">
            @php
            $dashboardUser = Auth::user();
            $roleNames     = $dashboardUser->getRoleNames();
            $primaryRole   = $roleNames->first();
            @endphp

            {{-- Header + role hint + filters --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center mb-2 gap-3">
                <div class="flex-grow-1">
                    <h5 class="mb-0 fw-bold">Recent Trainings</h5>
                    <small class="text-muted fw-semibold d-block">
                        Latest training schedules visible to you as
                        <span class="badge bg-primary text-white">
                            {{ strtoupper(str_replace('_', ' ', $primaryRole ?? 'USER')) }}
                        </span>
                    </small>
                </div>

                {{-- Filters --}}
                <form method="GET" action="{{ route('all.trainings') }}" class="toolbar">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
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
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Course / Code">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bx bx-search me-1"></i>Filter
                        </button>
                    </div>
                </form>
            </div>

            <hr>

            {{-- Status Legend --}}
            <div class="status-legend mb-3">
                <span><span class="badge bg-secondary">&nbsp;</span> Draft</span>
                <span><span class="badge bg-warning text-dark">&nbsp;</span> Pending Registrar</span>
                <span><span class="badge bg-info text-dark">&nbsp;</span> Approved to HQ</span>
                <span><span class="badge bg-primary">&nbsp;</span> HQ Reviewed</span>
                <span><span class="badge bg-success">&nbsp;</span> Approved</span>
                <span><span class="badge bg-danger">&nbsp;</span> Rejected</span>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
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
                            <td><input type="checkbox" class="app-row-checkbox"></td>
                            <td class="fw-semibold">{{ 'TR-' . str_pad($training->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="course-name">
                                {{ optional($training->course)->course_name ?? 'N/A' }}
                                @if(optional($training->course)->course_code)
                                <br><small class="text-muted">({{ $training->course->course_code }})</small>
                                @endif
                            </td>
                            <td>{{ optional($training->college)->name ?? 'N/A' }}</td>
                            <td class="applicant-name">{{ optional($training->user)->name ?? 'N/A' }}</td>
                            <td>
                                @if($training->start_date)
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <span class="{{ $badgeClass }} w-100 fw-semibold">{{ $status }}</span>
                                @if($training->status === \App\Models\Training::STATUS_REJECTED && $training->rejection_comment)
                                <span class="ms-1 text-warning" style="cursor:pointer;"
                                      data-bs-toggle="tooltip" data-bs-html="true"
                                      title="<strong>Returned with comments</strong><br>Stage: {{ ucfirst(str_replace('_',' ', $training->rejection_stage)) }}<br>{{ $training->rejection_comment }}<br>@if($training->rejected_at)<small class='text-muted'>On {{ $training->rejected_at->format('d M Y H:i') }}</small>@endif">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('trainings.show', $training) }}" class="text-primary" title="View training details">
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

    {{-- GLOBAL TRAINING STATUS SNAPSHOT --}}
    <div class="row mt-4">
        <div class="col-12 col-xl-7 mb-3">
            <div class="chart-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="mb-0 fw-bold">Training Workflow Overview</h5>
                        <span class="badge bg-secondary ms-2">All statuses</span>
                    </div>
                    <small class="text-muted fw-semibold d-block mb-3">
                        Visual snapshot of training applications by month
                    </small>
                    <div style="height:260px;">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary by status --}}
        <div class="col-12 col-xl-5 mb-3">
            <div class="summary-list">
                <div class="card-body">
                    <h5 class="mb-0 fw-bold">Trainings by Status</h5>
                    <small class="text-muted fw-semibold d-block mb-3">System-wide overview</small>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Draft</span>
                        <span class="badge bg-secondary fw-semibold">{{ $draftCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Pending Registrar Approval</span>
                        <span class="badge bg-warning text-dark fw-semibold">{{ $pendingCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Approved (Final)</span>
                        <span class="badge bg-success fw-semibold">{{ $approvedCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Rejected</span>
                        <span class="badge bg-danger fw-semibold">{{ $rejectedCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>{{-- /.page-content --}}

{{-- Chart + bulk checkbox JS --}}
<script>
// === Chart: Trainings by Month ===
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
                backgroundColor: 'rgba(59,40,24,0.85)', /* KIHBT Brown */
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

// === Enable Bootstrap tooltips ===
document.addEventListener("DOMContentLoaded", function () {
    if (window.bootstrap) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>

@endsection
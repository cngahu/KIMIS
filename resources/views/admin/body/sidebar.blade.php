<style>
    :root {
        --primary: #3b2818;
        --primary-light: #5a3d2b;
        --primary-dark: #2a1a0f;
        --accent: #f9a90f;
        --accent-hover: #d18b00;
        --bg-sidebar: #3b2818;
        --bg-submenu: #f7f4ee;
        --bg-hover: rgba(255,255,255,0.1);
        --bg-active: rgba(249,169,15,0.15);
        --text-light: #ffffff;
        --text-muted: rgba(255,255,255,0.75);
        --text-submenu: #222222;
        --text-submenu-muted: #555555;
        --border-sidebar: rgba(0,0,0,0.25);
        --border-submenu: rgba(0,0,0,0.08);
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.15);
        --transition-fast: 0.15s ease;
        --transition-normal: 0.25s ease;
        --sidebar-width: 260px;
        --sidebar-collapsed-width: 68px;
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --radius-sm: 4px;
        --radius-md: 8px;
        --radius-lg: 12px;
    }

    /* ── Sidebar wrapper ── */
    .sidebar-wrapper.kihbt-sidebar {
        background: var(--bg-sidebar);
        color: var(--text-light);
        width: var(--sidebar-width);
        min-height: 100vh;
        flex-shrink: 0;
        transition: width var(--transition-normal);
        z-index: 1040;
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    /* ── COLLAPSED STATE (works on both desktop and mobile) ── */
    .sidebar-wrapper.kihbt-sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    /* Hide text when collapsed */
    .sidebar-wrapper.kihbt-sidebar.collapsed .logo-text,
    .sidebar-wrapper.kihbt-sidebar.collapsed .menu-title,
    .sidebar-wrapper.kihbt-sidebar.collapsed .menu-label,
    .sidebar-wrapper.kihbt-sidebar.collapsed .has-arrow::after {
        display: none !important;
    }

    /* Center icons when collapsed */
    .sidebar-wrapper.kihbt-sidebar.collapsed .metismenu > li > a {
        justify-content: center !important;
        padding: 0.75rem 0 !important;
    }

    .sidebar-wrapper.kihbt-sidebar.collapsed .parent-icon {
        margin: 0;
    }

    /* Hide submenus when collapsed */
    .sidebar-wrapper.kihbt-sidebar.collapsed .metismenu > li > ul {
        display: none !important;
    }

    /* Tooltip on hover when collapsed */
    .sidebar-wrapper.kihbt-sidebar.collapsed .metismenu > li {
        position: relative;
    }

    .sidebar-wrapper.kihbt-sidebar.collapsed .metismenu > li:hover > a::after {
        content: attr(data-title);
        position: absolute;
        left: calc(var(--sidebar-collapsed-width) + 8px);
        top: 50%;
        transform: translateY(-50%);
        background: var(--primary-dark);
        color: var(--text-light);
        padding: 6px 12px;
        border-radius: var(--radius-md);
        font-size: 0.82rem;
        font-weight: 600;
        white-space: nowrap;
        z-index: 9999;
        box-shadow: var(--shadow-md);
        pointer-events: none;
    }

    /* Flip toggle arrow when collapsed */
    .sidebar-wrapper.kihbt-sidebar.collapsed #sidebarToggle i {
        transform: rotate(180deg);
    }

    /* ── Sidebar header ── */
    .kihbt-sidebar .sidebar-header {
        background: var(--bg-sidebar);
        border-bottom: 1px solid var(--border-sidebar);
        padding: var(--spacing-md);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 60px;
        overflow: hidden;
    }

    .kihbt-sidebar .sidebar-header .logo-icon {
        width: 36px;
        height: 36px;
        object-fit: contain;
        flex-shrink: 0;
        transition: transform var(--transition-fast);
    }

    .kihbt-sidebar .sidebar-header .logo-icon:hover {
        transform: scale(1.05);
    }

    .kihbt-sidebar .sidebar-header .logo-text {
        color: var(--text-light);
        font-weight: 700;
        font-size: 1rem;
        margin-left: var(--spacing-sm);
        white-space: nowrap;
        transition: opacity var(--transition-normal);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        cursor: pointer;
        flex-shrink: 0;
        transition: background var(--transition-fast);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon i {
        color: var(--accent);
        font-size: 1.3rem;
        transition: transform var(--transition-normal), color var(--transition-fast);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon:hover {
        background: var(--bg-hover);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon:hover i {
        color: var(--text-light);
    }

    /* ── Navigation ── */
    .kihbt-sidebar .metismenu {
        padding: var(--spacing-sm) 0;
    }

    .kihbt-sidebar .metismenu > li {
        margin: 2px 0;
    }

    .kihbt-sidebar .metismenu > li > a {
        color: var(--text-light);
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.75rem var(--spacing-md);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        border-radius: var(--radius-sm);
        transition: all var(--transition-fast);
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
    }

    .kihbt-sidebar .metismenu > li > a:hover {
        background: var(--bg-hover);
        color: var(--accent);
    }

    .kihbt-sidebar .metismenu > li > a:hover .parent-icon i {
        color: var(--accent);
    }

    .kihbt-sidebar .metismenu li .parent-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        min-width: 24px;
    }

    .kihbt-sidebar .metismenu li .parent-icon i {
        color: var(--text-light);
        font-size: 1.1rem;
        transition: color var(--transition-fast), transform var(--transition-fast);
    }

    .kihbt-sidebar .metismenu .menu-title {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kihbt-sidebar .metismenu .has-arrow::after {
        content: '▼';
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-left: auto;
        flex-shrink: 0;
        transition: transform var(--transition-fast), color var(--transition-fast);
    }

    .kihbt-sidebar .metismenu .has-arrow.mm-active::after {
        transform: rotate(180deg);
        color: var(--accent);
    }

    /* Submenu */
    .kihbt-sidebar .metismenu > li > ul {
        background: var(--bg-submenu);
        border-radius: var(--radius-md);
        margin: 4px var(--spacing-md) 8px;
        padding: 4px 0;
        box-shadow: inset 0 1px 2px var(--border-submenu);
    }

    .kihbt-sidebar .metismenu ul li a {
        color: var(--text-submenu);
        font-size: 0.87rem;
        padding: 0.5rem var(--spacing-md) 0.5rem calc(var(--spacing-md) + 1.5rem);
        border-radius: var(--radius-sm);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        transition: all var(--transition-fast);
        text-decoration: none;
        white-space: nowrap;
    }

    .kihbt-sidebar .metismenu ul li a i {
        color: var(--text-submenu-muted);
        font-size: 0.9rem;
        width: 16px;
        text-align: center;
        transition: color var(--transition-fast), transform var(--transition-fast);
    }

    .kihbt-sidebar .metismenu ul li a:hover {
        background: rgba(0,0,0,0.05);
        color: var(--primary);
        padding-left: calc(var(--spacing-md) + 1.5rem + 4px);
    }

    .kihbt-sidebar .metismenu ul li a:hover i {
        color: var(--primary);
    }

    /* Active */
    .kihbt-sidebar .metismenu .mm-active > a {
        color: var(--accent);
        background: var(--bg-active);
        font-weight: 600;
    }

    .kihbt-sidebar .metismenu .mm-active > a .parent-icon i {
        color: var(--accent);
    }

    .kihbt-sidebar .metismenu ul li.mm-active > a {
        color: var(--primary);
        background: rgba(249,169,15,0.2);
        font-weight: 700;
    }

    /* Section labels */
    .kihbt-sidebar .menu-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        padding: var(--spacing-lg) var(--spacing-md) var(--spacing-xs);
        font-weight: 600;
        white-space: nowrap;
    }

    .kihbt-sidebar .badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        font-weight: 600;
    }

    /* ── MOBILE ── */
    @media (max-width: 991px) {
        .sidebar-wrapper.kihbt-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            /* Start hidden off-screen */
            transform: translateX(-100%);
            /* Width: full when expanded, icon-only when collapsed */
            width: var(--sidebar-width);
            z-index: 1050;
            transition: transform var(--transition-normal), width var(--transition-normal);
        }

        /* Slide in when active */
        .sidebar-wrapper.kihbt-sidebar.active {
            transform: translateX(0);
        }

        /* When active + collapsed on mobile: show as icon strip */
        .sidebar-wrapper.kihbt-sidebar.active.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1045;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-fast);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    }

    /* ── Scrollbar ── */
    .kihbt-sidebar {
        scrollbar-width: thin;
        scrollbar-color: var(--accent) var(--primary-dark);
    }

    .kihbt-sidebar::-webkit-scrollbar { width: 5px; }
    .kihbt-sidebar::-webkit-scrollbar-track { background: var(--primary-dark); }
    .kihbt-sidebar::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 3px; }

    /* ── Accessibility ── */
    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    .kihbt-sidebar a:focus,
    .kihbt-sidebar .toggle-icon:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }
</style>

@php $user = \Illuminate\Support\Facades\Auth::user(); @endphp

<div class="sidebar-wrapper kihbt-sidebar" id="sidebarWrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="d-flex align-items-center overflow-hidden">
            @if($user->hasRole('student'))
                <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="logo-icon" alt="KIHBT Logo">
                    <span class="logo-text ms-2">KIHBT</span>
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="logo-icon" alt="KIHBT Logo">
                    <span class="logo-text ms-2">KIHBT</span>
                </a>
            @endif
        </div>
        <div class="toggle-icon ms-auto" id="sidebarToggle" aria-label="Toggle sidebar" role="button" tabindex="0">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">

        {{-- STUDENT MENU --}}
        @if($user->hasRole('student'))
            @include('admin.body.partials._student')
        @endif

        {{-- HOD MENU --}}
        @if($user->hasRole('hod'))
            @include('admin.body.partials._hod')
        @endif

        {{-- Roles & Permissions --}}
        @if(Auth::user()->can('roles.menu'))
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Roles & Permissions" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Roles & Permissions</div>
                </a>
                <ul>
                    <li><a href="{{ route('all.permission') }}"><i class="bx bx-right-arrow-alt"></i>All Permissions</a></li>
                    <li><a href="{{ route('all.roles') }}"><i class="bx bx-right-arrow-alt"></i>Roles</a></li>
                    <li><a href="{{ route('all.roles.permission') }}"><i class="bx bx-right-arrow-alt"></i>Roles in Permission</a></li>
                </ul>
            </li>
        @endif

        {{-- User Setups --}}
        @if(Auth::user()->can('users.menu'))
            <li>
                <a class="has-arrow" href="javascript:;" data-title="User Setups" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-repeat"></i></div>
                    <div class="menu-title">User Setups</div>
                </a>
                <ul>
                    @if(Auth::user()->can('users.all'))
                        <li><a href="{{ route('admin.users.index') }}"><i class="bx bx-right-arrow-alt"></i>All Admin</a></li>
                    @endif
                    @if(Auth::user()->can('users.add'))
                        <li><a href="{{ route('admin.users.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Admin</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- SUPERADMIN MENU --}}
        @if(Auth::user()->hasRole('superadmin'))
            <li>
                <a href="{{ route('admin.logs.errors') }}" data-title="Errors">
                    <div class="parent-icon"><i class='bx bx-error'></i></div>
                    <div class="menu-title">Errors</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Training Courses" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Training Courses</div>
                </a>
                <ul>
                    <li><a href="{{ route('all.trainings') }}"><i class="bx bx-right-arrow-alt"></i>Training Schedules</a></li>
                    <li><a href="{{ route('all.courses') }}"><i class="bx bx-right-arrow-alt"></i>Courses</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Academic Setup" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-open'></i></div>
                    <div class="menu-title">Academic Setup</div>
                </a>
                <ul>
                    <li><a href="{{ route('course_cohorts.index') }}"><i class="bx bx-right-arrow-alt"></i>Course Cohorts</a></li>
                    <li><a href="{{ route('course_stages.index') }}"><i class="bx bx-right-arrow-alt"></i>Course Stages</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Geographical Data" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-map'></i></div>
                    <div class="menu-title">Geographical Data</div>
                </a>
                <ul>
                    <li><a href="{{ route('backend.counties.index') }}"><i class="bx bx-right-arrow-alt"></i>Counties</a></li>
                    <li><a href="{{ route('backend.subcounties.index') }}"><i class="bx bx-right-arrow-alt"></i>Sub Counties</a></li>
                    <li><a href="{{ route('backend.postal_codes.index') }}"><i class="bx bx-right-arrow-alt"></i>Postal Codes</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Data Imports" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-cloud-upload'></i></div>
                    <div class="menu-title">Data Imports</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.admissions.import.form') }}"><i class="bx bx-right-arrow-alt"></i>Admissions Data</a></li>
                    <li><a href="{{ route('admin.biodata.import.form') }}"><i class="bx bx-right-arrow-alt"></i>Student Bio Data</a></li>
                    <li><a href="{{ route('admin.shortcourses.import.form') }}"><i class="bx bx-right-arrow-alt"></i>Short Course Certificates</a></li>
                    <li><a href="{{ route('masterdata.index') }}"><i class="bx bx-right-arrow-alt"></i>Master Data</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Fee Structure" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-dollar-circle'></i></div>
                    <div class="menu-title">Fee Structure</div>
                </a>
                <ul>
                    <li><a href="{{ route('course_structure.home') }}"><i class="bx bx-right-arrow-alt"></i>Course Structure</a></li>
                    <li><a href="{{ route('course_fees.home') }}"><i class="bx bx-right-arrow-alt"></i>Fee Structure</a></li>
                </ul>
            </li>
            <li><a href="{{ route('backend.academic-departments.index') }}" data-title="Academic Departments"><div class="parent-icon"><i class='bx bx-buildings'></i></div><div class="menu-title">Academic Departments</div></a></li>
            <li><a href="{{ route('admin.dashboard.master') }}" data-title="Master Dashboard"><div class="parent-icon"><i class='bx bx-tachometer'></i></div><div class="menu-title">Master Dashboard</div></a></li>
            <li><a href="{{ route('admin.class-lists.index') }}" data-title="Master Class Lists"><div class="parent-icon"><i class='bx bx-list-ul'></i></div><div class="menu-title">Master Class Lists</div></a></li>
            <li><a href="{{ route('timeline.global') }}" data-title="Academic Timeline"><div class="parent-icon"><i class='bx bx-calendar'></i></div><div class="menu-title">Academic Timeline</div></a></li>
            <li class="menu-label">User Management</li>
            <li><a href="{{ route('admin.users.index') }}" data-title="Internal Users"><div class="parent-icon"><i class='bx bx-user-pin'></i></div><div class="menu-title">Manage Internal Users</div></a></li>
            <li><a href="{{ route('admin.users.students') }}" data-title="Student Accounts"><div class="parent-icon"><i class='bx bx-group'></i></div><div class="menu-title">Manage Student Accounts</div></a></li>
            <li><a href="{{ route('admin.biodata.index') }}" data-title="Bio Data"><div class="parent-icon"><i class='bx bx-id-card'></i></div><div class="menu-title">Student Bio Data</div></a></li>
            <li class="menu-label">Course Applications</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Applications" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Course Applications</div>
                </a>
                <ul>
                    <li><a href="{{ route('registrar.dashboard') }}"><i class="bx bx-radio-circle"></i>Dashboard</a></li>
                    <li><a href="{{ route('registrar.applications.awaiting') }}"><i class="bx bx-radio-circle"></i>Awaiting Assignment @if(isset($counts) && $counts['awaiting'] > 0)<span class="badge bg-warning ms-2">{{ $counts['awaiting'] }}</span>@endif</a></li>
                    <li><a href="{{ route('registrar.applications.assigned') }}"><i class="bx bx-radio-circle"></i>Under Review @if(isset($counts) && $counts['assigned'] > 0)<span class="badge bg-info ms-2">{{ $counts['assigned'] }}</span>@endif</a></li>
                    <li><a href="{{ route('registrar.applications.completed') }}"><i class="bx bx-radio-circle"></i>Completed @if(isset($counts) && $counts['completed'] > 0)<span class="badge bg-success ms-2">{{ $counts['completed'] }}</span>@endif</a></li>
                </ul>
            </li>
            <li class="menu-label">KNEC Reports</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="KNEC Reports" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-file'></i></div>
                    <div class="menu-title">KNEC Reports</div>
                </a>
                <ul>
                    <li><a href="{{ route('reports.applications') }}"><i class="bx bx-radio-circle"></i>All KNEC Applications</a></li>
                    <li><a href="{{ route('knec.reports.applications') }}"><i class="bx bx-radio-circle"></i>KNEC Filter</a></li>
                    <li><a href="{{ route('reports.rejected') }}"><i class="bx bx-radio-circle"></i>Approved / Rejected</a></li>
                    <li><a href="{{ route('reports.summary.index') }}"><i class="bx bx-radio-circle"></i>KNEC Summary</a></li>
                </ul>
            </li>
            <li class="menu-label">Short Courses Reports</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Short Courses" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-file'></i></div>
                    <div class="menu-title">Short Courses Reports</div>
                </a>
                <ul>
                    <li><a href="{{ route('reports.short.applications') }}"><i class="bx bx-radio-circle"></i>Applications</a></li>
                    <li><a href="{{ route('reports.short.training.summary') }}"><i class="bx bx-radio-circle"></i>Training Summary</a></li>
                    <li><a href="{{ route('reports.short.participants') }}"><i class="bx bx-radio-circle"></i>Participants</a></li>
                    <li><a href="{{ route('reports.short.employers') }}"><i class="bx bx-radio-circle"></i>Employers</a></li>
                    <li><a href="{{ route('reports.short.revenue.index') }}"><i class="bx bx-radio-circle"></i>Revenue Report</a></li>
                </ul>
            </li>
            <li class="menu-label">Vetting</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Vetting" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Vetting</div>
                </a>
                <ul>
                    <li><a href="{{ route('registrar.verification.index') }}"><i class="bx bx-radio-circle"></i>Awaiting</a></li>
                    <li><a href="{{ route('admin.admissions.verified') }}"><i class="bx bx-radio-circle"></i>Verified</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Upload Documents" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-upload'></i></div>
                    <div class="menu-title">Upload Documents</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.admission.documents.index') }}"><i class="bx bx-radio-circle"></i>All Uploaded Documents</a></li>
                </ul>
            </li>
        @endif

        {{-- ACCOUNTS / CASH OFFICE --}}
        @if(Auth::user()->hasRole('accounts') || Auth::user()->hasRole('cash_office') || Auth::user()->hasRole('superadmin'))
            <li class="menu-label">Accounts</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Accounts" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Accounts</div>
                </a>
                <ul>
                    <li><a href="{{ route('accounts.dashboard') }}"><i class="bx bx-radio-circle"></i>Dashboard</a></li>
                    <li><a href="{{ route('finance.students.index') }}"><i class="bx bx-radio-circle"></i>Ledger</a></li>
                    <li><a href="{{ route('finance.dashboard') }}"><i class="bx bx-radio-circle"></i>Ledger Dashboard</a></li>
                    <li><a href="{{ route('accounts.invoices') }}"><i class="bx bx-radio-circle"></i>Invoices</a></li>
                    <li><a href="{{ route('reports.daily.collections') }}"><i class="bx bx-radio-circle"></i>Daily Collections</a></li>
                    <li><a href="{{ route('reports.outstanding') }}"><i class="bx bx-radio-circle"></i>Outstanding Payments</a></li>
                </ul>
            </li>
        @endif

        {{-- HOD --}}
        @if(Auth::user()->hasRole('hod'))
            <li class="menu-label">Department</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Training & Courses" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Training & Courses</div>
                </a>
                <ul>
                    <li><a href="{{ route('all.trainings') }}"><i class="bx bx-right-arrow-alt"></i>Training Schedules</a></li>
                    <li><a href="{{ route('all.courses') }}"><i class="bx bx-right-arrow-alt"></i>Courses</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="My Applications" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-task'></i></div>
                    <div class="menu-title">My Applications</div>
                </a>
                <ul>
                    <li><a href="{{ route('officer.applications.pending') }}"><i class="bx bx-radio-circle"></i>Pending Review</a></li>
                    <li><a href="{{ route('officer.applications.completed') }}"><i class="bx bx-radio-circle"></i>Completed Reviews</a></li>
                </ul>
            </li>
        @endif

        {{-- CAMPUS REGISTRAR --}}
        @if(Auth::user()->hasRole('campus_registrar'))
            <li class="menu-label">Department</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Registrar Actions" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Registrar Actions</div>
                </a>
                <ul>
                    <li><a href="{{ route('trainings.registrar.index') }}"><i class="bx bx-right-arrow-alt"></i>Registrar Approval Queue</a></li>
                    <li><a href="{{ route('all.courses') }}"><i class="bx bx-right-arrow-alt"></i>Courses</a></li>
                </ul>
            </li>
        @endif

        {{-- HQ REGISTRAR --}}
        @if(Auth::user()->hasRole('kihbt_registrar'))
            <li class="menu-label">Department</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="HQ Registrar" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Registrar Actions</div>
                </a>
                <ul>
                    <li><a href="{{ route('trainings.hqregistrar.index') }}"><i class="bx bx-right-arrow-alt"></i>HQ Registrar Queue</a></li>
                    <li><a href="{{ route('registrar.applications.completed') }}"><i class="bx bx-radio-circle"></i>Completed Reviews</a></li>
                    <li><a href="{{ route('all.courses') }}"><i class="bx bx-right-arrow-alt"></i>Courses</a></li>
                </ul>
            </li>
        @endif

        {{-- DIRECTOR --}}
        @if(Auth::user()->hasRole('director'))
            <li class="menu-label">Director Dashboard</li>
            <li>
                <a href="javascript:;" class="has-arrow" data-title="Director Actions" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Director Actions</div>
                </a>
                <ul>
                    <li><a href="{{ route('trainings.drregistrar.index') }}"><i class="bx bx-right-arrow-alt"></i>Director Queue</a></li>
                    <li><a href="{{ route('registrar.applications.completed') }}"><i class="bx bx-radio-circle"></i>Completed Reviews</a></li>
                    <li><a href="{{ route('all.courses') }}"><i class="bx bx-right-arrow-alt"></i>Courses</a></li>
                </ul>
            </li>
        @endif

    </ul>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar     = document.getElementById('sidebarWrapper');
    const toggle      = document.getElementById('sidebarToggle');
    const overlay     = document.getElementById('sidebarOverlay');
    const STORAGE_KEY = 'kihbt_sidebar_collapsed';

    const isMobile = () => window.innerWidth <= 991;

    // ── Restore collapsed state on page load (both desktop and mobile) ──
    if (localStorage.getItem(STORAGE_KEY) === '1') {
        sidebar.classList.add('collapsed');
    }

    // ── Arrow toggle: collapse/expand on BOTH desktop and mobile ──
    toggle?.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem(STORAGE_KEY, sidebar.classList.contains('collapsed') ? '1' : '0');
    });

    // ── Mobile hamburger (in header) opens sidebar ──
    // header.blade.php's #mobileHamburger adds .active to sidebar
    // Nothing needed here for that — handled in header.blade.php

    // ── Close sidebar overlay on mobile when overlay clicked ──
    overlay?.addEventListener('click', function () {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    // ── On resize to desktop: remove mobile-specific active state ──
    window.addEventListener('resize', function () {
        if (!isMobile()) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>

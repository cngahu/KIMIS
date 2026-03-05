<style>
    /* ================= CSS VARIABLES - KIHBT BRAND ================= */
    :root {
        /* Brand Colors */
        --primary: #3b2818;           /* KIHBT Brown */
        --primary-light: #5a3d2b;     /* Lighter Brown */
        --primary-dark: #2a1a0f;      /* Darker Brown */
        --accent: #f9a90f;            /* KIHBT Gold */
        --accent-hover: #d18b00;      /* Darker Gold */
        
        /* Backgrounds */
        --bg-sidebar: #3b2818;
        --bg-submenu: #f7f4ee;
        --bg-hover: rgba(255,255,255,0.1);
        --bg-active: rgba(249, 169, 15, 0.15);
        
        /* Text Colors */
        --text-light: #ffffff;
        --text-muted: rgba(255,255,255,0.75);
        --text-submenu: #222222;
        --text-submenu-muted: #555555;
        
        /* Borders */
        --border-sidebar: rgba(0,0,0,0.25);
        --border-submenu: rgba(0,0,0,0.08);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.15);
        
        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition-normal: 0.25s ease;
        
        /* Spacing */
        --sidebar-width: 260px;
        --sidebar-collapsed-width: 70px;
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        
        /* Radius */
        --radius-sm: 4px;
        --radius-md: 8px;
        --radius-lg: 12px;
    }

    /* ================= SIDEBAR WRAPPER ================= */
    .sidebar-wrapper.kihbt-sidebar {
        background: var(--bg-sidebar);
        color: var(--text-light);
        width: var(--sidebar-width);
        transition: width var(--transition-normal), transform var(--transition-normal);
        z-index: 1040;
        box-shadow: var(--shadow-md);
    }

    .sidebar-wrapper.kihbt-sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar-wrapper.kihbt-sidebar.collapsed .logo-text,
    .sidebar-wrapper.kihbt-sidebar.collapsed .menu-title,
    .sidebar-wrapper.kihbt-sidebar.collapsed .menu-label {
        display: none;
    }

    .sidebar-wrapper.kihbt-sidebar.collapsed .parent-icon {
        margin: 0 auto;
    }

    /* ================= SIDEBAR HEADER ================= */
    .kihbt-sidebar .sidebar-header {
        background: var(--bg-sidebar);
        border-bottom: 1px solid var(--border-sidebar);
        padding: var(--spacing-md);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 60px;
        transition: padding var(--transition-normal);
    }

    .kihbt-sidebar .sidebar-header .logo-icon {
        width: 50px;
        height: 50px;
        object-fit: contain;
        opacity: 1;
        transition: transform var(--transition-fast);
    }

    .kihbt-sidebar .sidebar-header .logo-icon:hover {
        transform: scale(1.05);
    }

    .kihbt-sidebar .sidebar-header .logo-text {
        color: var(--text-light);
        font-weight: 700;
        font-size: 1.1rem;
        margin-left: var(--spacing-sm);
        white-space: nowrap;
    }

    .kihbt-sidebar .sidebar-header .toggle-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon i {
        color: var(--accent);
        font-size: 1.2rem;
        transition: transform var(--transition-fast), color var(--transition-fast);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon:hover {
        background: var(--bg-hover);
    }

    .kihbt-sidebar .sidebar-header .toggle-icon:hover i {
        color: var(--text-light);
        transform: scale(1.1);
    }

    /* ================= NAVIGATION MENU ================= */
    .kihbt-sidebar .metismenu {
        padding: var(--spacing-sm) 0;
    }

    .kihbt-sidebar .metismenu > li {
        margin: 2px 0;
    }

    /* Top-level menu items */
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
    }

    .kihbt-sidebar .metismenu > li > a:hover {
        background: var(--bg-hover);
        color: var(--accent);
        padding-left: calc(var(--spacing-md) + 4px);
    }

    .kihbt-sidebar .metismenu > li > a:hover .parent-icon i {
        color: var(--accent);
        transform: translateX(2px);
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
        transition: transform var(--transition-fast), color var(--transition-fast);
    }

    .kihbt-sidebar .metismenu .has-arrow.mm-active::after {
        transform: rotate(180deg);
        color: var(--accent);
    }

    /* SUBMENU CONTAINER */
    .kihbt-sidebar .metismenu > li > ul {
        background: var(--bg-submenu);
        border-radius: var(--radius-md);
        margin: 4px var(--spacing-md) 8px;
        padding: 4px 0;
        box-shadow: inset 0 1px 2px var(--border-submenu);
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Submenu links */
    .kihbt-sidebar .metismenu ul li a {
        color: var(--text-submenu);
        font-size: 0.87rem;
        padding: 0.5rem var(--spacing-md) 0.5rem calc(var(--spacing-md) + 1.5rem);
        border-radius: var(--radius-sm);
        font-weight: 600;
        letter-spacing: 0.2px;
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        transition: all var(--transition-fast);
        text-decoration: none;
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
        transform: translateX(2px);
    }

    /* Active states */
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
        background: rgba(249, 169, 15, 0.2);
        font-weight: 700;
    }

    .kihbt-sidebar .metismenu ul li.mm-active > a i {
        color: var(--primary);
    }

    /* Section labels */
    .kihbt-sidebar .menu-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        padding: var(--spacing-lg) var(--spacing-md) var(--spacing-xs);
        font-weight: 600;
        opacity: 0.85;
        white-space: nowrap;
    }

    /* Badge styling */
    .kihbt-sidebar .badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        font-weight: 600;
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 991px) {
        .sidebar-wrapper.kihbt-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            transform: translateX(-100%);
            width: var(--sidebar-width);
            z-index: 1050;
        }

        .sidebar-wrapper.kihbt-sidebar.active {
            transform: translateX(0);
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        .kihbt-sidebar .sidebar-header {
            padding: var(--spacing-md);
        }

        .kihbt-sidebar .metismenu > li > a {
            padding: 0.75rem var(--spacing-md);
        }

        .kihbt-sidebar .metismenu > li > ul {
            margin: 4px var(--spacing-md) 8px;
        }
    }

    

    @media (max-width: 575px) {
        :root {
            --sidebar-width: 240px;
        }

        .kihbt-sidebar .menu-label {
            padding: var(--spacing-md) var(--spacing-md) var(--spacing-xs);
            font-size: 0.7rem;
        }

        .kihbt-sidebar .metismenu > li > a {
            font-size: 0.85rem;
            padding: 0.65rem var(--spacing-md);
        }

        .kihbt-sidebar .metismenu ul li a {
            font-size: 0.82rem;
            padding: 0.45rem var(--spacing-md) 0.45rem calc(var(--spacing-md) + 1.5rem);
        }
    }

    /* ================= ACCESSIBILITY ================= */
    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
            animation: none !important;
        }
    }

    .kihbt-sidebar a:focus,
    .kihbt-sidebar .toggle-icon:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .kihbt-sidebar .metismenu > li > a,
        .kihbt-sidebar .metismenu ul li a {
            border: 1px solid transparent;
        }

        .kihbt-sidebar .metismenu > li > a:hover,
        .kihbt-sidebar .metismenu ul li a:hover {
            border-color: var(--accent);
        }
    }

    /* ================= SCROLLBAR STYLING ================= */
    .kihbt-sidebar[data-simplebar="true"] .simplebar-content-wrapper {
        scrollbar-width: thin;
        scrollbar-color: var(--accent) var(--primary-dark);
    }

    .kihbt-sidebar[data-simplebar="true"] .simplebar-content-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .kihbt-sidebar[data-simplebar="true"] .simplebar-content-wrapper::-webkit-scrollbar-track {
        background: var(--primary-dark);
    }

    .kihbt-sidebar[data-simplebar="true"] .simplebar-content-wrapper::-webkit-scrollbar-thumb {
        background: var(--accent);
        border-radius: 3px;
    }

    .kihbt-sidebar[data-simplebar="true"] .simplebar-content-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--accent-hover);
    }
</style>

@php $user = \Illuminate\Support\Facades\Auth::user(); @endphp

<div class="sidebar-wrapper kihbt-sidebar" data-simplebar="true">
    <div class="sidebar-header">
        <div class="d-flex align-items-center">
            @if($user->hasRole('student'))
                <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="logo-icon" alt="KIHBT Logo">
                    <span class="logo-text">KIHBT</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="logo-icon" alt="KIHBT Logo">
                    <span class="logo-text">KIHBT</span>
                </a>
            @endif
        </div>
        <div class="toggle-icon ms-auto" id="sidebarToggle" aria-label="Toggle sidebar" role="button" tabindex="0">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="metismenu" id="menu">

        {{-- STUDENT MENU --}}
        @if($user->hasRole('student'))
            @include('admin.body.partials._student')
        @endif

        {{-- HOD MENU --}}
        @if($user->hasRole('hod'))
            @include('admin.body.partials._hod')
        @endif

        {{-- Roles & Permissions (permission-based) --}}
        @if(Auth::user()->can('roles.menu'))
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Roles & Permissions</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('all.permission') }}">
                            <i class="bx bx-right-arrow-alt"></i>All Permissions
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.roles') }}">
                            <i class="bx bx-right-arrow-alt"></i>Roles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.roles.permission') }}">
                            <i class="bx bx-right-arrow-alt"></i>Roles in Permission
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- User Setups (permission-based) --}}
        @if(Auth::user()->can('users.menu'))
            <li>
                <a class="has-arrow" href="javascript:;" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-repeat"></i></div>
                    <div class="menu-title">User Setups</div>
                </a>
                <ul>
                    @if(Auth::user()->can('users.all'))
                        <li>
                            <a href="{{ route('all.admin') }}">
                                <i class="bx bx-right-arrow-alt"></i>All Admin
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->can('users.add'))
                        <li>
                            <a href="{{ route('add.admin') }}">
                                <i class="bx bx-right-arrow-alt"></i>Add Admin
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- SUPERADMIN MENU --}}
        @if(Auth::user()->hasRole('superadmin'))
            <li>
                <a href="{{ route('admin.logs.errors') }}">
                    <i class="bx bx-right-arrow-alt"></i>Errors
                </a>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Training Courses</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('all.trainings') }}">
                            <i class="bx bx-right-arrow-alt"></i>Training Schedules
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.courses') }}">
                            <i class="bx bx-right-arrow-alt"></i>Courses
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-open'></i></div>
                    <div class="menu-title">Academic Setup</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('course_cohorts.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Course Cohorts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course_stages.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Course Stages
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-map'></i></div>
                    <div class="menu-title">Geographical Data</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('backend.counties.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Counties
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.subcounties.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Sub Counties
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.postal_codes.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Postal Codes
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-cloud-upload'></i></div>
                    <div class="menu-title">Data Imports</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.admissions.import.form') }}">
                            <i class="bx bx-right-arrow-alt"></i>Admissions Data
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.biodata.import.form') }}">
                            <i class="bx bx-right-arrow-alt"></i>Student Bio Data
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.shortcourses.import.form') }}">
                            <i class="bx bx-right-arrow-alt"></i>Short Course Certificates
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('masterdata.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Master Data
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-dollar-circle'></i></div>
                    <div class="menu-title">Fee Structure</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('course_structure.home') }}">
                            <i class="bx bx-right-arrow-alt"></i>Course Structure
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course_fees.home') }}">
                            <i class="bx bx-right-arrow-alt"></i>Fee Structure
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('backend.academic-departments.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Academic Departments
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard.master') }}">
                    <i class="bx bx-right-arrow-alt"></i>Master Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.class-lists.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Master Class Lists
                </a>
            </li>
            <li>
                <a href="{{ route('timeline.global') }}">
                    <i class="bx bx-right-arrow-alt"></i>Academic Timeline
                </a>
            </li>

            <li class="menu-label">User Management</li>
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Manage Internal Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.students') }}">
                    <i class="bx bx-right-arrow-alt"></i>Manage Student Accounts
                </a>
            </li>
            <li>
                <a href="{{ route('admin.biodata.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Student Bio Data
                </a>
            </li>

            <li class="menu-label">Course Applications</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Course Applications</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('registrar.dashboard') }}">
                            <i class="bx bx-radio-circle"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registrar.applications.awaiting') }}">
                            <i class="bx bx-radio-circle"></i>Awaiting Assignment
                            @if(isset($counts) && $counts['awaiting'] > 0)
                                <span class="badge bg-warning ms-2">{{ $counts['awaiting'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registrar.applications.assigned') }}">
                            <i class="bx bx-radio-circle"></i>Assigned / Under Review
                            @if(isset($counts) && $counts['assigned'] > 0)
                                <span class="badge bg-info ms-2">{{ $counts['assigned'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registrar.applications.completed') }}">
                            <i class="bx bx-radio-circle"></i>Completed
                            @if(isset($counts) && $counts['completed'] > 0)
                                <span class="badge bg-success ms-2">{{ $counts['completed'] }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">KNEC Reports</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-file'></i></div>
                    <div class="menu-title">KNEC Reports</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('reports.applications') }}">
                            <i class="bx bx-radio-circle"></i>All KNEC Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('knec.reports.applications') }}">
                            <i class="bx bx-radio-circle"></i>KNEC Applications Filter
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.rejected') }}">
                            <i class="bx bx-radio-circle"></i>Approved / Rejected
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.summary.pdf') }}">
                            <i class="bx bx-radio-circle"></i>KNEC Application Summary
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.summary.index') }}">
                            <i class="bx bx-radio-circle"></i>KNEC Summary
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Short Courses Reports</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-file'></i></div>
                    <div class="menu-title">Short Courses Reports</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('reports.short.applications') }}">
                            <i class="bx bx-radio-circle"></i>All Short Courses Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.short.training.summary') }}">
                            <i class="bx bx-radio-circle"></i>Training Summary
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.short.participants') }}">
                            <i class="bx bx-radio-circle"></i>Participants Master List
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.short.employers') }}">
                            <i class="bx bx-radio-circle"></i>Employers Summary
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.short.revenue.index') }}">
                            <i class="bx bx-radio-circle"></i>Revenue Report
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Admission Documents</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-file'></i></div>
                    <div class="menu-title">Upload Documents</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.admission.documents.index') }}">
                            <i class="bx bx-radio-circle"></i>All Uploaded Documents
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Vetting</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Vetting</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('registrar.verification.index') }}">
                            <i class="bx bx-radio-circle"></i>Awaiting
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.admissions.verified') }}">
                            <i class="bx bx-radio-circle"></i>Verified
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- ACCOUNTS / CASH OFFICE MENU --}}
        @if(Auth::user()->hasRole('accounts') || Auth::user()->hasRole('cash_office') || Auth::user()->hasRole('superadmin'))
            <li class="menu-label">Accounts</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Accounts</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('accounts.dashboard') }}">
                            <i class="bx bx-radio-circle"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('finance.students.index') }}">
                            <i class="bx bx-radio-circle"></i>Ledger
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('finance.dashboard') }}">
                            <i class="bx bx-radio-circle"></i>Ledger Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('accounts.invoices') }}">
                            <i class="bx bx-radio-circle"></i>Invoices
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.daily.collections') }}">
                            <i class="bx bx-radio-circle"></i>Daily Collections Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.outstanding') }}">
                            <i class="bx bx-radio-circle"></i>Outstanding Payments
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- HOD MENU --}}
        @if(Auth::user()->hasRole('hod'))
            <li class="menu-label">Department</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Training & Courses</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('all.trainings') }}">
                            <i class="bx bx-right-arrow-alt"></i>Training Schedules
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.courses') }}">
                            <i class="bx bx-right-arrow-alt"></i>Courses
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">My Assigned Applications</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-task'></i></div>
                    <div class="menu-title">My Applications</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('officer.applications.pending') }}">
                            <i class="bx bx-radio-circle"></i>Pending Review
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('officer.applications.completed') }}">
                            <i class="bx bx-radio-circle"></i>Completed Reviews
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- CAMPUS REGISTRAR MENU --}}
        @if(Auth::user()->hasRole('campus_registrar'))
            <li class="menu-label">Department</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Registrar Actions</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('trainings.registrar.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Registrar Approval Queue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.courses') }}">
                            <i class="bx bx-right-arrow-alt"></i>Courses
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- HQ REGISTRAR MENU --}}
        @if(Auth::user()->hasRole('kihbt_registrar'))
            <li class="menu-label">Department</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Registrar Actions</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('trainings.hqregistrar.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>HQ Registrar Approval Queue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registrar.applications.completed') }}">
                            <i class="bx bx-radio-circle"></i>Completed Reviews
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.courses') }}">
                            <i class="bx bx-right-arrow-alt"></i>Courses
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- DIRECTOR MENU --}}
        @if(Auth::user()->hasRole('director'))
            <li class="menu-label">Director Dashboard</li>
            <li>
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Director Actions</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('trainings.drregistrar.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>Director Approval Queue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registrar.applications.completed') }}">
                            <i class="bx bx-radio-circle"></i>Completed Reviews
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all.courses') }}">
                            <i class="bx bx-right-arrow-alt"></i>Courses
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>
    <!-- End navigation -->
</div>

<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar toggle script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar-wrapper.kihbt-sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    // Detect mobile view
    const isMobile = () => window.innerWidth <= 991;

    // Toggle sidebar on mobile
    toggle?.addEventListener('click', function() {
        if (isMobile()) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }
    });

    // Close sidebar when clicking overlay
    overlay?.addEventListener('click', function() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    // Handle submenu toggle only on mobile
    const hasArrows = document.querySelectorAll('.metismenu .has-arrow');
    hasArrows.forEach(arrow => {
        arrow.addEventListener('click', function(e) {
            if (!isMobile()) return; // desktop: do nothing

            const parentLi = this.closest('li');
            if (!parentLi) return;

            parentLi.classList.toggle('mm-active');
            const submenu = parentLi.querySelector('ul');
            if (submenu) {
                e.preventDefault();
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            }
        });
    });

    // Reset sidebar and overlay on window resize
    window.addEventListener('resize', function() {
        if (!isMobile()) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>
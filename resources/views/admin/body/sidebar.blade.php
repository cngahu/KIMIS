<style>
    /* KIHBT Sidebar – primary colored background */
    .sidebar-wrapper.kihbt-sidebar {
        background: #3b2818; /* primary */
        color: #ffffff;
    }

    /* Header */
    .kihbt-sidebar .sidebar-header {
        background: #3b2818;
        border-bottom: 1px solid rgba(0,0,0,0.25);
    }

    .kihbt-sidebar .sidebar-header .logo-text {
        color: #ffffff;
    }

    .kihbt-sidebar .sidebar-header .toggle-icon i {
        color: #f9a90f; /* secondary accent */
    }

    /* Top-level menu items */
    .kihbt-sidebar .metismenu > li > a {
        color: #ffffff;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .kihbt-sidebar .metismenu li .parent-icon i {
        color: #ffffff;
    }

    /* SUBMENU CONTAINER: light background so items are visible */
    .kihbt-sidebar .metismenu > li > ul {
        background: #f7f4ee;
        border-radius: 6px;
        margin: 4px 10px 8px 10px;
        padding: 4px 6px;
    }

    /* Submenu links – dark text for contrast */
    .kihbt-sidebar .metismenu ul li a {
        color: #222222;
        font-size: 0.87rem;
        padding: 7px 12px;
        border-radius: 4px;
        font-weight: 600; /* <— makes submenu text bold */
        letter-spacing: 0.2px;
    }
    /* Submenu icons – darker but not too strong */
    .kihbt-sidebar .metismenu ul li a i {
        color: #555555;
        font-size: 0.9rem;
    }

    /* Hover & active states */
    .kihbt-sidebar .metismenu a:hover {
        color: #f9a90f;
    }

    .kihbt-sidebar .metismenu ul li a:hover {
        background: rgba(0,0,0,0.03);
        color: #3b2818;
    }

    .kihbt-sidebar .metismenu .mm-active > a {
        color: #f9a90f;
    }

    .kihbt-sidebar .metismenu .mm-active > a .parent-icon i {
        color: #f9a90f;
    }

    /* Section labels */
    .kihbt-sidebar .menu-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #c9b9a5;
        padding: 0.75rem 1.2rem 0.25rem;
    }
</style>

<div class="sidebar-wrapper kihbt-sidebar" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="logo-icon" alt="logo icon">
            </a>
        </div>
        <div>
            <h4 class="logo-text">Dashboard</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    <!--navigation-->
    <ul class="metismenu" id="menu">
        @php $user = \Illuminate\Support\Facades\Auth::user(); @endphp



        {{-- STUDENT --}}
        @if($user->hasRole('student'))
            @include('admin.body.partials._student')
        @endif
        {{-- Roles & Permissions (permission-based, not role-based) --}}
        @if(Auth::user()->can('roles.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
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
                <a class="has-arrow" href="javascript:;">
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
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Constants</div>
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


            <li class="menu-label">User Management</li>
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Manage Users
                </a>
            </li>


        <li class="menu-label">Course Applications</li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                <div class="menu-title">Course Applications</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('registrar.dashboard') }}">
                        <i class="bx bx-radio-circle"></i> Dashboard

                    </a>
                </li>
                <li>
                    <a href="{{ route('registrar.applications.awaiting') }}">
                        <i class="bx bx-radio-circle"></i> Awaiting Assignment
                        @if(isset($counts) && $counts['awaiting'] > 0)
                            <span class="badge bg-warning ms-2">{{ $counts['awaiting'] }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('registrar.applications.assigned') }}">
                        <i class="bx bx-radio-circle"></i> Assigned / Under Review
                        @if(isset($counts) && $counts['assigned'] > 0)
                            <span class="badge bg-info ms-2">{{ $counts['assigned'] }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('registrar.applications.completed') }}">
                        <i class="bx bx-radio-circle"></i> Completed
                        @if(isset($counts) && $counts['completed'] > 0)
                            <span class="badge bg-success ms-2">{{ $counts['completed'] }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-label">Reports</li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-file'></i></div>
                <div class="menu-title">Reports</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('reports.applications') }}">
                        <i class="bx bx-radio-circle"></i> All Applications
                    </a>
                </li>

                <li>
                    <a href="{{ route('reports.decisions') }}">
                        <i class="bx bx-radio-circle"></i> Approved / Rejected
                    </a>
                </li>

                <li>
                    <a href="{{ route('reports.reviewers') }}">
                        <i class="bx bx-radio-circle"></i> Reviewer Performance
                    </a>
                </li>
            </ul>
        </li>



            <li class="menu-label">Admission Documents</li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-file'></i></div>
                    <div class="menu-title">Upload Documents</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.admission.documents.index') }}">
                            <i class="bx bx-radio-circle"></i> All Uploaded Documents
                        </a>
                    </li>


                </ul>
            </li>



            <li class="menu-label">Vetting</li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
                    <div class="menu-title">Vetting</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('registrar.verification.index') }}">
                            <i class="bx bx-radio-circle"></i> Awaiting

                        </a>
                    </li>

                </ul>
            </li>

        @endif


        {{-- HOD MENU --}}
        @if(Auth::user()->hasRole('hod'))
            <li class="menu-label">Department</li>

            <li>
                <a href="javascript:;" class="has-arrow">
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
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-task'></i></div>
                    <div class="menu-title">My Applications</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('officer.applications.pending') }}">
                            <i class="bx bx-radio-circle"></i> Pending Review
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('officer.applications.completed') }}">
                            <i class="bx bx-radio-circle"></i> Completed Reviews
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- REGISTRAR MENU --}}
        @if(Auth::user()->hasRole('campus_registrar'))
            <li class="menu-label">Department</li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Registrar Actions</div>
                </a>
                <ul>

                    <li>
                        <a href="{{ route('trainings.registrar.index') }}">
                            <i class="bx bx-right-arrow-alt"></i> Registrar Approval Queue
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
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Registrar Actions</div>
                </a>
                <ul>

                    <li>
                        <a href="{{ route('trainings.hqregistrar.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>  HQ Registrar Approval Queue
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
        @if(Auth::user()->hasRole('director'))
            <li class="menu-label">Director Dashboard</li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="menu-title">Director Actions</div>
                </a>
                <ul>

                    <li>
                        <a href="{{ route('trainings.drregistrar.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>  Director Approval Queue
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



    <!--end navigation-->
</div>

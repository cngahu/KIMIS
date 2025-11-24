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

    /* Status messages */
    .kihbt-sidebar .status-message {
        padding: 1rem;
        text-align: center;
    }

    .kihbt-sidebar .btn-status {
        width: 100%;
        background: #f9a90f;
        color: #3b2818;
        border: none;
        border-radius: 6px;
        padding: 0.75rem;
        font-weight: 600;
        cursor: not-allowed;
    }

    .kihbt-sidebar .btn-status:disabled {
        opacity: 0.8;
    }
</style>

@php
    $user=\App\Models\User::find(\Illuminate\Support\Facades\Auth::User()->id);
@endphp

<div class="sidebar-wrapper kihbt-sidebar" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="{{ route('applicant.dashboard') }}">
                <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="logo-icon" alt="logo icon" style="height: 40px;">
            </a>
        </div>
        <div>
            <h4 class="logo-text">My Dashboard</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    <!--navigation-->
    @if($user->level==1)
        <ul class="metismenu" id="menu">
            <li>
                <div class="status-message">
                    <button class="btn btn-status" type="button" disabled>
                        Awaiting Profile Approval...
                    </button>
                </div>
            </li>
        </ul>
    @else
        <ul class="metismenu" id="menu">
            <!-- Main Profile Section -->
            <li>
                <a href="{{ route('applicant.dprofile') }}">
                    <div class="parent-icon"><i class="bx bx-user"></i></div>
                    <div class="menu-title">My Profile</div>
                </a>
            </li>

            <!-- Application Management -->
            @if(Auth::user()->hasRole('applicant'))
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-file"></i></div>
                        <div class="menu-title">My Applications</div>
                    </a>
                    <ul>
                        <li><a href="#"><i class="bx bx-right-arrow-alt"></i>View Applications</a></li>
{{--                        <li><a href="{{ route('applicant.apply') }}"><i class="bx bx-right-arrow-alt"></i>Apply for Training</a></li>--}}
{{--                        <li><a href="{{ route('applicant.application.status') }}"><i class="bx bx-right-arrow-alt"></i>Application Status</a></li>--}}
                    </ul>
                </li>
            @endif

{{--            <!-- Training & Courses -->--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:;">--}}
{{--                    <div class="parent-icon"><i class="bx bx-book-reader"></i></div>--}}
{{--                    <div class="menu-title">Training Programs</div>--}}
{{--                </a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('applicant.trainings') }}"><i class="bx bx-right-arrow-alt"></i>Available Trainings</a></li>--}}
{{--                    <li><a href="{{ route('applicant.courses') }}"><i class="bx bx-right-arrow-alt"></i>Course Catalog</a></li>--}}
{{--                    <li><a href="{{ route('applicant.enrolled') }}"><i class="bx bx-right-arrow-alt"></i>My Enrollments</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            <!-- Documents & Uploads -->--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:;">--}}
{{--                    <div class="parent-icon"><i class="bx bx-folder"></i></div>--}}
{{--                    <div class="menu-title">Documents</div>--}}
{{--                </a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('applicant.documents') }}"><i class="bx bx-right-arrow-alt"></i>My Documents</a></li>--}}
{{--                    <li><a href="{{ route('applicant.uploads') }}"><i class="bx bx-right-arrow-alt"></i>Upload Documents</a></li>--}}
{{--                    <li><a href="{{ route('applicant.certificates') }}"><i class="bx bx-right-arrow-alt"></i>Certificates</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            <!-- Payments & Fees -->--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:;">--}}
{{--                    <div class="parent-icon"><i class="bx bx-credit-card"></i></div>--}}
{{--                    <div class="menu-title">Payments</div>--}}
{{--                </a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('applicant.invoices') }}"><i class="bx bx-right-arrow-alt"></i>Invoices</a></li>--}}
{{--                    <li><a href="{{ route('applicant.payment.history') }}"><i class="bx bx-right-arrow-alt"></i>Payment History</a></li>--}}
{{--                    <li><a href="{{ route('applicant.payment.methods') }}"><i class="bx bx-right-arrow-alt"></i>Payment Methods</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            <!-- Support & Help -->--}}
{{--            <li class="menu-label">Support</li>--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:;">--}}
{{--                    <div class="parent-icon"><i class="bx bx-support"></i></div>--}}
{{--                    <div class="menu-title">Help Center</div>--}}
{{--                </a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('applicant.faq') }}"><i class="bx bx-right-arrow-alt"></i>FAQ</a></li>--}}
{{--                    <li><a href="{{ route('applicant.contact') }}"><i class="bx bx-right-arrow-alt"></i>Contact Support</a></li>--}}
{{--                    <li><a href="{{ route('applicant.guides') }}"><i class="bx bx-right-arrow-alt"></i>User Guides</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            <!-- Settings -->--}}
{{--            <li>--}}
{{--                <a href="{{ route('applicant.settings') }}">--}}
{{--                    <div class="parent-icon"><i class="bx bx-cog"></i></div>--}}
{{--                    <div class="menu-title">Settings</div>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    @endif
    <!--end navigation-->
</div>

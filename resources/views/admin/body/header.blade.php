<style>
    :root {
        --primary: #3b2818;   /* header & sidebar main color */
        --secondary: #f9a90f; /* accent */
    }

    /* ===== HEADER WRAPPER ===== */
    .kihbt-header .topbar {
        background: var(--primary);
        padding: 8px 18px;
        border-bottom: 1px solid rgba(0,0,0,0.35);
    }

    .kihbt-header .navbar {
        padding: 0;
    }

    /* Left: toggle + title */
    .kihbt-header .mobile-toggle-menu i {
        font-size: 1.5rem;
        color: #ffffff;
        cursor: pointer;
    }

    .kihbt-header .page-title {
        margin-left: .75rem;
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: .3px;
        text-transform: uppercase;
    }

    /* Right: icon group */
    .kihbt-header .top-menu .nav-link {
        color: #ffffff !important;
        font-weight: 600;
        padding-inline: .6rem;
        position: relative;
    }

    .kihbt-header .top-menu .nav-link i {
        font-size: 1.3rem;
    }

    .kihbt-header .alert-count {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(35%, -35%);
        background: var(--secondary);
        color: #000;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 999px;
    }

    /* User box */
    .kihbt-header .user-box .user-img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--secondary);
    }

    .kihbt-header .user-box .user-info {
        padding-left: .5rem;
        color: #ffffff;
        line-height: 1.1;
    }

    .kihbt-header .user-box .user-name {
        font-size: .9rem;
        font-weight: 700;
        margin-bottom: 2px;
        color: #ffffff;
    }

    .kihbt-header .user-box .designattion {
        font-size: .8rem;
        font-weight: 500;
        opacity: .85;
        color: #ffffff;
    }

    /* Dropdowns */
    .kihbt-header .dropdown-menu {
        font-size: .85rem;
        min-width: 200px;
    }

    .kihbt-header .dropdown-item {
        font-weight: 600;
    }

    .kihbt-header .dropdown-item i {
        margin-right: 8px;
        font-size: 1rem;
        color: var(--primary);
    }

    .kihbt-header .msg-header-title {
        font-weight: 700;
    }
</style>

<header class="kihbt-header">
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand w-100">

            <!-- Left: toggle + page title -->
            <div class="d-flex align-items-center">
                <div class="mobile-toggle-menu me-2">
                    <i class='bx bx-menu'></i>
                </div>
                <div class="page-title">
                    Dashboard
                </div>
            </div>

            <!-- Right: icons + user -->
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">

                    <!-- Apps (optional) -->
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-category'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="row row-cols-3 g-3 p-3">
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-cosmic text-white">
                                        <i class='bx bx-group'></i>
                                    </div>
                                    <div class="app-title">Teams</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-burning text-white">
                                        <i class='bx bx-atom'></i>
                                    </div>
                                    <div class="app-title">Projects</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-lush text-white">
                                        <i class='bx bx-shield'></i>
                                    </div>
                                    <div class="app-title">Tasks</div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Notifications -->
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count">7</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header d-flex align-items-center">
                                    <p class="msg-header-title mb-0">Notifications</p>
                                    <p class="msg-header-clear ms-auto mb-0">Mark all as read</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                <!-- keep your notification items or trim as needed -->
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify bg-light-primary text-primary">
                                            <i class="bx bx-group"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New Customers
                                                <span class="msg-time float-end">14 sec ago</span>
                                            </h6>
                                            <p class="msg-info mb-0">5 new users registered</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">View All Notifications</div>
                            </a>
                        </div>
                    </li>

                    <!-- Messages -->
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count">8</span>
                            <i class='bx bx-comment'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header d-flex align-items-center">
                                    <p class="msg-header-title mb-0">Messages</p>
                                    <p class="msg-header-clear ms-auto mb-0">Mark all as read</p>
                                </div>
                            </a>
                            <div class="header-message-list">
                                <!-- keep or trim message items as desired -->
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="user-online">
                                            <img src="assets/images/avatars/avatar-1.png" class="msg-avatar" alt="user avatar">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">
                                                Daisy Anderson
                                                <span class="msg-time float-end">5 sec ago</span>
                                            </h6>
                                            <p class="msg-info mb-0">The standard chunk of lorem</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">View All Messages</div>
                            </a>
                        </div>
                    </li>

                    <!-- User dropdown -->
                    <li class="nav-item dropdown user-box ms-2">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo) : url('upload/no_image.jpg') }}"
                                 class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                                <p class="designattion mb-0">{{ Auth::user()->username }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="bx bx-user"></i><span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.change.password') }}">
                                    <i class="bx bx-cog"></i><span>Change Password</span>
                                </a>
                            </li>
                            <li><div class="dropdown-divider mb-0"></div></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class='bx bx-log-out-circle'></i><span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

        </nav>
    </div>
</header>

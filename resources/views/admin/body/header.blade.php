<style>
    /* ================= CSS VARIABLES - KIHBT BRAND ================= */
    :root {
        /* Brand Colors */
        --primary: #3b2818;           /* KIHBT Brown */
        --primary-light: #5a3d2b;     /* Lighter Brown */
        --primary-dark: #2a1a0f;      /* Darker Brown */
        --accent: #f9a90f;            /* KIHBT Gold */
        --accent-hover: #d18b00;      /* Darker Gold */
        
        /* Semantic Colors */
        --text-light: #ffffff;
        --text-muted: rgba(255,255,255,0.85);
        
        /* ⭐ CRITICAL: Header height for layout spacing */
        --header-height: 56px;        /* Match your actual header height */
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.15);
        
        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition-normal: 0.25s ease;
        
        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
    }

    /* ================= PAGE CONTENT - ADD TOP PADDING TO AVOID HEADER OVERLAP ================= */
    /* ✅ This is the CORRECT fix - not margin-top on header */
    .page-content {
        padding: calc(var(--header-height) + var(--spacing-lg)) var(--spacing-lg) var(--spacing-lg);
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ===== HEADER WRAPPER ===== */
    .kihbt-header {
        position: sticky;
        top: 0;
        z-index: 1030;
        background: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .kihbt-header .topbar {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 0 var(--spacing-md);
        min-height: var(--header-height);
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
    }

    .kihbt-header .navbar {
        padding: 0;
        width: 100%;
    }

    /* ===== LEFT SECTION: Toggle + Title ===== */
    .kihbt-header .mobile-toggle-menu {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        transition: all var(--transition-fast);
        cursor: pointer;
    }

    .kihbt-header .mobile-toggle-menu:hover {
        background: rgba(255,255,255,0.1);
        transform: scale(1.05);
    }

    .kihbt-header .mobile-toggle-menu i {
        font-size: 1.5rem;
        color: var(--text-light);
        transition: color var(--transition-fast);
    }

    .kihbt-header .mobile-toggle-menu:hover i {
        color: var(--accent);
    }

    .kihbt-header .page-title {
        margin-left: var(--spacing-sm);
        color: var(--text-light);
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .kihbt-header .page-title::before {
        content: '';
        width: 4px;
        height: 18px;
        background: var(--accent);
        border-radius: 2px;
        display: inline-block;
    }

    /* ===== RIGHT SECTION: Icons + User ===== */
    .kihbt-header .top-menu .nav-link {
        color: var(--text-light) !important;
        font-weight: 600;
        padding: 0.5rem 0.6rem !important;
        position: relative;
        border-radius: 8px;
        transition: all var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        min-height: 40px;
    }

    .kihbt-header .top-menu .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: var(--accent) !important;
        transform: translateY(-2px);
    }

    .kihbt-header .top-menu .nav-link i {
        font-size: 1.3rem;
        transition: transform var(--transition-fast);
    }

    .kihbt-header .top-menu .nav-link:hover i {
        transform: scale(1.1);
    }

    /* Badge/Alert Count */
    .kihbt-header .alert-count {
        position: absolute;
        top: 2px;
        right: 2px;
        background: var(--accent);
        color: #000;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 999px;
        min-width: 18px;
        text-align: center;
        line-height: 1;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* ===== USER BOX ===== */
    .kihbt-header .user-box {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        transition: all var(--transition-fast);
        cursor: pointer;
    }

    .kihbt-header .user-box:hover {
        background:none;
    }

    .kihbt-header .user-box .user-img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--accent);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        transition: all var(--transition-fast);
    }

    .kihbt-header .user-box:hover .user-img {
        border-color: var(--text-light);
        transform: scale(1.05);
    }

    .kihbt-header .user-box .user-info {
        padding-left: var(--spacing-sm);
        color: var(--text-light);
        line-height: 1.1;
        text-align: left;
    }

    .kihbt-header .user-box .user-name {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 2px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .kihbt-header .user-box .user-name::after {
        content: '▼';
        font-size: 0.6rem;
        opacity: 0.7;
        transition: transform var(--transition-fast);
    }

    .kihbt-header .user-box:hover .user-name::after {
        transform: rotate(180deg);
    }

    .kihbt-header .user-box .designattion {
        font-size: 0.8rem;
        font-weight: 500;
        opacity: 0.85;
        color: var(--text-muted);
    }

    /* ===== DROPDOWNS ===== */
    .kihbt-header .dropdown-menu {
        font-size: 0.85rem;
        min-width: 200px;
        border: none;
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        padding: 0.5rem 0;
        margin-top: 8px;
        background: #fff;
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

    .kihbt-header .dropdown-item {
        font-weight: 600;
        padding: 0.6rem 1rem;
        color: var(--primary);
        transition: all var(--transition-fast);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .kihbt-header .dropdown-item:hover {
        background: rgba(249, 169, 15, 0.1);
        color: var(--primary-dark);
        padding-left: 1.25rem;
    }

    .kihbt-header .dropdown-item i {
        margin-right: 8px;
        font-size: 1rem;
        color: var(--accent);
        width: 20px;
        text-align: center;
    }

    .kihbt-header .dropdown-divider {
        margin: 0.25rem 0;
        border-color: rgba(0,0,0,0.1);
    }

    .kihbt-header .msg-header-title {
        font-weight: 700;
        color: var(--primary);
    }

    /* ===== APPS DROPDOWN (Optional) ===== */
    .kihbt-header .app-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 0.5rem;
        transition: transform var(--transition-fast);
    }

    .kihbt-header .app-box:hover {
        transform: translateY(-3px);
    }

    .kihbt-header .app-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary);
        text-align: center;
    }

    .kihbt-header .bg-gradient-cosmic { background: linear-gradient(135deg, #667eea, #764ba2); }
    .kihbt-header .bg-gradient-burning { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .kihbt-header .bg-gradient-lush { background: linear-gradient(135deg, #4facfe, #00f2fe); }

    /* ===== MOBILE RESPONSIVE ===== */
    @media (max-width: 991px) {
        .page-content {
            padding: calc(var(--header-height) + var(--spacing-md)) var(--spacing-md) var(--spacing-md);
        }

        .kihbt-header .topbar {
            padding: 0 var(--spacing-sm);
        }

        .kihbt-header .page-title {
            font-size: 1rem;
            margin-left: var(--spacing-xs);
        }

        .kihbt-header .user-box .user-info {
            display: none;
        }

        .kihbt-header .user-box {
            padding: 0.25rem;
        }

        .kihbt-header .dropdown-menu {
            min-width: 180px;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 575px) {
        .kihbt-header .top-menu .nav-link {
            padding: 0.5rem !important;
            min-width: 36px;
            min-height: 36px;
        }

        .kihbt-header .top-menu .nav-link i {
            font-size: 1.2rem;
        }

        .kihbt-header .alert-count {
            font-size: 0.65rem;
            padding: 1px 5px;
        }
    }

    /* ===== ACCESSIBILITY ===== */
    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
            animation: none !important;
        }
    }

    .kihbt-header .nav-link:focus,
    .kihbt-header .dropdown-item:focus,
    .kihbt-header .user-box:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }
</style>

<header class="kihbt-header">
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand w-100">

            <!-- Left: toggle + page title -->
            <div class="d-flex align-items-center">
                <div class="mobile-toggle-menu me-2" id="mobileToggle" aria-label="Toggle sidebar">
                    <i class='bx bx-menu'></i>
                </div>
                <div class="page-title">
                    {{ $pageTitle ?? 'Dashboard' }}
                </div>
            </div>

            <!-- Right: icons + user -->
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">

                    <!-- Apps (optional) -->
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Quick apps">
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

                    <!-- User dropdown -->
                    <li class="nav-item dropdown user-box ms-2">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                            <img src="{{ (!empty(Auth::user()->photo)) ? url('upload/admin_images/'.Auth::user()->photo) : url('upload/no_image.jpg') }}"
                                 class="user-img" alt="{{ Auth::user()->firstname ?? 'User' }} avatar">
                            <div class="user-info ps-3 d-none d-md-block">
                                <p class="user-name mb-0">{{ Auth::user()->firstname ?? Auth::user()->name }}</p>
                                <p class="designattion mb-0">{{ Auth::user()->username ?? Auth::user()->email }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('student.profile.show') }}">
                                    <i class="bx bx-user"></i><span>Profile</span>
                                </a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="{{
                                    auth()->user()->hasRole('student')
                                        ? route('student.change.password')
                                        : route('admin.change.password')
                                }}">
                                    <i class="bx bx-cog"></i><span>Change Password</span>
                                </a>
                            </li>
                            <li><div class="dropdown-divider mb-0"></div></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

<!-- Hidden logout form for security -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Mobile toggle script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('mobileToggle');
    const sidebar = document.querySelector('.sidebar-wrapper');
    
    if (toggle && sidebar) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            document.body.classList.toggle('sidebar-active');
        });
    }
    
    // Close dropdowns when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992) {
            const dropdowns = document.querySelectorAll('.dropdown-menu.show');
            dropdowns.forEach(dropdown => {
                if (!dropdown.closest('.dropdown').contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        }
    });
});
</script>
<style>
    :root {
        --primary: #3b2818;
        --primary-light: #5a3d2b;
        --primary-dark: #2a1a0f;
        --accent: #f9a90f;
        --text-light: #ffffff;
        --text-muted: rgba(255,255,255,0.85);
        --header-height: 56px;
        --shadow-md: 0 4px 16px rgba(0,0,0,0.15);
        --transition-fast: 0.15s ease;
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
    }

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

    .kihbt-header .navbar { padding: 0; width: 100%; }

    /* Hamburger — visible on mobile, also visible on desktop as secondary toggle */
    .kihbt-header .mobile-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        cursor: pointer;
        transition: background var(--transition-fast);
        flex-shrink: 0;
    }

    .kihbt-header .mobile-toggle-btn i {
        font-size: 1.5rem;
        color: var(--text-light);
        transition: color var(--transition-fast);
    }

    .kihbt-header .mobile-toggle-btn:hover { background: rgba(255,255,255,0.1); }
    .kihbt-header .mobile-toggle-btn:hover i { color: var(--accent); }

    /* Page title */
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

    /* Right nav */
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

    .kihbt-header .top-menu .nav-link:hover i { transform: scale(1.1); }

    /* User box */
    .kihbt-header .user-box {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: 0.25rem 0.5rem;
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .kihbt-header .user-box:hover { background: none; }

    .kihbt-header .user-box .user-img {
        width: 36px; height: 36px;
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
    }

    .kihbt-header .user-box .user-name {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-bottom: 2px;
    }

    .kihbt-header .user-box .user-name::after {
        content: '▼';
        font-size: 0.6rem;
        opacity: 0.7;
        transition: transform var(--transition-fast);
    }

    .kihbt-header .user-box:hover .user-name::after { transform: rotate(180deg); }

    .kihbt-header .user-box .designattion {
        font-size: 0.7rem;
        font-weight: 500;
        opacity: 0.85;
        color: var(--text-muted);
    }

    /* Dropdowns */
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
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
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
        background: rgba(249,169,15,0.1);
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

    .kihbt-header .dropdown-divider { margin: 0.25rem 0; border-color: rgba(0,0,0,0.1); }

    /* Apps grid */
    .kihbt-header .app-box {
        width: 50px; height: 50px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 0.5rem;
        transition: transform var(--transition-fast);
    }
    .kihbt-header .app-box:hover { transform: translateY(-3px); }
    .kihbt-header .app-title { font-size: 0.8rem; font-weight: 600; color: var(--primary); text-align: center; }
    .kihbt-header .bg-gradient-cosmic  { background: linear-gradient(135deg, #667eea, #764ba2); }
    .kihbt-header .bg-gradient-burning { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .kihbt-header .bg-gradient-lush    { background: linear-gradient(135deg, #4facfe, #00f2fe); }

    /* Mobile tweaks */
    @media (max-width: 991px) {
        .kihbt-header .topbar { padding: 0 var(--spacing-sm); }
        .kihbt-header .page-title { font-size: 1rem; }
        .kihbt-header .user-box .user-info { display: none; }
        .kihbt-header .user-box { padding: 0.25rem; }
        .kihbt-header .dropdown-menu { min-width: 180px; }
    }

    @media (max-width: 575px) {
        .kihbt-header .top-menu .nav-link { padding: 0.5rem !important; min-width: 36px; min-height: 36px; }
        .kihbt-header .top-menu .nav-link i { font-size: 1.2rem; }
    }

    @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }

    .kihbt-header .nav-link:focus,
    .kihbt-header .dropdown-item:focus,
    .kihbt-header .user-box:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }
</style>

<header class="kihbt-header" id="mainHeader">
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand w-100">

            <div class="d-flex align-items-center">
                {{-- Hamburger: on mobile opens/closes sidebar; on desktop collapses/expands --}}
                <div class="mobile-toggle-btn me-2" id="mobileHamburger" aria-label="Toggle sidebar">
                    <i class='bx bx-menu'></i>
                </div>
                <div class="page-title">{{ $pageTitle ?? 'Dashboard' }}</div>
            </div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">

                    <!-- Apps -->
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                           href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false" aria-label="Quick apps">
                            <i class='bx bx-category'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="row row-cols-3 g-3 p-3">
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i></div>
                                    <div class="app-title">Teams</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i></div>
                                    <div class="app-title">Projects</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i></div>
                                    <div class="app-title">Tasks</div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- User -->
                    <li class="nav-item dropdown user-box ms-2">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret"
                           href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false" aria-label="User menu">

                            @php
                                $photo     = Auth::user()->photo;
                                $isStudent = Auth::user()->hasRole('student');
                                $imgSrc    = $photo
                                    ? ($isStudent
                                        ? asset('upload/student_images/' . $photo)
                                        : asset('upload/admin_images/'   . $photo))
                                    : asset('adminbackend/assets/images/no-image.jpg');
                            @endphp
                            <img src="{{ $imgSrc }}" class="user-img"
                                 alt="{{ Auth::user()->firstname ?? 'User' }} avatar">

                            <div class="user-info ps-3 d-none d-md-block">
                                <p class="user-name mb-0">
                                    {{ trim((Auth::user()->firstname ?? '') . ' ' . (Auth::user()->surname ?? '')) ?: Auth::user()->name }}
                                </p>
                                <p class="designattion mb-0">{{ Auth::user()->username ?? Auth::user()->email }}</p>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @if($isStudent)
                                    <a class="dropdown-item" href="{{ route('student.profile.show') }}">
                                        <i class="bx bx-user"></i><span>Profile</span>
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                        <i class="bx bx-user"></i><span>Profile</span>
                                    </a>
                                @endif
                            </li>
                            <li>
                                @if($isStudent)
                                    <a class="dropdown-item" href="{{ route('student.change.password') }}">
                                        <i class="bx bx-cog"></i><span>Change Password</span>
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('admin.change.password') }}">
                                        <i class="bx bx-cog"></i><span>Change Password</span>
                                    </a>
                                @endif
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

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar   = document.getElementById('sidebarWrapper');
    const overlay   = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('mobileHamburger');
    const STORAGE_KEY = 'kihbt_sidebar_collapsed';

    const isMobile = () => window.innerWidth <= 991;

    hamburger?.addEventListener('click', function () {
        if (isMobile()) {
            // Mobile: toggle sidebar visibility (active = visible)
            const isOpen = sidebar.classList.contains('active');
            if (isOpen) {
                // Close it
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                // Open it — also make sure it's NOT collapsed so text shows
                sidebar.classList.add('active');
                sidebar.classList.remove('collapsed');
                localStorage.setItem(STORAGE_KEY, '0');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        } else {
            // Desktop: toggle collapse (icon-only vs full)
            sidebar.classList.toggle('collapsed');
            localStorage.setItem(STORAGE_KEY, sidebar.classList.contains('collapsed') ? '1' : '0');
        }
    });

    // Close dropdowns on outside click (mobile)
    document.addEventListener('click', function (e) {
        if (isMobile()) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function (menu) {
                if (!menu.closest('.dropdown').contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
        }
    });
});
</script>

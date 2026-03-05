<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>KIHBT – Registration & Student Portal</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <style>
:root{
    --primary:#3b2818;
    --secondary:#f9a90f;
    --success:#099139;
    --tertiary:#858585;
    --bg:#f5f6f5;
    --text-dark:#26211d;
    --card:#ffffff;
    --line:#e8e8e8;
}

/* ========================= GLOBAL ========================= */
body{
    font-family:'Poppins',sans-serif;
    background:
        radial-gradient(900px 450px at 15% -10%, rgba(59,40,24,.08), transparent 60%),
        radial-gradient(900px 450px at 90% 120%, rgba(249,169,15,.12), transparent 60%),
        var(--bg);
    color:var(--text-dark);
    margin:0;
    line-height:1.6;
}

a{text-decoration:none;color:inherit;transition:color .2s ease;}

.boxed-container{
    max-width:1300px;
    margin:2rem auto;
    background:rgba(255,255,255,.95);
    border:1px solid rgba(0,0,0,.04);
    box-shadow:0 20px 60px rgba(0,0,0,.08);
    border-radius:20px;
    overflow:hidden;
    backdrop-filter:blur(10px);
}

/* ========================= NAVBAR ========================= */
.site-header{
    background:#fff;
    position:sticky;
    top:0;
    z-index:1020;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}

.navbar{padding:1rem 0;}

.nav-link,.navbar-brand{
    color:var(--primary)!important;
    font-weight:600;
}

.nav-link{
    padding:.5rem .9rem !important;
    border-radius:8px;
    transition:.2s ease;
}

.nav-link:hover{
    color:var(--secondary)!important;
    background:rgba(59,40,24,.06);
}

.logo-img{height:42px;}
.brand-title{
    font-weight:800;
    font-size:.9rem;
    margin-left:.6rem;
}

/* ========================= BUTTONS ========================= */
.btn-primary-kihbt,
.btn-secondary-kihbt{
    border:none;
    border-radius:999px;
    padding:.6rem 1.3rem;
    font-weight:700;
    height:44px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:.4rem;
    transition:.2s ease;
    cursor:pointer;
}

.btn-primary-kihbt{
    background:var(--primary);
    color:#fff;
}

.btn-primary-kihbt:hover{
    background:#000;
    transform:translateY(-1px);
    color:#fff;
}

.btn-secondary-kihbt{
    background:var(--secondary);
    color:#000;
}

.btn-secondary-kihbt:hover{
    background:#d18b00;
    transform:translateY(-1px);
    color:#000;
}

/* ========================= HERO ========================= */
.hero{
    padding:4rem 2rem 3.5rem;
    background:
        radial-gradient(900px 450px at 10% 20%, rgba(249,169,15,.18), transparent 60%),
        linear-gradient(135deg, rgba(59,40,24,.96), rgba(0,0,0,.92));
    color:#fff;
}

.hero-inner{
    max-width:1100px;
    margin:auto;
}

.hero h1{
    font-size:2.3rem;
    font-weight:800;
    margin-bottom:1rem;
    line-height:1.3;
}

.hero p{
    font-size:1.05rem;
    max-width:650px;
    line-height:1.6;
    margin-bottom:1.6rem;
    color:rgba(255,255,255,.85);
}

.hero-actions{
    margin-bottom:1.2rem;
    display:flex;
    flex-wrap:wrap;
    gap:.8rem;
}

.hero-chip-row{
    display:flex;
    flex-wrap:wrap;
    gap:.6rem;
}

.hero-chip{
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.15);
    padding:.55rem .85rem;
    border-radius:999px;
    font-size:.85rem;
    display:inline-flex;
    align-items:center;
    gap:.4rem;
}

.hero-chip i{color:var(--secondary);}

/* ========================= SECTION ========================= */
.section-wrap{
    padding:3rem 2rem 3.5rem;
}

.section-head{
    max-width:1100px;
    margin:0 auto 2rem;
}

.section-title{
    font-size:1.6rem;
    font-weight:800;
    color:var(--primary);
    margin:0;
}

.section-subtitle{
    margin-top:.4rem;
    color:var(--tertiary);
}

/* ========================= SERVICE CARDS ========================= */
.services-grid{
    max-width:1100px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:1.6rem;
}

.service-card{
    background:var(--card);
    border:1px solid var(--line);
    border-radius:18px;
    padding:1.8rem 1.6rem;
    box-shadow:0 12px 32px rgba(0,0,0,.06);
    transition:.2s ease;
    position:relative;
    display:flex;
    flex-direction:column;
}

.service-card:hover{
    transform:translateY(-4px);
    box-shadow:0 18px 45px rgba(0,0,0,.1);
    border-color:rgba(249,169,15,.4);
}

.service-badge{
    position:absolute;
    top:14px;
    right:14px;
    background:rgba(249,169,15,.14);
    border:1px solid rgba(249,169,15,.25);
    padding:.25rem .6rem;
    border-radius:999px;
    font-size:.75rem;
    font-weight:800;
    color:var(--primary);
}

.service-icon{
    width:60px;
    height:60px;
    border-radius:16px;
    background:rgba(249,169,15,.15);
    color:var(--secondary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.8rem;
    margin-bottom:1rem;
    flex-shrink:0;
}

.service-title{
    font-size:1.2rem;
    font-weight:800;
    margin-bottom:.6rem;
    color:var(--primary);
}

.service-desc{
    font-size:.95rem;
    color:var(--tertiary);
    line-height:1.6;
    margin-bottom:1.4rem;
    flex-grow:1;
}

/* ✅ FIXED: Service Actions with Better Spacing */
.service-actions{
    display:flex;
    flex-direction:column;
    align-items:flex-start;
    gap:0.8rem;
    margin-top:auto;
}

.service-actions .btn{
    width:100%;
    justify-content:center;
}

/* ✅ FIXED: Learn More Link Styling */
.service-link{
    font-weight:700;
    font-size:0.9rem;
    display:inline-flex;
    align-items:center;
    gap:0.4rem;
    color:var(--primary);
    /* ✅ Better spacing above */
    margin-top:1rem;
    padding-top:0.8rem;
    border-top:1px dashed var(--line);
    transition:all 0.2s ease;
    align-self:flex-start;
}

.service-link:hover{
    color:var(--secondary);
    gap:0.6rem;
}

.service-link i{
    transition:transform 0.2s ease;
    font-size:1rem;
}

.service-link:hover i{
    transform:translateX(3px);
}

/* ========================= MINI LIST ========================= */
.mini-list{
    list-style:none;
    padding:0;
    margin:.9rem 0 1.4rem;
    font-size:.9rem;
    color:var(--tertiary);
}

.mini-list li{
    display:flex;
    align-items:flex-start;
    gap:.5rem;
    margin-bottom:.5rem;
}

.mini-list i{
    color:var(--success);
    margin-top:2px;
    font-size:1rem;
}

/* ========================= FOOTER ========================= */
.footer-bottom{
    background:var(--primary);
    color:#fff;
    text-align:center;
    padding:1.2rem;
    font-size:.95rem;
}

/* ========================= MOBILE ========================= */
@media(max-width:768px){
    .hero{padding:3rem 1.3rem 2.8rem;}
    .hero h1{font-size:1.75rem;}
    .section-wrap{padding:2.4rem 1.4rem 3rem;}
    .services-grid{gap:1.2rem;}
    .service-card{padding:1.4rem 1.2rem;}
    .service-actions{gap:0.6rem;}
    .service-link{
        margin-top:0.8rem;
        padding-top:0.6rem;
        font-size:0.85rem;
    }
}

/* ✅ Bonus: Smooth scroll for anchor links */
html{scroll-behavior:smooth;}

/* ✅ Bonus: Focus states for accessibility */
.btn-primary-kihbt:focus,
.btn-secondary-kihbt:focus,
.service-link:focus{
    outline:2px solid var(--secondary);
    outline-offset:2px;
}
</style>
</head>
<body>

<div class="boxed-container">

    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="logo-img" alt="KIHBT">
                    <span class="brand-title">Kenya Institute of Highways and Building Technology (KIHBT)</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#kaaNav">
                    <span class="la la-bars" style="font-size:1.6rem;color:var(--primary);"></span>
                </button>

                <div class="collapse navbar-collapse" id="kaaNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>

                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log in</a></li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-inner">
            <div>
                <h1>Registration & Student Portal</h1>
                <p>
                    Apply for KIHBT short courses and long term programmes, verify certificates,
                    and access student services from one place.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('public.trainings.short') }}" class="btn-secondary-kihbt d-inline-flex align-items-center gap-2">
                        <i class="la la-calendar-check"></i> Short Courses
                    </a>

                    <a href="{{ route('certificates.verify') }}" class="btn-primary-kihbt d-inline-flex align-items-center gap-2" style="background:#099139;">
                        <i class="la la-certificate"></i> Verify Certificate
                    </a>
                </div>

                <div class="hero-chip-row">
                    <span class="hero-chip"><i class="la la-shield-alt"></i> Secure applications</span>
                    <span class="hero-chip"><i class="la la-building"></i> All campuses</span>
                    <span class="hero-chip"><i class="la la-bolt"></i> Fast verification</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="section-wrap">
        <div class="section-head">
            <div>
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Choose what you want to do today.</p>
            </div>
        </div>

        <div class="services-grid">

            <!-- Short Course -->
            <div class="service-card">
                <div class="service-badge">SHORT TERM</div>
                <div class="service-icon"><i class="la la-calendar-check"></i></div>

                <h3 class="service-title">Short Course Application</h3>

                <p class="service-desc">
                    Browse available short trainings across all KIHBT campuses and apply online.
                    Already applied? You can make a partial payment using your application reference.
                </p>

                <div class="service-actions">

                    {{-- Primary action --}}
                    <a href="{{ route('public.trainings.short') }}"
                       class="btn-primary-kihbt d-inline-flex align-items-center gap-2">
                        <i class="la la-arrow-right"></i> View Trainings
                    </a>

                    {{-- Secondary action --}}
                    <a href="{{ route('payments.lookup.form') }}"
                       class="btn btn-outline-success d-inline-flex align-items-center gap-2"
                       style="font-size: 0.9rem; padding: 0.4rem 1rem;">
                        <i class="la la-credit-card"></i> Partial Payment
                    </a>

                    {{-- ✅ Learn more - now with proper spacing --}}
                    <a class="service-link" href="{{ route('public.trainings.short') }}">
                        Learn more <i class="la la-angle-right"></i>
                    </a>

                </div>
            </div>

            <!-- Certificate Verification -->
            <div class="service-card">
                <div class="service-badge" style="background:rgba(9,145,57,.12);border-color:rgba(9,145,57,.25);color:#0b5e2c;">VERIFY</div>
                <div class="service-icon" style="background:rgba(9,145,57,.10);color:#099139;">
                    <i class="la la-certificate"></i>
                </div>

                <h3 class="service-title">Certificate Verification</h3>
                <p class="service-desc">
                    Enter a certificate number to confirm authenticity instantly. No login required.
                </p>

                <ul class="mini-list">
                    <li><i class="la la-check-circle"></i> Validate authenticity</li>
                    <li><i class="la la-check-circle"></i> Retrieve trainee details</li>
                    <li><i class="la la-check-circle"></i> Fast and secure</li>
                </ul>

                <div class="service-actions">
                    <a href="{{ route('certificates.verify') }}"
                       class="btn-primary-kihbt d-inline-flex align-items-center gap-2"
                       style="background:#099139;">
                        <i class="la la-search"></i> Verify Certificate
                    </a>

                    <a class="service-link" href="{{ route('certificates.verify') }}">
                        Learn more <i class="la la-angle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Student Activation -->
            <div class="service-card">
                <div class="service-badge">ACTIVATION</div>

                <div class="service-icon">
                    <i class="la la-user-check"></i>
                </div>

                <h3 class="service-title">Student Activation</h3>

                <p class="service-desc">
                    Activate your student portal account using your admission number.
                    Secure access to services and reset password on first login.
                </p>

                <ul class="mini-list">
                    <li><i class="la la-check-circle"></i> Admission number validation</li>
                    <li><i class="la la-check-circle"></i> Phone & email confirmation</li>
                    <li><i class="la la-check-circle"></i> OTP-secured first login</li>
                </ul>

                <div class="service-actions">
                    <a href="{{ route('student.activation.start') }}"
                       class="btn-primary-kihbt d-inline-flex align-items-center gap-2">
                        <i class="la la-unlock"></i> Activate Account
                    </a>

                    <a class="service-link" href="{{ route('student.activation.start') }}">
                        Learn more <i class="la la-angle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-bottom">
        © {{ date('Y') }} Kenya Institute of Highways and Building Technology (KIHBT). All rights reserved.
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
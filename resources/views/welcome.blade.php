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
            --tertiary:#858585;
            --bg:#f5f6f5;
            --text-dark:#26211d;
            --card:#ffffff;
            --line:#e8e8e8;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:
                radial-gradient(900px 450px at 15% -10%, rgba(59,40,24,.08), transparent 60%),
                radial-gradient(900px 450px at 90% 120%, rgba(249,169,15,.12), transparent 60%),
                var(--bg);
            color:var(--text-dark);
            margin:0;
        }

        a{text-decoration:none;color:inherit;}

        .boxed-container{
            max-width:1300px;
            margin:1.25rem auto;
            background:rgba(255,255,255,.9);
            border:1px solid rgba(0,0,0,.04);
            box-shadow:0 18px 55px rgba(0,0,0,.08);
            border-radius:16px;
            overflow:hidden;
            backdrop-filter: blur(10px);
        }

        /* Header */
        .site-header{
            background:#fff;
            position:sticky;top:0;z-index:1020;
            box-shadow:0 6px 22px rgba(0,0,0,.06);
        }
        .navbar{padding:.7rem 0;}
        .nav-link,.navbar-brand{color:var(--primary)!important;font-weight:600;}
        .nav-link:hover{color:var(--secondary)!important;}
        .brand-title{
            font-weight:800;
            letter-spacing:.2px;
            margin-left:.6rem;
            font-size:.95rem;
            line-height:1.2;
        }
        .logo-img{height:42px;width:auto;}

        /* Buttons */
        .btn-primary-kihbt{
            background:var(--primary);
            color:#fff;
            border:none;
            border-radius:9999px;
            padding:.55rem 1.2rem;
            font-weight:700;
            transition:.2s ease all;
        }
        .btn-primary-kihbt:hover{background:#000; transform: translateY(-1px);}

        .btn-secondary-kihbt{
            background:var(--secondary);
            color:#000;
            border:none;
            border-radius:9999px;
            padding:.55rem 1.2rem;
            font-weight:700;
            transition:.2s ease all;
        }
        .btn-secondary-kihbt:hover{background:#d18b00; transform: translateY(-1px);}

        /* Hero */
        .hero{
            padding:3.2rem 1.5rem 2.6rem;
            background:
                radial-gradient(900px 450px at 10% 20%, rgba(249,169,15,.18), transparent 60%),
                linear-gradient(135deg, rgba(59,40,24,.96), rgba(0,0,0,.92));
            color:#fff;
        }
        .hero-inner{
            max-width:1100px;
            margin:0 auto;
            display:flex;
            gap:2rem;
            align-items:center;
            justify-content:space-between;
            flex-wrap:wrap;
        }
        .hero h1{
            font-size:2.05rem;
            font-weight:800;
            margin:0 0 .6rem;
            letter-spacing:.2px;
        }
        .hero p{
            margin:0 0 1.2rem;
            color:rgba(255,255,255,.86);
            max-width:620px;
            line-height:1.6;
            font-size:1rem;
        }
        .hero-actions{
            display:flex;
            gap:.75rem;
            flex-wrap:wrap;
        }
        .hero-chip-row{
            display:flex;
            gap:.6rem;
            flex-wrap:wrap;
            margin-top:1rem;
        }
        .hero-chip{
            background:rgba(255,255,255,.12);
            border:1px solid rgba(255,255,255,.14);
            padding:.45rem .7rem;
            border-radius:999px;
            font-size:.82rem;
            color:rgba(255,255,255,.9);
            display:inline-flex;
            gap:.4rem;
            align-items:center;
        }
        .hero-chip i{color:var(--secondary);}

        /* Section header */
        .section-wrap{padding:2.2rem 1.25rem 2.6rem;}
        .section-head{
            max-width:1100px;
            margin:0 auto 1.2rem;
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:1rem;
            flex-wrap:wrap;
        }
        .section-title{
            font-size:1.35rem;
            font-weight:800;
            color:var(--primary);
            margin:0;
        }
        .section-subtitle{
            margin:0;
            color:var(--tertiary);
            font-size:.95rem;
        }

        /* Services grid */
        .services-grid{
            max-width:1100px;
            margin:0 auto;
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
            gap:1.2rem;
        }

        .service-card{
            background:var(--card);
            border:1px solid var(--line);
            border-radius:16px;
            padding:1.4rem 1.25rem;
            box-shadow:0 10px 28px rgba(0,0,0,.06);
            transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            position:relative;
            overflow:hidden;
        }
        .service-card:hover{
            transform: translateY(-4px);
            box-shadow:0 16px 40px rgba(0,0,0,.10);
            border-color:rgba(249,169,15,.35);
        }

        .service-badge{
            position:absolute;
            top:14px;
            right:14px;
            background:rgba(249,169,15,.14);
            border:1px solid rgba(249,169,15,.25);
            color:#5b4224;
            padding:.25rem .55rem;
            border-radius:999px;
            font-size:.74rem;
            font-weight:800;
            letter-spacing:.25px;
        }

        .service-icon{
            width:60px;height:60px;
            border-radius:16px;
            background:rgba(249,169,15,.15);
            color:var(--secondary);
            display:flex;align-items:center;justify-content:center;
            font-size:2rem;
            margin-bottom:1rem;
        }

        .service-title{
            font-size:1.12rem;
            font-weight:800;
            margin:0 0 .45rem;
            color:var(--primary);
        }

        .service-desc{
            font-size:.92rem;
            color:var(--tertiary);
            line-height:1.6;
            margin:0 0 1.1rem;
        }

        .service-actions{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:.75rem;
            flex-wrap:wrap;
        }

        .service-link{
            font-weight:700;
            color:var(--primary);
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            font-size:.9rem;
        }
        .service-link:hover{color:#000;}

        /* Certificate verification bullets */
        .mini-list{
            margin:.6rem 0 1.1rem;
            padding-left:0;
            list-style:none;
            color:var(--tertiary);
            font-size:.88rem;
        }
        .mini-list li{
            display:flex;
            align-items:flex-start;
            gap:.45rem;
            margin-bottom:.35rem;
        }
        .mini-list i{color:#099139; font-size:1.1rem; margin-top:1px;}

        /* Footer */
        .footer-bottom{
            background:var(--primary);
            color:#fff;
            text-align:center;
            font-size:.92rem;
            padding:1rem 1.25rem;
        }

        @media (max-width: 768px){
            .hero{padding:2.4rem 1.1rem 2.1rem;}
            .hero h1{font-size:1.6rem;}
            .brand-title{font-size:.85rem;}
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
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="logo-img" alt="KIHBT">
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
{{--                                @if (Route::has('register'))--}}
{{--                                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>--}}
{{--                                @endif--}}
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

{{--                    <a href="{{ route('public.trainings.long') }}" class="btn-primary-kihbt d-inline-flex align-items-center gap-2">--}}
{{--                        <i class="la la-graduation-cap"></i> Long Term / KNEC--}}
{{--                    </a>--}}

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
                </p>

                <div class="service-actions">
                    <a href="{{ route('public.trainings.short') }}" class="btn-primary-kihbt d-inline-flex align-items-center gap-2">
                        <i class="la la-arrow-right"></i> View Trainings
                    </a>
                    <a class="service-link" href="{{ route('public.trainings.short') }}">
                        Learn more <i class="la la-angle-right"></i>
                    </a>
                </div>
            </div>

{{--            <!-- Long Term / KNEC -->--}}
{{--            <div class="service-card">--}}
{{--                <div class="service-badge">LONG TERM</div>--}}
{{--                <div class="service-icon"><i class="la la-graduation-cap"></i></div>--}}
{{--                <h3 class="service-title">KNEC / Long Course Application</h3>--}}
{{--                <p class="service-desc">--}}
{{--                    Browse long term programmes (KNEC) and apply using the online application process.--}}
{{--                </p>--}}

{{--                <div class="service-actions">--}}
{{--                    <a href="{{ route('public.trainings.long') }}" class="btn-primary-kihbt d-inline-flex align-items-center gap-2">--}}
{{--                        <i class="la la-arrow-right"></i> View Programmes--}}
{{--                    </a>--}}
{{--                    <a class="service-link" href="{{ route('public.trainings.long') }}">--}}
{{--                        Learn more <i class="la la-angle-right"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

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

                </div>
            </div>

            <!-- Student Management -->
{{--            <div class="service-card">--}}
{{--                <div class="service-badge">STUDENTS</div>--}}
{{--                <div class="service-icon"><i class="la la-users-cog"></i></div>--}}
{{--                <h3 class="service-title">Student Management</h3>--}}
{{--                <p class="service-desc">--}}
{{--                    Manage student records, enrollments and academic profiles efficiently.--}}
{{--                </p>--}}

{{--                <div class="service-actions">--}}
{{--                    <a href="#" class="btn-primary-kihbt d-inline-flex align-items-center gap-2">--}}
{{--                        <i class="la la-user"></i> Get Started--}}
{{--                    </a>--}}
{{--                    <a class="service-link" href="#">--}}
{{--                        Learn more <i class="la la-angle-right"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

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

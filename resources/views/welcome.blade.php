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
        :root {
            --primary:#3b2818;
            --secondary:#f9a90f;
            --tertiary:#858585;
            --bg:#f5f6f5;
            --text-dark:#26211d;
        }

        body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text-dark);margin:0;}
        .boxed-container{max-width:1300px;margin:0 auto;background:#fff;box-shadow:0 0 20px rgba(0,0,0,.05);border-radius:12px;overflow:visible;}
        a{text-decoration:none;color:inherit;}

        /* Header */
        .site-header{
            background:#fff;
            color:var(--text-dark);
            position:sticky;top:0;z-index:1020;
            border-top-left-radius:12px;border-top-right-radius:12px;
            box-shadow:0 3px 12px rgba(0,0,0,.05);
        }
        .navbar{padding-top:.35rem;padding-bottom:.35rem;}
        .nav-link,.navbar-brand,.auth-link{color:var(--primary)!important;font-weight:600;}
        .nav-link:hover{color:var(--secondary)!important;}
        .brand-title{font-weight:700;letter-spacing:.3px;margin-left:.5rem;}
        .logo-img{height:40px;width:auto;}

        /* Buttons */
        .btn-primary{
            background:var(--primary);
            color:#fff;border:none;border-radius:9999px;padding:.6rem 1.4rem;
            transition:.3s ease all;
        }
        .btn-primary:hover{background:#000;}
        .btn-secondary{
            background:var(--secondary);
            color:#000;border:none;border-radius:9999px;padding:.6rem 1.4rem;
            transition:.3s ease all;
        }
        .btn-secondary:hover{background:#d18b00;}

        /* Hero section */
        .hero-intro{
            background:var(--primary);
            color:#fff;text-align:center;
            padding:3rem 1rem 4rem;
            border-bottom-left-radius:12px;border-bottom-right-radius:12px;
        }
        .hero-intro h1{font-size:2rem;font-weight:800;margin:.2rem 0 .8rem;}
        .hero-intro p{font-size:1.05rem;max-width:760px;margin:0 auto 1.6rem;color:#e8e8e8;}

        /* Services */
        #account-types{background:#fafafa;padding:2rem 1rem 3rem;}
        .acct-header{
            background:var(--primary);
            color:#fff;text-align:center;padding:1rem;
            border-radius:.75rem;margin:0 auto 2rem;max-width:60%;
        }
        .acct-header h2{font-size:1.4rem;font-weight:700;}

        .acct-card{
            background:#fff;padding:1.75rem 1.5rem;border-radius:1rem;
            border-top:4px solid var(--secondary);text-align:center;
            box-shadow:0 8px 22px rgba(0,0,0,.05);
            transition:transform .3s ease,box-shadow .3s ease;
        }
        .acct-icon{
            font-size:2.4rem;color:var(--secondary);
            background:#fff9db;border-radius:50%;
            width:70px;height:70px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;
        }
        .acct-title{font-size:1.2rem;font-weight:600;margin-bottom:.6rem;}
        .acct-desc{font-size:.92rem;color:var(--tertiary);line-height:1.55;margin-bottom:1.4rem;}

        /* Footer */
        .footer-bottom{
            background:var(--primary);
            color:#fff;text-align:center;font-size:.95rem;
            padding:1rem 1.25rem;border-bottom-left-radius:12px;border-bottom-right-radius:12px;
        }
    </style>
</head>
<body>

<div class="boxed-container">

    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="logo-img" alt="KIHBT">
                    <span class="brand-title">Kenya Institute of Highways and Building Technology (KIHBT)</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#kaaNav">
                    <span class="la la-bars" style="font-size:1.5rem;color:var(--primary);"></span>
                </button>

                <div class="collapse navbar-collapse" id="kaaNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>

                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log in</a></li>
                                @if (Route::has('register'))
                                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>


    <!-- Services -->
    <section id="account-types">
        <div class="acct-header">
            <h2>Our Services</h2>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.75rem;max-width:1000px;margin:0 auto;">

            <div class="acct-card">
                <span class="acct-icon"><i class="la la-calendar-check"></i></span>
                <h3 class="acct-title">Course Application</h3>
                <p class="acct-desc">
                    Browse and  Apply for available training programs across all KIHBT campuses.
                </p>

                <a href="{{ route('public.trainings') }}" class="btn-primary d-inline-flex align-items-center gap-2">
                    <i class="la la-arrow-right"></i> View Trainings
                </a>
            </div>


            <div class="acct-card p-4 text-center shadow-sm border rounded-3"
                 style="background: #fff; border-color: #e5e7eb;">

                {{-- Icon --}}
                <div class="mb-3">
                <span class="acct-icon d-inline-flex justify-content-center align-items-center"
                      style="width: 70px; height: 70px; border-radius: 50%;
                             background: #09913910; color: #099139; font-size: 35px;">
                    <i class="la la-certificate"></i>
                </span>
                </div>

                {{-- Title --}}
                <h3 class="acct-title mb-2 fw-bold" style="color:#3B2818;">
                    Certificate Verification
                </h3>

                {{-- Description --}}
                <p class="acct-desc text-muted mb-3" style="font-size: 14px;">
                    Enter your certificate number to verify its authenticity instantly.
                    No login required.
                </p>

                {{-- Bullet points --}}
                <ul class="list-unstyled small text-start mx-auto mb-4" style="max-width: 260px;">
                    <li class="mb-1"><i class="la la-check-circle text-success"></i> Validate authenticity</li>
                    <li class="mb-1"><i class="la la-check-circle text-success"></i> Retrieve trainee details</li>
                    <li class=""><i class="la la-check-circle text-success"></i> Fast and secure</li>
                </ul>

                {{-- Button --}}
                <a href="{{ route('certificates.verify') }}"
                   class="btn d-inline-flex align-items-center gap-2 px-4 py-2 fw-semibold"
                   style="background:#099139; color:#fff; border-radius: 6px;">
                    <i class="la la-search"></i> Verify Certificate
                </a>
            </div>


            <div class="acct-card">
                <span class="acct-icon"><i class="la la-users-cog"></i></span>
                <h3 class="acct-title">Student Management</h3>
                <p class="acct-desc">Manage student records, course enrollments, and academic profiles efficiently.</p>
                <a href="#" class="btn-primary d-inline-flex align-items-center gap-2">
                    <i class="la la-user"></i> Get Started
                </a>
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

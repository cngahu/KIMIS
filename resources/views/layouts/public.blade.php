<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Application Portal – KIHBT' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"/>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        :root {
            --primary:#3b2818;
            --secondary:#f9a90f;
            --tertiary:#858585;
            --bg:#f5f6f5;
            --text-dark:#26211d;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:var(--bg);
            color:var(--text-dark);
            margin:0;
        }

        a{ text-decoration:none; color:inherit; }

        .boxed-container{
            max-width:1300px;
            margin:1.5rem auto;
            background:#fff;
            box-shadow:0 0 20px rgba(0,0,0,.05);
            border-radius:12px;
            overflow:visible;
        }

        /* Header */
        .site-header{
            background:#fff;
            color:var(--text-dark);
            border-top-left-radius:12px;
            border-top-right-radius:12px;
            box-shadow:0 3px 12px rgba(0,0,0,.05);
        }
        .navbar{padding-top:.35rem;padding-bottom:.35rem;}
        .nav-link,.navbar-brand{color:var(--primary)!important;font-weight:600;}
        .nav-link:hover{color:var(--secondary)!important;}
        .brand-title{font-weight:700;letter-spacing:.3px;margin-left:.5rem;font-size:.9rem;}
        .logo-img{height:40px;width:auto;}

        /* Page hero (reused by pages) */
        .page-hero{
            padding:1.5rem 1.5rem 0;
        }
        .page-hero h1{
            font-size:1.6rem;
            font-weight:700;
            margin-bottom:.3rem;
            color:var(--primary);
        }
        .page-hero p{
            margin:0;
            font-size:.95rem;
            color:var(--tertiary);
        }

        /* Buttons */
        .btn-primary-kihbt{
            background:var(--primary);
            color:#fff;
            border:none;
            border-radius:9999px;
            padding:.45rem 1.4rem;
            font-size:.95rem;
            transition:.3s ease all;
        }
        .btn-primary-kihbt:hover{background:#000;color:#fff;}

        .btn-secondary-kihbt{
            background:var(--secondary);
            color:#000;
            border:none;
            border-radius:9999px;
            padding:.45rem 1.4rem;
            font-size:.95rem;
            transition:.3s ease all;
        }
        .btn-secondary-kihbt:hover{background:#d18b00;color:#000;}

        /* Generic card styling for public forms */
        .public-card {
            border-radius:12px;
            border:none;
            box-shadow:0 6px 16px rgba(0,0,0,.04);
            margin-bottom:1.25rem;
        }
        .public-card .card-header{
            background:var(--primary);
            color:#fff;
            font-weight:600;
            border-top-left-radius:12px!important;
            border-top-right-radius:12px!important;
        }

        /* Footer */
        .footer-bottom{
            background:var(--primary);
            color:#fff;
            text-align:center;
            font-size:.9rem;
            padding:.8rem 1.25rem;
            border-bottom-left-radius:12px;
            border-bottom-right-radius:12px;
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="boxed-container">

    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="logo-img" alt="KIHBT">
                    <span class="brand-title">
                        Kenya Institute of Highways and Building Technology (KIHBT)
                    </span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#kaaNav">
                    <span class="la la-bars" style="font-size:1.5rem;color:var(--primary);"></span>
                </button>

                <div class="collapse navbar-collapse" id="kaaNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>

{{--                        @if (Route::has('login'))--}}
{{--                            @auth--}}
{{--                                <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>--}}
{{--                            @else--}}
{{--                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log in</a></li>--}}
{{--                                @if (Route::has('register'))--}}
{{--                                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>--}}
{{--                                @endif--}}
{{--                            @endauth--}}
{{--                        @endif--}}
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    {{-- Page-specific content --}}
    @yield('content')

    <!-- Footer -->
    <footer class="footer-bottom">
        © {{ date('Y') }} Kenya Institute of Highways and Building Technology (KIHBT). All rights reserved.
    </footer>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stack('scripts')

</body>
</html>

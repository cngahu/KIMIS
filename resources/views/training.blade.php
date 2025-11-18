<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Scheduled Trainings – KIHBT</title>

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

        body{
            font-family:'Poppins',sans-serif;
            background:var(--bg);
            color:var(--text-dark);
            margin:0;
        }
        .boxed-container{
            max-width:1300px;
            margin:1.5rem auto;
            background:#fff;
            box-shadow:0 0 20px rgba(0,0,0,.05);
            border-radius:12px;
            overflow:visible;
        }
        a{text-decoration:none;color:inherit;}

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

        /* Buttons */
        .btn-primary-kihbt{
            background:var(--primary);
            color:#fff;
            border:none;
            border-radius:9999px;
            padding:.45rem 1.2rem;
            font-size:.9rem;
            transition:.3s ease all;
        }
        .btn-primary-kihbt:hover{background:#000;}
        .btn-secondary-kihbt{
            background:var(--secondary);
            color:#000;
            border:none;
            border-radius:9999px;
            padding:.45rem 1.2rem;
            font-size:.9rem;
            transition:.3s ease all;
        }
        .btn-secondary-kihbt:hover{background:#d18b00;}

        /* Page header */
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

        /* Filters */
        .filters-wrapper{
            padding:0 1.5rem 1.5rem;
        }

        /* Cards grid */
        .trainings-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
            gap:1.5rem;
            padding:0 1.5rem 1.5rem;
        }
        .training-card{
            border-radius:12px;
            border:1px solid #eee;
            padding:1.25rem 1.1rem;
            box-shadow:0 6px 16px rgba(0,0,0,.04);
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            height:100%;
        }
        .training-header{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:.5rem;
            margin-bottom:.5rem;
        }
        .training-title{
            font-size:1.05rem;
            font-weight:600;
            margin-bottom:.2rem;
        }
        .training-campus{
            font-size:.85rem;
            color:var(--tertiary);
        }
        .badge-status{
            font-size:.75rem;
            padding:.25rem .6rem;
            border-radius:999px;
            background:#e7f6e7;
            color:#157347;
            font-weight:600;
            text-transform:uppercase;
        }
        .training-meta{
            font-size:.85rem;
            color:var(--tertiary);
            margin:.15rem 0;
        }
        .training-meta i{
            color:var(--secondary);
            margin-right:.35rem;
        }
        .training-footer{
            margin-top:1rem;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:.75rem;
            flex-wrap:wrap;
        }
        .cost-tag{
            font-weight:600;
            color:var(--primary);
            font-size:.95rem;
        }
        .cost-tag span{
            font-size:.8rem;
            color:var(--tertiary);
            font-weight:400;
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

    {{-- Page Hero --}}
    <section class="page-hero">
        <h1>Scheduled Trainings</h1>
        <p>Explore approved training programmes across all KIHBT campuses and register online.</p>
    </section>

    {{-- Filters --}}
    <section class="filters-wrapper">
        <form action="{{ route('public.trainings') }}" method="GET" class="w-100 mb-3">
            <div class="row g-2 align-items-center">

                {{-- Search --}}
                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-sm"
                        placeholder="Search by course name or code..."
                        value="{{ request('search') }}"
                    >
                </div>

                {{-- Campus filter --}}
                <div class="col-md-3">
                    <select name="college_id" class="form-select form-select-sm">
                        <option value="">All Campuses</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}" {{ (int) request('college_id') === $college->id ? 'selected' : '' }}>
                                {{ $college->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-md-5 d-flex gap-2 justify-content-md-end">
                    <button type="submit" class="btn-secondary-kihbt">
                        <i class="la la-filter me-1"></i> Filter
                    </button>

                    @if(request('search') || request('college_id'))
                        <a href="{{ route('public.trainings') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="la la-undo me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </section>

    {{-- Trainings Grid --}}
    <section class="trainings-grid">
        @if($trainings->count())
            @foreach($trainings as $training)
                <div class="training-card">
                    <div>
                        <div class="training-header">
                            <div>
                                <div class="training-title">
                                    {{ optional($training->course)->course_name ?? 'Unnamed Course' }}
                                </div>
                                <div class="training-campus">
                                    <i class="la la-map-marker-alt me-1"></i>
                                    {{ optional($training->college)->name ?? 'All Campuses' }}
                                </div>
                            </div>
                            <span class="badge-status">
                                Approved
                            </span>
                        </div>

                        <div class="mt-2">
                            <div class="training-meta">
                                <i class="la la-calendar"></i>
                                <strong>Start:</strong>
                                @if($training->start_date)
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                                @else
                                    TBA
                                @endif
                            </div>

                            <div class="training-meta">
                                <i class="la la-calendar-check"></i>
                                <strong>End:</strong>
                                @if($training->end_date)
                                    {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}
                                @else
                                    TBA
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="training-footer">
                        <div class="cost-tag">
                            KSh {{ number_format($training->cost, 2) }}
                            <span>/ total</span>
                        </div>

                        {{-- Register CTA: you can adjust this route later --}}
                        <a href="{{ route('login', ['training_id' => $training->id]) }}"
                           class="btn-primary-kihbt d-inline-flex align-items-center gap-1">
                            <i class="la la-edit"></i> Register
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info mx-3 mb-3">
                    No approved trainings found
                    @if(request('search') || request('college_id'))
                        for the current filters.
                        <a href="{{ route('public.trainings') }}">Clear filters</a>
                    @else
                        at the moment. Please check again later.
                    @endif
                </div>
            </div>
        @endif
    </section>

    {{-- Pagination --}}
    @if($trainings->hasPages())
        <div class="px-4 pb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 small text-muted">
                <div>
                    Showing
                    <strong>{{ $trainings->firstItem() }}</strong>
                    to
                    <strong>{{ $trainings->lastItem() }}</strong>
                    of
                    <strong>{{ $trainings->total() }}</strong>
                    trainings
                </div>
                <div>
                    {{ $trainings->links() }}
                </div>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="footer-bottom">
        © {{ date('Y') }} Kenya Institute of Highways and Building Technology (KIHBT). All rights reserved.
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

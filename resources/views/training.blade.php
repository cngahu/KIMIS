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

        /* Table styling */
        .table-container {
            padding: 0 1.5rem 1.5rem;
        }
        .trainings-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 6px 16px rgba(0,0,0,.04);
            border-radius: 12px;
            overflow: hidden;
        }
        .trainings-table th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: left;
            font-size: 0.9rem;
        }
        .trainings-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .trainings-table tr:last-child td {
            border-bottom: none;
        }
        .trainings-table tr:hover {
            background-color: rgba(249, 169, 15, 0.05);
        }
        .course-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--primary);
        }
        .course-code {
            font-size: 0.85rem;
            color: var(--tertiary);
        }
        .campus-name {
            font-size: 0.9rem;
            color: var(--tertiary);
        }
        .campus-name i {
            color: var(--secondary);
            margin-right: 0.35rem;
        }
        .date-cell {
            font-size: 0.9rem;
        }
        .cost-cell {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
        }
        .cost-cell span {
            font-size: 0.8rem;
            color: var(--tertiary);
            font-weight: 400;
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

        /* Requirements styling */
        .requirements-wrap {
            margin-top: 0.25rem;
            font-size: 0.8rem;
            color: var(--tertiary);
        }

        .requirements-label {
            font-weight: 600;
            color: var(--primary);
            display: block;
            margin-bottom: 0.1rem;
        }

        .requirements-list {
            padding-left: 1rem;
            margin-bottom: 0;
        }

        .requirements-list li {
            margin-bottom: 0.1rem;
        }

        /* Responsive table */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
            .trainings-table {
                min-width: 700px;
            }
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

    {{-- Trainings Table --}}
    <section class="table-container">
        @if($trainings->count())
            <table class="trainings-table">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Campus</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Cost</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trainings as $training)
                    <tr>
                        {{-- Course + Code + Requirements --}}
                        <td>
                            <div class="course-title">
                                {{ optional($training->course)->course_name ?? 'Unnamed Course' }}
                            </div>

                            <div class="course-code">
                                {{ optional($training->course)->course_code ?? 'N/A' }}
                            </div>

                            {{-- Requirements (if any) --}}
                            @if(
                                $training->course
                                && $training->course->requirement
                                && $training->course->requirements->count()
                            )
                                <div class="requirements-wrap">
                                    <span class="requirements-label">Requirements:</span>
                                    <ul class="requirements-list">
                                        @foreach($training->course->requirements as $req)
                                            <li>{!! nl2br(e($req->course_requirement)) !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </td>

                        {{-- Campus --}}
                        <td>
                            <div class="campus-name">
                                <i class="la la-map-marker-alt"></i>
                                {{ optional($training->college)->name ?? 'All Campuses' }}
                            </div>
                        </td>

                        {{-- Start Date --}}
                        <td class="date-cell">
                            @if($training->start_date)
                                {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                            @else
                                TBA
                            @endif
                        </td>

                        {{-- End Date --}}
                        <td class="date-cell">
                            @if($training->end_date)
                                {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}
                            @else
                                TBA
                            @endif
                        </td>

                        {{-- Cost --}}
                        <td class="cost-cell">
                            KSh {{ number_format($training->cost, 2) }}
                            <span>/ total</span>
                        </td>

                        {{-- Action --}}
                        <td>
                            <a href="{{ route('login', ['training_id' => $training->id]) }}"
                               class="btn-primary-kihbt d-inline-flex align-items-center gap-1">
                                <i class="la la-edit"></i> Apply
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info mx-3 mb-3">
                No approved trainings found
                @if(request('search') || request('college_id'))
                    for the current filters.
                    <a href="{{ route('public.trainings') }}">Clear filters</a>
                @else
                    at the moment. Please check again later.
                @endif
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

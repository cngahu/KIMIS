@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">KIHBT Master Dashboard</h4>
                <p class="text-muted mb-0">
                    Institution-wide enrollment & registration overview
                </p>
            </div>

            {{-- Campus Filter --}}
            <form method="GET">
                <select name="campus_id"
                        class="form-select"
                        onchange="this.form.submit()">
                    <option value="">All Campuses</option>
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}"
                            @selected($selectedCampus == $campus->id)>
                            {{ $campus->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- GLOBAL KPI CARDS --}}
        <div class="row g-3 mb-4">

            <div class="col-md-2">
                <div class="card radius-10 shadow-sm text-center p-3">
                    <small class="text-muted">Campuses</small>
                    <h3 class="fw-bold text-primary mb-0">
                        {{ $global['campuses'] }}
                    </h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card radius-10 shadow-sm text-center p-3">
                    <small class="text-muted">Courses</small>
                    <h3 class="fw-bold text-success mb-0">
                        {{ $global['courses'] }}
                    </h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card radius-10 shadow-sm text-center p-3">
                    <small class="text-muted">Expected Students</small>
                    <h3 class="fw-bold text-dark mb-0">
                        {{ number_format($global['expected_students']) }}
                    </h3>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card radius-10 shadow-sm text-center p-3">
                    <small class="text-muted">Activated</small>
                    <h3 class="fw-bold text-info mb-0">
                        {{ number_format($global['activated_students']) }}
                    </h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card radius-10 shadow-sm text-center p-3">
                    <small class="text-muted">Registered (Current Cycle)</small>
                    <h3 class="fw-bold text-success mb-0">
                        {{ number_format($global['registered_students']) }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- CAMPUS SUMMARY --}}
        @if($selectedCampus && $campusStats)

            <div class="card radius-10 shadow-sm mb-4">
                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        {{ $campusStats['campus']->name }} – Campus Summary
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-3">
                            <div class="border rounded p-3 text-center">
                                <small class="text-muted">Courses</small>
                                <h4 class="fw-bold mb-0">
                                    {{ $campusStats['courses'] }}
                                </h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border rounded p-3 text-center">
                                <small class="text-muted">Expected</small>
                                <h4 class="fw-bold mb-0">
                                    {{ number_format($campusStats['expected_students']) }}
                                </h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border rounded p-3 text-center">
                                <small class="text-muted">Activated</small>
                                <h4 class="fw-bold mb-0">
                                    {{ number_format($campusStats['activated_students']) }}
                                </h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border rounded p-3 text-center">
                                <small class="text-muted">Registered</small>
                                <h4 class="fw-bold mb-0 text-success">
                                    {{ number_format($campusStats['registered_students']) }}
                                </h4>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        @endif

        {{-- COURSE BREAKDOWN --}}
        @if($selectedCampus && $courseBreakdown && count($courseBreakdown))

            <div class="card radius-10 shadow-sm mt-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            Course Breakdown –
                            <span class="text-primary">
                        {{ $campusStats['campus']->name }}
                    </span>
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th class="text-end">Expected</th>
                                <th class="text-end">Activated</th>
                                <th class="text-end">Registered</th>
                                <th class="text-end">Completion</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($courseBreakdown as $row)

                                @php
                                    $expected   = (int) ($row['expected_students'] ?? 0);
                                    $activated  = (int) ($row['activated_students'] ?? 0);
                                    $registered = (int) ($row['registered_students'] ?? 0);

                                    $completion = $expected > 0
                                        ? round(($registered / $expected) * 100)
                                        : 0;
                                @endphp

                                <tr>
                                    <td>
                                        <strong>{{ $row['course_name'] }}</strong>
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($expected) }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($activated) }}
                                    </td>

                                    <td class="text-end fw-bold">
                                        {{ number_format($registered) }}
                                    </td>

                                    <td class="text-end">
                                <span class="badge
                                    {{ $completion >= 75
                                        ? 'bg-success'
                                        : ($completion >= 50
                                            ? 'bg-warning text-dark'
                                            : 'bg-danger') }}">
                                    {{ $completion }}%
                                </span>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        @endif


    </div>

@endsection

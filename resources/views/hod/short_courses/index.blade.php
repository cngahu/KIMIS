@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .course-card {
            border-left: 4px solid #3b2818;
            transition: all .2s ease-in-out;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,.08);
        }
        .metric {
            font-size: 1.35rem;
            font-weight: 700;
        }
        .metric-label {
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
        }
    </style>

    <div class="page-content">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Short Courses – Schedules</h4>
                <p class="mb-0 text-muted">
                    Manage and monitor <strong>short-term course schedules</strong> under your academic departments.
                </p>
            </div>

            {{-- Optional future button --}}
            {{-- <a href="#" class="btn btn-sm btn-primary">Create New Schedule</a> --}}
        </div>

        {{-- SUMMARY STRIP --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">{{ $courses->count() }}</div>
                        <div class="metric-label">Short Courses</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">
                            {{ $courses->sum('trainings_count') }}
                        </div>
                        <div class="metric-label">Total Schedules</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">
                            {{ $courses->where('trainings_count','>',0)->count() }}
                        </div>
                        <div class="metric-label">Active Courses</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COURSES GRID --}}
        <div class="row g-3">

            @forelse($courses as $course)
                <div class="col-md-6 col-xl-4">
                    <div class="card course-card h-100 radius-10">
                        <div class="card-body d-flex flex-column">

                            {{-- COURSE TITLE --}}
                            <div class="mb-2">
                                <h6 class="fw-bold mb-0">
                                    {{ $course->course_name }}
                                </h6>
                                <small class="text-muted">
                                    {{ $course->course_code }}
                                </small>
                            </div>

                            {{-- META --}}
                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Department:
                                    <strong>{{ optional($course->academicDepartment)->name }}</strong>
                                </small>
                                <small class="text-muted d-block">
                                    Campus:
                                    <strong>{{ optional($course->college)->name }}</strong>
                                </small>
                            </div>

                            {{-- METRICS --}}
                            <div class="row text-center mb-3">
                                <div class="col">
                                    <div class="fw-bold">
                                        {{ $course->trainings_count }}
                                    </div>
                                    <small class="text-muted">Schedules</small>
                                </div>
                                <div class="col">
                                    <div class="fw-bold">
                                        {{ $course->trainings_count > 0 ? 'Yes' : '—' }}
                                    </div>
                                    <small class="text-muted">Active</small>
                                </div>
                            </div>

                            {{-- ACTION --}}
                            <div class="mt-auto">
                                <a href="{{ route('hod.short_courses.schedules', $course) }}"
                                   class="btn btn-sm btn-outline-primary w-100">
                                    View Schedules
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No short courses assigned to your departments yet.
                    </div>
                </div>
            @endforelse

        </div>

    </div>

@endsection

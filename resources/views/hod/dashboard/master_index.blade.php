@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        {{-- ===== HEADER ===== --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-1">HOD Dashboard</h4>
            <p class="text-muted mb-0">
                Academic overview of departments, courses and cohorts under your supervision
            </p>
        </div>

        {{-- ===== TOP SUMMARY (DERIVED FROM SAME DATA) ===== --}}
        @php
            $totalDepartments = $departments->count();
            $totalCourses = $departments->flatMap->courses->count();
            $totalCohorts = $departments->flatMap->courses->flatMap->courseCohorts->count();
            $totalStudents = $departments
                ->flatMap->courses
                ->flatMap->courseCohorts
                ->sum('students_count');
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card radius-10 shadow-sm border-start border-primary border-4">
                    <div class="card-body">
                        <div class="text-muted small">Departments</div>
                        <h4 class="fw-bold mb-0">{{ $totalDepartments }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card radius-10 shadow-sm border-start border-info border-4">
                    <div class="card-body">
                        <div class="text-muted small">Courses</div>
                        <h4 class="fw-bold mb-0">{{ $totalCourses }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card radius-10 shadow-sm border-start border-warning border-4">
                    <div class="card-body">
                        <div class="text-muted small">Cohorts</div>
                        <h4 class="fw-bold mb-0">{{ $totalCohorts }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card radius-10 shadow-sm border-start border-success border-4">
                    <div class="card-body">
                        <div class="text-muted small">Students</div>
                        <h4 class="fw-bold mb-0">{{ number_format($totalStudents) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== DEPARTMENTS LOOP ===== --}}
        @forelse($departments as $department)

            <div class="card mb-4 radius-10 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">
                        {{ $department->name }}
                        <span class="text-muted">
                        ({{ $department->college->name }})
                    </span>
                    </h6>
                </div>

                <div class="card-body">

                    @forelse($department->courses as $course)

                        <div class="mb-4">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0">
                                    {{ $course->course_name }}
                                    <span class="text-muted">
                                    [{{ $course->course_code }}]
                                </span>
                                </h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">

                                    <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 30%">Cohort</th>
                                        <th>Status</th>
                                        <th class="text-end">Students</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($course->courseCohorts as $cohort)
                                        <tr>
                                            <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $cohort->intake_year }} /
                                                {{ $cohort->intake_month }}
                                            </span>
                                            </td>

                                            <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst($cohort->status) }}
                                            </span>
                                            </td>

{{--                                            <td class="text-end fw-bold">--}}
{{--                                                {{ number_format($cohort->students_count ?? 0) }}--}}
{{--                                            </td>--}}
                                            <td class="text-end fw-bold">
                                                {{ number_format($cohort->students_count ?? 0) }}
                                            </td>

                                            <td class="text-end">
                                                <a href="{{ route('hod.participants.print', [$course->id, $cohort->id]) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    Print List
                                                </a>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">
                                                No cohorts found for this course.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    @empty
                        <p class="text-muted mb-0">
                            No courses assigned to this department.
                        </p>
                    @endforelse

                </div>
            </div>

        @empty
            <div class="alert alert-warning">
                You are not assigned to any academic department.
            </div>
        @endforelse

    </div>
@endsection


{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}

{{--    <div class="container-fluid">--}}

{{--        --}}{{-- Header --}}
{{--        <a href="{{ route('course_cohorts.create') }}" class="btn btn-primary mb-3">--}}
{{--            <i class="fas fa-plus me-1"></i> Add New Intake--}}
{{--        </a>--}}

{{--        --}}{{-- Success --}}
{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--        @endif--}}

{{--        <div class="card shadow-sm">--}}
{{--            <div class="card-body table-responsive">--}}

{{--                <table--}}
{{--                    class="table table-hover table-striped datatable"--}}
{{--                    data-order='[[1,"asc"]]'--}}
{{--                    data-search-placeholder="Search course, college or intake..."--}}
{{--                    data-column-defs='[--}}
{{--                    { "targets": [0,5], "orderable": false, "searchable": false }--}}
{{--                ]'--}}
{{--                >--}}
{{--                    <thead class="table-dark">--}}
{{--                    <tr>--}}
{{--                        <th>#</th>--}}
{{--                        <th>Course</th>--}}
{{--                        <th>College</th>--}}
{{--                        <th>Intake</th>--}}
{{--                        <th>Status</th>--}}
{{--                        <th class="text-center">Actions</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}

{{--                    <tbody>--}}
{{--                    @foreach($cohorts as $index => $cohort)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $index + 1 }}</td>--}}

{{--                            <td>--}}
{{--                                <strong>{{ $cohort->course->course_name }}</strong><br>--}}
{{--                                <small class="text-muted">{{ $cohort->course->course_code }}</small>--}}
{{--                            </td>--}}

{{--                            <td>{{ $cohort->course->college->name }}</td>--}}

{{--                            <td>--}}
{{--                            <span class="badge bg-info">--}}
{{--                                {{ \Carbon\Carbon::create(--}}
{{--                                    $cohort->intake_year,--}}
{{--                                    $cohort->intake_month--}}
{{--                                )->format('M Y') }}--}}
{{--                            </span>--}}
{{--                            </td>--}}

{{--                            <td>--}}
{{--                            <span class="badge bg-{{ $cohort->status === 'active' ? 'success' : 'secondary' }}">--}}
{{--                                {{ ucfirst($cohort->status) }}--}}
{{--                            </span>--}}
{{--                            </td>--}}

{{--                            <td class="text-center">--}}
{{--                                <div class="btn-group btn-group-sm">--}}

{{--                                    <a href="{{ route('course_cohorts.show', $cohort) }}"--}}
{{--                                       class="btn btn-outline-info"--}}
{{--                                       title="View Intake">--}}
{{--                                        <i class="fas fa-eye"></i>--}}
{{--                                    </a>--}}

{{--                                    <a href="{{ route('cohort_timelines.index', $cohort) }}"--}}
{{--                                       class="btn btn-outline-primary"--}}
{{--                                       title="View Timeline">--}}
{{--                                        <i class="fas fa-stream"></i>--}}
{{--                                    </a>--}}

{{--                                    <a href="{{ route('timeline.cohort', $cohort) }}"--}}
{{--                                       class="btn btn-outline-primary"--}}
{{--                                       title="Horizontal Timeline">--}}
{{--                                        <i class="fas fa-project-diagram"></i>--}}
{{--                                    </a>--}}

{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        {{-- Header --}}
        <a href="{{ route('course_cohorts.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus me-1"></i> Add New Intake
        </a>

        {{-- Success --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table
                    class="table table-hover table-striped datatable nowrap"
                    data-order='[[1,"asc"]]'
                    data-search-placeholder="Search course, college or intake..."
                    data-column-defs='[
                    { "targets": [0,5], "orderable": false, "searchable": false }
                ]'
                    data-paging="false"
                    data-info="false"
                    data-length-menu='[-1]'
                    data-page-length="-1"
                    data-responsive="false"
                    data-scroll-x="true"
                >
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Course</th>
                        <th>College</th>
                        <th>Intake</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($cohorts as $index => $cohort)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <strong>{{ $cohort->course->course_name }}</strong><br>
                                <small class="text-muted">{{ $cohort->course->course_code }}</small>
                            </td>

                            <td>{{ $cohort->course->college->name }}</td>

                            <td>
                            <span class="badge bg-info">
                                {{ \Carbon\Carbon::create(
                                    $cohort->intake_year,
                                    $cohort->intake_month
                                )->format('M Y') }}
                            </span>
                            </td>

                            <td>
                            <span class="badge bg-{{ $cohort->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($cohort->status) }}
                            </span>
                            </td>

                            <td class="text-center">
                                <div class="btn-group btn-group-sm">

                                    <a href="{{ route('course_cohorts.show', $cohort) }}"
                                       class="btn btn-outline-info"
                                       title="View Intake">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('cohort_timelines.index', $cohort) }}"
                                       class="btn btn-outline-primary"
                                       title="View Timeline">
                                        <i class="fas fa-stream"></i>
                                    </a>

                                    <a href="{{ route('timeline.cohort', $cohort) }}"
                                       class="btn btn-outline-primary"
                                       title="Horizontal Timeline">
                                        <i class="fas fa-project-diagram"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection

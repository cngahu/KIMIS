
{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}

{{--    --}}{{-- ===================== --}}
{{--    --}}{{--  DATA TABLES CSS     --}}
{{--    --}}{{-- ===================== --}}
{{--    <link rel="stylesheet"--}}
{{--          href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">--}}

{{--    <style>--}}
{{--        .dataTables_filter input {--}}
{{--            border: 1px solid #dee2e6 !important;--}}
{{--            border-radius: 4px !important;--}}
{{--            padding: 4px 8px;--}}
{{--        }--}}

{{--        .dataTables_length select {--}}
{{--            border-radius: 4px;--}}
{{--            padding: 4px 6px;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="container-fluid">--}}

{{--        --}}{{-- Header --}}
{{--        <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--            <h4 class="mb-0">Courses</h4>--}}

{{--            @role('superadmin')--}}
{{--            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">--}}
{{--                <i class="fas fa-plus me-1"></i> Add New Course--}}
{{--            </a>--}}
{{--            @endrole--}}
{{--        </div>--}}

{{--        --}}{{-- Success Message --}}
{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{-- Courses Table --}}
{{--        <div class="card shadow-sm">--}}
{{--            <div class="card-body">--}}

{{--                <div class="table-responsive">--}}
{{--                    <table id="coursesTable" class="table table-striped table-hover align-middle">--}}
{{--                        <thead class="table-dark">--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>Course Name</th>--}}
{{--                            <th>Campus</th>--}}
{{--                            <th>Category</th>--}}
{{--                            <th>Code</th>--}}
{{--                            <th>Mode</th>--}}
{{--                            <th>Duration</th>--}}
{{--                            <th>Req</th>--}}
{{--                            <th class="text-center">Actions</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}

{{--                        <tbody>--}}
{{--                        @foreach($courses as $index => $course)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $index + 1 }}</td>--}}

{{--                                <td><strong>{{ $course->course_name }}</strong></td>--}}

{{--                                <td>{{ $course->college->name }}</td>--}}

{{--                                <td>--}}
{{--                                <span class="badge--}}
{{--                                    @if($course->course_category == 'Diploma') bg-primary--}}
{{--                                    @elseif($course->course_category == 'Craft') bg-success--}}
{{--                                    @elseif($course->course_category == 'Higher Diploma') bg-warning text-dark--}}
{{--                                    @else bg-info text-dark @endif">--}}
{{--                                    {{ $course->course_category }}--}}
{{--                                </span>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    <code class="bg-light px-2 py-1 rounded">--}}
{{--                                        {{ $course->course_code }}--}}
{{--                                    </code>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                <span class="badge {{ $course->course_mode == 'Long Term' ? 'bg-dark' : 'bg-secondary' }}">--}}
{{--                                    {{ $course->course_mode }}--}}
{{--                                </span>--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                <span class="fw-bold text-primary">--}}
{{--                                    {{ $course->course_duration }} months--}}
{{--                                </span>--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                <span class="badge {{ $course->requirement ? 'bg-success' : 'bg-secondary' }}">--}}
{{--                                    {{ $course->requirement ? 'Yes' : 'No' }}--}}
{{--                                </span>--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                    <div class="btn-group btn-group-sm">--}}

{{--                                        <a href="{{ route('courses.show', $course) }}"--}}
{{--                                           class="btn btn-outline-info">--}}
{{--                                            <i class="fas fa-eye"></i>--}}
{{--                                        </a>--}}

{{--                                        @role('superadmin')--}}
{{--                                        <a href="{{ route('courses.edit', $course) }}"--}}
{{--                                           class="btn btn-outline-warning">--}}
{{--                                            <i class="fas fa-edit"></i>--}}
{{--                                        </a>--}}

{{--                                        <form action="{{ route('courses.delete', $course) }}"--}}
{{--                                              method="POST" class="d-inline">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button class="btn btn-outline-danger">--}}
{{--                                                <i class="fas fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                        @endrole--}}

{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}

{{--                    </table>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--    --}}{{-- ===================== --}}
{{--    --}}{{--  REQUIRED SCRIPTS     --}}
{{--    --}}{{-- ===================== --}}

{{--    --}}{{-- jQuery (REQUIRED for DataTables) --}}
{{--    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>--}}

{{--    --}}{{-- DataTables --}}
{{--    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>--}}

{{--    <script>--}}
{{--        $(document).ready(function () {--}}

{{--            $('#coursesTable').DataTable({--}}
{{--                responsive: true,--}}
{{--                pageLength: 100,--}}
{{--                lengthMenu: [10, 25, 50, 100],--}}
{{--                ordering: true,--}}
{{--                searching: true,--}}
{{--                order: [[1, 'asc']],--}}
{{--                language: {--}}
{{--                    search: "_INPUT_",--}}
{{--                    searchPlaceholder: "Search courses..."--}}
{{--                },--}}
{{--                columnDefs: [--}}
{{--                    { targets: [0, 8], orderable: false, searchable: false }--}}
{{--                ]--}}
{{--            });--}}

{{--        });--}}
{{--    </script>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')

    {{-- ===================== --}}
    {{--  DATA TABLES CSS     --}}
    {{-- ===================== --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        .dataTables_filter input {
            border: 1px solid #dee2e6 !important;
            border-radius: 4px !important;
            padding: 4px 8px;
        }

        .dataTables_length select {
            border-radius: 4px;
            padding: 4px 6px;
        }

        table.dataTable tbody td {
            vertical-align: middle;
            white-space: nowrap;
        }
    </style>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Courses</h4>

            @role('superadmin')
            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add New Course
            </a>
            @endrole
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Courses Table --}}
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="coursesTable"
                           class="table table-striped table-hover align-middle w-100">

                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Duration (Months)</th>
                            <th>Duration (Years)</th>
                            <th>Fee</th>
                            <th>Campus</th>
{{--                            <th>Department</th>--}}
                            <th>Academic Dept</th>
                            <th>Req</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($courses as $index => $course)
                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>{{ $course->course_name }}</strong>
                                </td>

                                <td>
                                    <code class="bg-light px-2 py-1 rounded">
                                        {{ $course->course_code }}
                                    </code>
                                </td>

                                <td>
                                <span class="badge
                                    @if($course->course_category === 'Diploma') bg-primary
                                    @elseif($course->course_category === 'Craft') bg-success
                                    @elseif($course->course_category === 'Higher Diploma') bg-warning text-dark
                                    @elseif($course->course_category === 'Proficiency') bg-info text-dark
                                    @else bg-secondary @endif">
                                    {{ $course->course_category }}
                                </span>
                                </td>

                                <td>
                                <span class="badge {{ $course->course_mode === 'Long Term' ? 'bg-dark' : 'bg-secondary' }}">
                                    {{ $course->course_mode }}
                                </span>
                                </td>

                                <td class="text-center">
                                    {{ $course->course_duration }}
                                </td>

                                <td class="text-center">
                                    {{ $course->duration_years }}
                                </td>

                                <td class="text-end fw-bold text-success">
                                    {{ number_format($course->cost, 2) }}
                                </td>

                                <td>
                                    {{ $course->college->name ?? '—' }}
                                </td>

{{--                                <td>--}}
{{--                                    {{ $course->department->name ?? '—' }}--}}
{{--                                </td>--}}

                                <td>
                                    {{ $course->academicDepartment->name ?? '—' }}
                                </td>

                                <td class="text-center">
                                <span class="badge {{ $course->requirement ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $course->requirement ? 'Yes' : 'No' }}
                                </span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">

                                        <a href="{{ route('courses.show', $course) }}"
                                           class="btn btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @role('superadmin')
                                        <a href="{{ route('courses.edit', $course) }}"
                                           class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('courses.delete', $course) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger"
                                                    onclick="return confirm('Delete this course?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endrole

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

    {{-- ===================== --}}
    {{--  REQUIRED SCRIPTS     --}}
    {{-- ===================== --}}

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#coursesTable').DataTable({
                scrollX: true,
                autoWidth: false,
                responsive: false,

                pageLength: 50,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                searching: true,
                order: [[1, 'asc']],

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search courses..."
                },

                columnDefs: [
                    { targets: [0, 12], orderable: false, searchable: false }
                ]
            });


        });
    </script>

@endsection

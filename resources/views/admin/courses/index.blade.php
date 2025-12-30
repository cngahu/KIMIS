{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}
{{--    <style>--}}
{{--        .icon-brown { color: #6B3A0E !important; }--}}

{{--        .dataTables_filter input {--}}
{{--            border: 1px solid #dee2e6 !important;--}}
{{--            border-radius: 4px !important;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="container-fluid">--}}

{{--        --}}{{-- Header --}}
{{--        @role('superadmin')--}}
{{--        <a href="{{ route('courses.create') }}" class="btn btn-primary">--}}
{{--            <i class="fas fa-plus me-1"></i> Add New Course--}}
{{--        </a>--}}
{{--        @endrole--}}


{{--        --}}{{-- Success Message --}}
{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>--}}
{{--            </div>--}}
{{--        @endif--}}




{{--        --}}{{-- Courses Table --}}
{{--        --}}{{-- Filters: Search + Per Page --}}
{{--        <form method="GET" action="{{ route('all.courses') }}" class="row g-2 mb-3">--}}

{{--            --}}{{-- Search --}}
{{--            <div class="col-md-4">--}}
{{--                <input type="text" name="search" class="form-control form-control-sm"--}}
{{--                       placeholder="Search name, code or category..."--}}
{{--                       value="{{ request('search') }}">--}}
{{--            </div>--}}

{{--            --}}{{-- Per page selector --}}
{{--            <div class="col-md-2">--}}
{{--                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">--}}
{{--                    @foreach([10, 50, 100] as $size)--}}
{{--                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>--}}
{{--                            Show {{ $size }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            --}}{{-- Search button --}}
{{--            <div class="col-md-2 d-grid">--}}
{{--                <button class="btn btn-sm btn-primary" type="submit">--}}
{{--                    <i class="fas fa-search me-1"></i> Search--}}
{{--                </button>--}}
{{--            </div>--}}

{{--            --}}{{-- Reset button --}}
{{--            @if(request('search') || request('per_page'))--}}
{{--                <div class="col-md-2 d-grid">--}}
{{--                    <a href="{{ route('all.courses') }}" class="btn btn-sm btn-secondary">--}}
{{--                        <i class="fas fa-undo me-1"></i> Reset--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </form>--}}




{{--        <div class="card-body">--}}
{{--                <div class="table-responsive">--}}
{{--                    <table id="coursesTable" class="table table-hover table-striped">--}}
{{--                        <thead class="table-dark">--}}
{{--                        <tr>--}}
{{--                            <th width="5%">#</th>--}}
{{--                            <th width="30%">Course Name</th>--}}
{{--                            <th>Campus</th>--}}
{{--                            <th width="12%">Category</th>--}}
{{--                            <th width="10%">Code</th>--}}
{{--                            <th width="10%">Mode</th>--}}
{{--                            <th width="8%">Duration</th>--}}
{{--                            <th width="6%">Req</th>   --}}{{-- NEW --}}
{{--                            <th width="19%" class="text-center">Actions</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}

{{--                        <tbody>--}}
{{--                        @foreach($courses as $course)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $courses->firstItem() + $loop->index }}</td>--}}

{{--                                <td><strong>{{ $course->course_name }}</strong></td>--}}
{{--                                <td>{{$course->college->name}}</td>--}}

{{--                                <td>--}}
{{--                                    <span class="badge--}}
{{--                                        @if($course->course_category == 'Diploma') bg-primary--}}
{{--                                        @elseif($course->course_category == 'Craft') bg-success--}}
{{--                                        @elseif($course->course_category == 'Higher Diploma') bg-warning text-dark--}}
{{--                                        @else bg-info text-dark @endif">--}}
{{--                                        {{ $course->course_category }}--}}
{{--                                    </span>--}}
{{--                                </td>--}}

{{--                                <td><code class="bg-light px-2 py-1 rounded">{{ $course->course_code }}</code></td>--}}

{{--                                <td>--}}
{{--                                    <span class="badge--}}
{{--                                        @if($course->course_mode == 'Long Term') bg-dark--}}
{{--                                        @else bg-secondary @endif">--}}
{{--                                        {{ $course->course_mode }}--}}
{{--                                    </span>--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                    <span class="fw-bold text-primary">{{ $course->course_duration }} months</span>--}}
{{--                                </td>--}}
{{--                                --}}{{-- NEW: Requirement badge --}}
{{--                                <td class="text-center">--}}
{{--                                    @if($course->requirement)--}}
{{--                                        <span class="badge bg-success">Yes</span>--}}
{{--                                    @else--}}
{{--                                        <span class="badge bg-secondary">No</span>--}}
{{--                                    @endif--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                    <div class="btn-group btn-group-sm" role="group">--}}

{{--                                        --}}{{-- Everyone can VIEW --}}
{{--                                        <a href="{{ route('courses.show', $course) }}"--}}
{{--                                           class="btn btn-outline-info"--}}
{{--                                           title="View">--}}
{{--                                            <i class="fas fa-eye"></i>--}}
{{--                                        </a>--}}

{{--                                        --}}{{-- ONLY SUPERADMIN can EDIT / DELETE --}}
{{--                                        @role('superadmin')--}}
{{--                                        <a href="{{ route('courses.edit', $course) }}"--}}
{{--                                           class="btn btn-outline-warning"--}}
{{--                                           title="Edit">--}}
{{--                                            <i class="fas fa-edit"></i>--}}
{{--                                        </a>--}}

{{--                                        <form action="{{ route('courses.delete', $course) }}"--}}
{{--                                              method="POST"--}}
{{--                                              class="d-inline js-confirm-form"--}}
{{--                                              data-confirm-title="Delete Course?"--}}
{{--                                              data-confirm-text="Delete '{{ $course->course_name }}'? Action cannot be undone."--}}
{{--                                              data-confirm-icon="warning">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button type="submit"--}}
{{--                                                    class="btn btn-outline-danger"--}}
{{--                                                    title="Delete">--}}
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

{{--                --}}{{-- Pagination --}}
{{--                @if ($courses->hasPages())--}}
{{--                    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">--}}
{{--                        <div class="text-muted small">--}}
{{--                            Showing <strong>{{ $courses->firstItem() }}</strong>--}}
{{--                            to <strong>{{ $courses->lastItem() }}</strong>--}}
{{--                            of <strong>{{ $courses->total() }}</strong> courses--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            {{ $courses->links('pagination::bootstrap-5') }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}


{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#coursesTable').DataTable({--}}
{{--                paging: false,      // disable DataTables pagination--}}
{{--                info: false,        // hide "showing x of y"--}}
{{--                responsive: true,--}}
{{--                order: [[1, 'asc']],--}}
{{--                language: { search: "_INPUT_", searchPlaceholder: "Search courses..." },--}}
{{--                columnDefs: [--}}
{{--                    { targets: [0, 6], orderable: false, searchable: false },--}}
{{--                    { targets: '_all', className: 'align-middle' }--}}
{{--                ]--}}
{{--            });--}}

{{--            $('[data-bs-toggle="tooltip"]').tooltip();--}}
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
                    <table id="coursesTable" class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Campus</th>
                            <th>Category</th>
                            <th>Code</th>
                            <th>Mode</th>
                            <th>Duration</th>
                            <th>Req</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($courses as $index => $course)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td><strong>{{ $course->course_name }}</strong></td>

                                <td>{{ $course->college->name }}</td>

                                <td>
                                <span class="badge
                                    @if($course->course_category == 'Diploma') bg-primary
                                    @elseif($course->course_category == 'Craft') bg-success
                                    @elseif($course->course_category == 'Higher Diploma') bg-warning text-dark
                                    @else bg-info text-dark @endif">
                                    {{ $course->course_category }}
                                </span>
                                </td>

                                <td>
                                    <code class="bg-light px-2 py-1 rounded">
                                        {{ $course->course_code }}
                                    </code>
                                </td>

                                <td>
                                <span class="badge {{ $course->course_mode == 'Long Term' ? 'bg-dark' : 'bg-secondary' }}">
                                    {{ $course->course_mode }}
                                </span>
                                </td>

                                <td class="text-center">
                                <span class="fw-bold text-primary">
                                    {{ $course->course_duration }} months
                                </span>
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
                                            <button class="btn btn-outline-danger">
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

    {{-- jQuery (REQUIRED for DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#coursesTable').DataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                searching: true,
                order: [[1, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search courses..."
                },
                columnDefs: [
                    { targets: [0, 8], orderable: false, searchable: false }
                ]
            });

        });
    </script>

@endsection

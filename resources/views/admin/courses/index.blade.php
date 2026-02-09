
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

{{--        table.dataTable tbody td {--}}
{{--            vertical-align: middle;--}}
{{--            white-space: nowrap;--}}
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
{{--                    <table id="coursesTable"--}}
{{--                           class="table table-striped table-hover align-middle w-100">--}}

{{--                        <thead class="table-dark">--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>Course Name</th>--}}
{{--                            <th>Code</th>--}}
{{--                            <th>Category</th>--}}
{{--                            <th>Mode</th>--}}
{{--                            <th>Duration (Months)</th>--}}
{{--                            <th>Duration (Years)</th>--}}
{{--                            <th>Fee</th>--}}
{{--                            <th>Campus</th>--}}
{{--                            <th>Department</th>--}}
{{--                            <th>Academic Dept</th>--}}
{{--                            <th>Req</th>--}}
{{--                            <th>Half Board</th>--}}
{{--                            <th>Full Board</th>--}}
{{--                            <th>Hostel</th>--}}
{{--                            <th class="text-center">Actions</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}

{{--                        <tbody>--}}
{{--                        @foreach($courses as $index => $course)--}}
{{--                            <tr>--}}

{{--                                <td>{{ $index + 1 }}</td>--}}

{{--                                <td>--}}
{{--                                    <strong>{{ $course->course_name }}</strong>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    <code class="bg-light px-2 py-1 rounded">--}}
{{--                                        {{ $course->course_code }}--}}
{{--                                    </code>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                <span class="badge--}}
{{--                                    @if($course->course_category === 'Diploma') bg-primary--}}
{{--                                    @elseif($course->course_category === 'Craft') bg-success--}}
{{--                                    @elseif($course->course_category === 'Higher Diploma') bg-warning text-dark--}}
{{--                                    @elseif($course->course_category === 'Proficiency') bg-info text-dark--}}
{{--                                    @else bg-secondary @endif">--}}
{{--                                    {{ $course->course_category }}--}}
{{--                                </span>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                <span class="badge {{ $course->course_mode === 'Long Term' ? 'bg-dark' : 'bg-secondary' }}">--}}
{{--                                    {{ $course->course_mode }}--}}
{{--                                </span>--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                    {{ $course->course_duration }}--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                    {{ $course->duration_years }}--}}
{{--                                </td>--}}

{{--                                <td class="text-end fw-bold text-success">--}}
{{--                                    {{ number_format($course->cost, 2) }}--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    {{ $course->college->name ?? '—' }}--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    {{ $course->department->name ?? '—' }}--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    {{ $course->academicDepartment->name ?? '—' }}--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--                                <span class="badge {{ $course->requirement ? 'bg-success' : 'bg-secondary' }}">--}}
{{--                                    {{ $course->requirement ? 'Yes' : 'No' }}--}}
{{--                                </span>--}}
{{--                                </td>--}}
{{--                                <td class="text-end">--}}
{{--                                    {{ number_format($course->half_board_fee ?? 0, 2) }}--}}
{{--                                </td>--}}

{{--                                <td class="text-end">--}}
{{--                                    {{ number_format($course->full_board_fee ?? 0, 2) }}--}}
{{--                                </td>--}}

{{--                                <td class="text-center">--}}
{{--    <span class="badge {{ $course->is_hostel_booking_active ? 'bg-success' : 'bg-secondary' }}">--}}
{{--        {{ $course->is_hostel_booking_active ? 'Active' : 'Inactive' }}--}}
{{--    </span>--}}
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
{{--                                        <button--}}
{{--                                            class="btn btn-outline-primary"--}}
{{--                                            data-bs-toggle="modal"--}}
{{--                                            data-bs-target="#hostelModal{{ $course->id }}"--}}
{{--                                            title="Hostel Settings">--}}
{{--                                            <i class="fas fa-bed"></i>--}}
{{--                                        </button>--}}

{{--                                        <form action="{{ route('courses.delete', $course) }}"--}}
{{--                                              method="POST" class="d-inline">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button class="btn btn-outline-danger"--}}
{{--                                                    onclick="return confirm('Delete this course?')">--}}
{{--                                                <i class="fas fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                        @endrole--}}

{{--                                    </div>--}}
{{--                                </td>--}}

{{--                            </tr>--}}
{{--                            <div class="modal fade" id="hostelModal{{ $course->id }}" tabindex="-1">--}}
{{--                                <div class="modal-dialog">--}}
{{--                                    <form method="POST"--}}
{{--                                          action="{{ route('courses.hostel.update', $course) }}"--}}
{{--                                          class="modal-content">--}}
{{--                                        @csrf--}}

{{--                                        <div class="modal-header">--}}
{{--                                            <h5 class="modal-title">--}}
{{--                                                Hostel Settings – {{ $course->course_code }}--}}
{{--                                            </h5>--}}
{{--                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>--}}
{{--                                        </div>--}}

{{--                                        <div class="modal-body">--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="form-label">Half Board Fee (KES)</label>--}}
{{--                                                <input type="number"--}}
{{--                                                       name="half_board_fee"--}}
{{--                                                       class="form-control"--}}
{{--                                                       value="{{ $course->half_board_fee }}"--}}
{{--                                                       required>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="form-label">Full Board Fee (KES)</label>--}}
{{--                                                <input type="number"--}}
{{--                                                       name="full_board_fee"--}}
{{--                                                       class="form-control"--}}
{{--                                                       value="{{ $course->full_board_fee }}"--}}
{{--                                                       required>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input"--}}
{{--                                                       type="checkbox"--}}
{{--                                                       name="is_hostel_booking_active"--}}
{{--                                                       value="1"--}}
{{--                                                       id="hostelActive{{ $course->id }}"--}}
{{--                                                    {{ $course->is_hostel_booking_active ? 'checked' : '' }}>--}}
{{--                                                <label class="form-check-label" for="hostelActive{{ $course->id }}">--}}
{{--                                                    Enable Hostel Booking for this Course--}}
{{--                                                </label>--}}
{{--                                            </div>--}}

{{--                                            --}}{{-- hidden fallback for unchecked --}}
{{--                                            <input type="hidden" name="is_hostel_booking_active" value="0">--}}

{{--                                        </div>--}}

{{--                                        <div class="modal-footer">--}}
{{--                                            <button type="button"--}}
{{--                                                    class="btn btn-outline-secondary"--}}
{{--                                                    data-bs-dismiss="modal">--}}
{{--                                                Cancel--}}
{{--                                            </button>--}}

{{--                                            <button type="submit" class="btn btn-primary">--}}
{{--                                                Save Hostel Settings--}}
{{--                                            </button>--}}
{{--                                        </div>--}}

{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}

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

{{--    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>--}}

{{--    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>--}}

{{--    <script>--}}
{{--        $(document).ready(function () {--}}

{{--            $('#coursesTable').DataTable({--}}
{{--                scrollX: true,--}}
{{--                autoWidth: false,--}}
{{--                responsive: false,--}}

{{--                pageLength: 50,--}}
{{--                lengthMenu: [10, 25, 50, 100],--}}
{{--                ordering: true,--}}
{{--                searching: true,--}}
{{--                order: [[1, 'asc']],--}}

{{--                language: {--}}
{{--                    search: "_INPUT_",--}}
{{--                    searchPlaceholder: "Search courses..."--}}
{{--                },--}}

{{--                // columnDefs: [--}}
{{--                //     { targets: [0, 12], orderable: false, searchable: false }--}}
{{--                // ]--}}
{{--                columnDefs: [--}}
{{--                    { targets: [0, 13], orderable: false, searchable: false }--}}
{{--                ]--}}

{{--            });--}}


{{--        });--}}
{{--    </script>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')

    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
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

        {{-- Flash --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="coursesTable" class="table table-striped table-hover w-100">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Code</th>
                            <th>Mode</th>
                            <th>Campus</th>
                            <th>Half Board</th>
                            <th>Full Board</th>
                            <th>Hostel</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($courses as $i => $course)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td>
                                    <strong>{{ $course->course_name }}</strong>
                                </td>

                                <td>
                                    <code>{{ $course->course_code }}</code>
                                </td>

                                <td>
                                <span class="badge {{ $course->course_mode === 'Long Term' ? 'bg-dark' : 'bg-secondary' }}">
                                    {{ $course->course_mode }}
                                </span>
                                </td>

                                <td>{{ $course->college->name ?? '—' }}</td>

                                <td class="text-end">
                                    {{ number_format($course->half_board_fee ?? 0, 2) }}
                                </td>

                                <td class="text-end">
                                    {{ number_format($course->full_board_fee ?? 0, 2) }}
                                </td>

                                <td class="text-center">
                                <span class="badge {{ $course->is_hostel_booking_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $course->is_hostel_booking_active ? 'Active' : 'Inactive' }}
                                </span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">

                                        <a href="{{ route('courses.show', $course) }}"
                                           class="btn btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @role('superadmin')
                                        <button
                                            class="btn btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#hostelModal"
                                            data-id="{{ $course->id }}"
                                            data-name="{{ $course->course_name }}"
                                            data-half="{{ $course->half_board_fee }}"
                                            data-full="{{ $course->full_board_fee }}"
                                            data-active="{{ $course->is_hostel_booking_active ? 1 : 0 }}"
                                            title="Hostel Settings">
                                            <i class="fas fa-bed"></i>
                                        </button>
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

    {{-- ========================= --}}
    {{-- HOSTEL SETTINGS MODAL --}}
    {{-- ========================= --}}
    <div class="modal fade" id="hostelModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" id="hostelForm" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-bed me-2"></i>
                        Hostel Settings
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <p class="text-muted mb-2">
                        Course: <strong id="modalCourseName"></strong>
                    </p>

                    <div class="mb-3">
                        <label class="form-label">Half Board Fee (KES)</label>
                        <input type="number" class="form-control"
                               id="halfBoardInput"
                               name="half_board_fee" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Board Fee (KES)</label>
                        <input type="number" class="form-control"
                               id="fullBoardInput"
                               name="full_board_fee" required>
                    </div>

                    {{-- hidden fallback MUST come first --}}
                    <input type="hidden" name="is_hostel_booking_active" value="0">

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               id="hostelActiveInput"
                               name="is_hostel_booking_active"
                               value="1">
                        <label class="form-check-label">
                            Enable Hostel Booking
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-primary">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- SCRIPTS --}}
    {{-- ========================= --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function () {
            $('#coursesTable').DataTable({
                pageLength: 50,
                order: [[1, 'asc']],
                columnDefs: [{ targets: [0, 8], orderable: false }]
            });
        });

        const hostelModal = document.getElementById('hostelModal');

        hostelModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;

            const id     = btn.dataset.id;
            const name   = btn.dataset.name;
            const half   = btn.dataset.half ?? 0;
            const full   = btn.dataset.full ?? 0;
            const active = btn.dataset.active == 1;

            document.getElementById('modalCourseName').innerText = name;
            document.getElementById('halfBoardInput').value = half;
            document.getElementById('fullBoardInput').value = full;
            document.getElementById('hostelActiveInput').checked = active;

            document.getElementById('hostelForm').action =
                `/courses/${id}/hostel-settings`;
        });
    </script>

@endsection

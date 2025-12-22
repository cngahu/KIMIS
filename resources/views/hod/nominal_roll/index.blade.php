@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="mb-4">
            <h4 class="fw-bold">Nominal Roll</h4>
            <p class="text-muted mb-0">
                {{ $course->course_name }} — {{ $cohort }}
            </p>
        </div>

        <div class="card radius-10 shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        Registered Students
                    </h6>

                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            Export PDF
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            Export Excel
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Admission No</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>ID No</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Stage</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($roll as $row)
                            <tr>
                                <td>{{ $row['sn'] }}</td>
                                <td>{{ $row['admission_no'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['gender'] }}</td>
                                <td>{{ $row['id_number'] }}</td>
                                <td>{{ $row['phone'] }}</td>
                                <td>{{ $row['email'] }}</td>
                                <td>{{ $row['stage'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No confirmed registrations for this cohort.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection

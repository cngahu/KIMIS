@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="mb-4">
            <h4 class="fw-bold">HOD Dashboard</h4>
            <p class="text-muted mb-0">
                Academic overview by course and cohort
            </p>
        </div>

        <div class="card radius-10 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                        <tr>
                            <th>Department</th>
                            <th>Course</th>
                            <th>Cohort</th>
                            <th class="text-end">Expected</th>
                            <th class="text-end">Registered</th>
                            <th class="text-end">Pending</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($dashboardData as $row)
                            <tr>
                                <td>{{ $row['department'] }}</td>
                                <td><strong>{{ $row['course'] }}</strong></td>
                                <td>{{ $row['cohort'] }}</td>

                                <td class="text-end">
                                    {{ number_format($row['expected']) }}
                                </td>

                                <td class="text-end fw-bold text-success">
                                    {{ number_format($row['registered']) }}
                                </td>

                                <td class="text-end text-danger">
                                    {{ number_format($row['pending']) }}
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('hod.nominal.roll', [$row['course_id'], $row['cohort']]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View Nominal Roll
                                    </a>

                                    <a href="{{ route('hod.quality.check', [$row['course_id'], $row['cohort']]) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Quality Check
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No data available for your departments.
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

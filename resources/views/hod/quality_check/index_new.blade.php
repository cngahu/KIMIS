@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-1">Quality Check</h4>
        <p class="text-muted mb-3">
            {{ $course->course_name }} — {{ $cohort }}
        </p>

        <div class="card radius-10 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Admission No</th>
                            <th>Name</th>
                            <th>Source</th>
                            <th class="text-center">Activated</th>
                            <th class="text-center">Registered</th>
                            <th>Notes</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td>
                                    <strong>{{ $row['admission_no'] }}</strong>
                                </td>

                                <td>{{ $row['name'] }}</td>

                                <td>
                                <span class="badge
                                    {{ $row['source'] === 'Masterdata' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $row['source'] }}
                                </span>
                                </td>

                                <td class="text-center">
                                    @if($row['activated'])
                                        <i class="bx bx-check text-success fs-5"></i>
                                    @else
                                        <i class="bx bx-x text-danger fs-5"></i>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($row['registered'])
                                        <i class="bx bx-check text-success fs-5"></i>
                                    @else
                                        <i class="bx bx-x text-danger fs-5"></i>
                                    @endif
                                </td>

                                <td class="text-muted">
                                    {{ $row['notes'] ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection

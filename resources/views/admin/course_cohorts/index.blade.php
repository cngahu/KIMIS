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

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
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
                    @foreach($cohorts as $cohort)
                        <tr>
                            <td>{{ $cohorts->firstItem() + $loop->index }}</td>
                            <td>
                                <strong>{{ $cohort->course->course_name }}</strong><br>
                                <small class="text-muted">{{ $cohort->course->course_code }}</small>
                            </td>
                            <td>{{ $cohort->course->college->name }}</td>
                            <td>
                            <span class="badge bg-info">
                                {{ \Carbon\Carbon::create($cohort->intake_year, $cohort->intake_month)->format('M Y') }}
                            </span>
                            </td>
                            <td>
                            <span class="badge bg-{{ $cohort->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($cohort->status) }}
                            </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">

                                    {{-- View Cohort --}}
                                    <a href="{{ route('course_cohorts.show', $cohort) }}"
                                       class="btn btn-outline-info"
                                       title="View Intake">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- View Timeline --}}
                                    <a href="{{ route('cohort_timelines.index', $cohort) }}"
                                       class="btn btn-outline-primary"
                                       title="View Timeline">
                                        <i class="fas fa-stream"></i>
                                    </a>
                                    <a href="{{ route('timeline.cohort', $cohort) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-project-diagram"></i> Horizontal Timeline
                                    </a>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $cohorts->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection

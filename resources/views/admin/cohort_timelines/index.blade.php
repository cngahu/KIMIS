@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h5>
                {{ $cohort->course->course_name }}
                <small class="text-muted">
                    ({{ \Carbon\Carbon::create($cohort->intake_year, $cohort->intake_month)->format('M Y') }})
                </small>
            </h5>

            <a href="{{ route('cohort_timelines.create', $cohort) }}"
               class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Stage
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Stage</th>
                        <th>Period</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($overview as $row)
                        <tr>
                            <td>{{ $row['timeline']->sequence_number }}</td>
                            <td>
                                <strong>{{ $row['timeline']->stage->code }}</strong><br>
                                <small>{{ $row['timeline']->stage->name }}</small>
                            </td>
                            <td>
                                {{ $row['timeline']->start_date->format('d M Y') }}
                                –
                                {{ $row['timeline']->end_date->format('d M Y') }}
                            </td>
                            <td>
                                @if($row['status'] === 'current')
                                    <span class="badge bg-success">Current</span>
                                @elseif($row['status'] === 'completed')
                                    <span class="badge bg-secondary">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Upcoming</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

@endsection

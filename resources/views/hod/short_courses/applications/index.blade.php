@extends('admin.admin_dashboard')

@section('admin')

    <h4 class="fw-bold mb-3">
        Class List – {{ $training->course->course_name }}
    </h4>

    <div class="card radius-10">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Financier</th>
                    <th>Participants</th>
                    <th>Employer</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
                </thead>
                <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td>{{ $app->reference }}</td>
                        <td>{{ ucfirst($app->financier) }}</td>
                        <td>{{ $app->total_participants }}</td>
                        <td>{{ $app->employer_name ?? '—' }}</td>
                        <td>
                        <span class="badge bg-secondary">
                            {{ $app->status }}
                        </span>
                        </td>
                        <td>
                        <span class="badge {{ $app->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $app->payment_status }}
                        </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

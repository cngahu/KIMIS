@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Received Applications</h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>Applicant</th>
                        <th>Course</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Reviewer</th>
                        <th>Assign</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($apps as $app)
                        <tr>
                            <td>{{ $app->reference }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->course->name }}</td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>

                            <td>
                                <span class="badge bg-info">{{ ucfirst($app->status) }}</span>
                            </td>

                            <td>
                                {{ $app->reviewer ? $app->reviewer->name : 'Unassigned' }}
                            </td>

                            <td>
                                <form action="{{ route('registrar.assign', $app->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex">
                                        <select name="reviewer_id" class="form-select form-select-sm" required>
                                            <option value="">Select Officer</option>
                                            @foreach($officers as $off)
                                                <option value="{{ $off->id }}">{{ $off->name }}</option>
                                            @endforeach
                                        </select>

                                        <button class="btn btn-primary btn-sm ms-2">Assign</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

                <div class="mt-3">
                    {{ $apps->links() }}
                </div>

            </div>
        </div>

    </div>

@endsection

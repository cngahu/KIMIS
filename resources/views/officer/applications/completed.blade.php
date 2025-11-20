@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <h4 class="mb-3">Completed Reviews</h4>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Applicant</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($apps as $app)
                        <tr>
                            <td>{{ $app->reference }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->course->course_name }}</td>

                            <td>
                            <span class="badge bg-{{ $app->status == 'approved' ? 'success' : 'danger' }}">
                                {{ ucfirst($app->status) }}
                            </span>
                            </td>

                            <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>

                            <td>
                                <button class="btn btn-secondary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewApplicationModal"
                                        onclick="loadApplication({{ $app->id }})">
                                    View
                                </button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $apps->links() }}

            </div>
        </div>
    </div>

    @include('admin.registrar.applications.modal')

@endsection

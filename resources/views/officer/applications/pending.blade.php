@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <h4 class="mb-3">Applications Pending Review</h4>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Applicant</th>
                        <th>Course</th>
                        <th>Assigned</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($apps as $app)
                        <tr>
                            <td>{{ $app->reference }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->course->course_name }}</td>
                            <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>

                            <td>
                                <a href="{{ route('officer.applications.review', $app->id) }}"
                                   class="btn btn-primary btn-sm">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $apps->links() }}

            </div>
        </div>
    </div>

@endsection

@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        <h4 class="fw-bold mb-3">Document Verification</h4>

        <div class="card">
            <div class="card-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Date Applied</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($students as $s)
                        <tr>
                            <td>{{ $s->application->full_name }}</td>
                            <td>{{ $s->application->course->course_name }}</td>
                            <td>
                                <span class="badge bg-info">{{ $s->status }}</span>
                            </td>
                            <td>{{ $s->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('registrar.verification.show', $s->id) }}"
                                   class="btn btn-sm btn-primary">Verify</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

                <div>{!! $students->links() !!}</div>
            </div>
        </div>

    </div>

@endsection

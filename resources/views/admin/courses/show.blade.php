@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <h1>Course Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">{{ $course->course_name }}</h3>
                <p><strong>Category:</strong> {{ $course->course_category }}</p>
                <p><strong>Code:</strong> {{ $course->course_code }}</p>
                <p><strong>Mode:</strong> {{ $course->course_mode }}</p>
                <p><strong>Duration:</strong> {{ $course->course_duration }} months</p>
                <p><strong>User ID:</strong> {{ $course->user_id ?? '-' }}</p>
            </div>
        </div>

        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('all.courses') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection

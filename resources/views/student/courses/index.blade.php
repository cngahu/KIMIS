@extends('student.student_dashboard')

@section('student')
<div class="page-content">
    <h4>My Courses</h4>
    <ul>
        @forelse($courses as $course)
            <li>{{ $course->course_name }}</li>
        @empty
            <li>No courses assigned.</li>
        @endforelse
    </ul>
</div>
@endsection
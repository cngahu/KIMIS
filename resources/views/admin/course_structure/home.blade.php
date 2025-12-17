@extends('admin.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <h5 class="mb-3">Course Structure (Stage Mapping)</h5>

        <table class="table table-hover">
            <thead class="table-dark">
            <tr>
                <th>Course</th>
                <th>Code</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->course_name }}</td>
                    <td><code>{{ $course->course_code }}</code></td>
                    <td class="text-center">
                        <a href="{{ route('course_structure.index', $course) }}"
                           class="btn btn-sm btn-outline-primary">
                            Define Structure
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection

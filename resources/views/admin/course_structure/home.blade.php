
@extends('admin.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <h5 class="mb-3">Course Structure (Stage Mapping)</h5>

        <div class="card radius-10 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <table
                            class="table table-hover table-striped datatable"
                            data-order='[[1,"asc"]]'
                            data-search-placeholder="Search course, college or intake..."
                            data-column-defs='[
                    { "targets": [0,5], "orderable": false, "searchable": false }
                ]'
                        >
                        <thead class="table-dark">
                        <tr>
                            <th>Course</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($courses as $course)

                            <tr>
                                <td>
                                    <strong>{{ $course->course_name }}</strong>
                                </td>

                                <td>
                                    <code>{{ $course->course_code }}</code>
                                </td>

                                <td>
                                    @if($course->stage_mappings_count > 0)
                                        <span class="badge bg-success">
                                        Structure Defined ({{ $course->stage_mappings_count }})
                                    </span>
                                    @else
                                        <span class="badge bg-danger">
                                        Not Defined
                                    </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($course->stage_mappings_count > 0)

                                        <a href="{{ route('course_structure.index', $course) }}"
                                           class="btn btn-sm btn-outline-warning">
                                            Modify / View
                                        </a>

                                    @else

                                        <a href="{{ route('course_structure.index', $course) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Define Structure
                                        </a>

                                    @endif
                                </td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection

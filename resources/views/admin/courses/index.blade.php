@extends('admin.admin_dashboard')

@section('admin')
    <style>
        .icon-brown {
            color: #6B3A0E !important;
        }
    </style>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="mb-0">Courses</h1>

            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('all.courses') }}" method="GET" class="d-flex">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-sm me-2"
                        placeholder="Search by name, code, category..."
                        value="{{ request('search') }}"
                    >
                    <button class="btn btn-sm btn-outline-secondary me-1" type="submit">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('all.courses') }}" class="btn btn-sm btn-outline-light border">
                            Clear
                        </a>
                    @endif
                </form>

                <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                    Add Course
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($courses->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Code</th>
                        <th>Mode</th>
                        <th>Duration (months)</th>
                        <th style="width: 200px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $courses->firstItem() + $loop->index }}</td>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ $course->course_category }}</td>
                            <td>{{ $course->course_code }}</td>
                            <td>{{ $course->course_mode }}</td>
                            <td>{{ $course->course_duration }}</td>
                            <td class="text-center">

                                <a href="{{ route('courses.show', $course) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="View Course">
                                    <i class="fa-solid fa-eye icon-brown"></i>
                                </a>

                                <a href="{{ route('courses.edit', $course) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit Course">
                                    <i class="fa-solid fa-pen-to-square icon-brown"></i>
                                </a>

                                <form action="{{ route('courses.delete', $course) }}"
                                      method="POST"
                                      class="d-inline js-confirm-form"
                                      data-confirm-title="Delete this course?"
                                      data-confirm-text="This will permanently delete {{ $course->course_name }}."
                                      data-confirm-icon="warning"
                                      data-confirm-button="Yes, delete it"
                                      data-cancel-button="No, keep it">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete Course">
                                        <i class="fa-solid fa-trash icon-brown"></i>
                                    </button>
                                </form>

                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="text-muted small">
                    Showing
                    <strong>{{ $courses->firstItem() }}</strong>
                    to
                    <strong>{{ $courses->lastItem() }}</strong>
                    of
                    <strong>{{ $courses->total() }}</strong>
                    results
                    @if(request('search'))
                        for "<strong>{{ request('search') }}</strong>"
                    @endif
                </div>
                <div>
                    {{ $courses->links() }}
                </div>
            </div>
        @else
            <div class="alert alert-info">
                @if(request('search'))
                    No courses found for "<strong>{{ request('search') }}</strong>".
                    <a href="{{ route('all.courses') }}">Clear search</a>
                @else
                    No courses found.
                @endif
            </div>
        @endif
    </div>
@endsection

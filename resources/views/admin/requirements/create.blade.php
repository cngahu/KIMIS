@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">

        {{-- Heading --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Add Course Requirements</h1>
                <p class="text-muted mb-0">
                    Course: <strong>{{ $course->course_name }}</strong>
                    ({{ $course->course_code }})
                </p>
            </div>

            <a href="{{ route('all.courses') }}" class="btn btn-light border">
                Back to Courses
            </a>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        {{-- Requirement form --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="mb-1">Entry Requirements</h5>
                <p class="text-muted small mb-0">
                    Specify the entry requirements for this course (e.g. minimum grades, prior qualifications, work experience).
                </p>
            </div>

            <form action="{{ route('courses.requirements.store', $course) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Requirement Details <span class="text-danger">*</span></label>
                        <textarea
                            name="course_requirement"
                            rows="5"
                            class="form-control @error('course_requirement') is-invalid @enderror"
                            placeholder="e.g. KCSE Mean Grade C-, at least C- in Mathematics and English, or equivalent; Diploma holders in related fields may also apply..."
                        >{{ old('course_requirement') }}</textarea>
                        @error('course_requirement')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <small class="text-muted">You can describe all the requirements in a paragraph or bullet format.</small>
                            @enderror
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        After saving, you will be redirected back to the course list.
                    </span>
                    <div>
                        <a href="{{ route('all.courses') }}" class="btn btn-light border me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Save Requirement
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Optional: show existing requirements for this course --}}
        @if($requirements->count())
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-1">Existing Requirements</h5>
                    <p class="text-muted small mb-0">These are already stored for this course.</p>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($requirements as $req)
                            <li class="list-group-item">
                                {!! nl2br(e($req->course_requirement)) !!}
                                <div class="small text-muted mt-1">
                                    Added on {{ $req->created_at->format('d M Y H:i') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </div>
@endsection

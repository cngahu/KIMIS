@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">

        {{-- Page header --}}
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

        {{-- Requirement Form --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="mb-1">Entry Requirements</h5>
                <p class="text-muted small mb-0">
                    Choose whether to enter requirements as text or upload a document.
                </p>
            </div>

            <form action="{{ route('courses.requirements.store', $course) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row g-3">

                        {{-- Type --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Requirement Type <span class="text-danger">*</span></label>
                            <select
                                name="type"
                                id="reqType"
                                class="form-select @error('type') is-invalid @enderror">
                                <option value="text" {{ old('type', 'text') === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="upload" {{ old('type') === 'upload' ? 'selected' : '' }}>Upload Document</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <small class="text-muted">Select how you want to provide the requirement.</small>
                                @enderror
                        </div>

                        {{-- Text requirement --}}
                        <div class="col-md-12" id="textRequirementWrapper">
                            <label class="form-label fw-bold">Requirement Details <span class="text-danger">*</span></label>
                            <textarea
                                name="course_requirement"
                                rows="5"
                                class="form-control @error('course_requirement') is-invalid @enderror"
                                placeholder="e.g. KCSE Mean Grade C-, at least C- in Mathematics and English, or equivalent..."
                            >{{ old('course_requirement') }}</textarea>
                            @error('course_requirement')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <small class="text-muted">
                                    You can describe the entry requirements in a paragraph or bullet form.
                                </small>
                                @enderror
                        </div>

                        {{-- File upload --}}
                        <div class="col-md-12 d-none" id="fileRequirementWrapper">
                            <label class="form-label fw-bold">Upload Requirement Document <span class="text-danger">*</span></label>
                            <input
                                type="file"
                                name="file"
                                class="form-control @error('file') is-invalid @enderror"
                            >
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <small class="text-muted">
                                    Allowed types: PDF, DOC, DOCX, JPG, PNG (max 5MB).
                                </small>
                                @enderror
                        </div>
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

        {{-- Existing Requirements --}}
        @if($requirements->count())
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-1">Existing Requirements</h5>
                    <p class="text-muted small mb-0">These are already stored for this course.</p>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($requirements as $req)
                            <li class="list-group-item">
                                @if($req->type === 'text')
                                    {!! nl2br(e($req->course_requirement)) !!}
                                @else
                                    <strong>Uploaded Document:</strong>
                                    @if($req->file_path)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($req->file_path) }}"
                                           target="_blank">
                                            View / Download
                                        </a>
                                    @else
                                        <span class="text-muted">No file path stored.</span>
                                    @endif
                                @endif
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

    {{-- Inline script so it always runs --}}
    <script>
        (function() {
            const typeSelect   = document.getElementById('reqType');
            const textWrapper  = document.getElementById('textRequirementWrapper');
            const fileWrapper  = document.getElementById('fileRequirementWrapper');

            function toggleRequirementFields() {
                if (!typeSelect) return;
                const value = typeSelect.value;

                if (value === 'text') {
                    textWrapper.classList.remove('d-none');
                    fileWrapper.classList.add('d-none');
                } else {
                    textWrapper.classList.add('d-none');
                    fileWrapper.classList.remove('d-none');
                }
            }

            // Bind change event
            if (typeSelect) {
                typeSelect.addEventListener('change', toggleRequirementFields);
            }

            // Initialize state on page load (respect old() value)
            toggleRequirementFields();
        })();
    </script>
@endsection

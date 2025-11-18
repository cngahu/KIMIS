@csrf

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white border-0 pb-0">
        <h5 class="mb-1">Course Details</h5>
        <p class="text-muted small mb-0">
            Fill in the information below to create or update a course.
        </p>
    </div>

    <div class="card-body">
        <div class="row g-3">

            {{-- Course Name --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Course Name <span class="text-danger">*</span></label>
                <input
                    type="text"
                    name="course_name"
                    class="form-control @error('course_name') is-invalid @enderror"
                    placeholder="e.g. Diploma in ICT"
                    value="{{ old('course_name', $course->course_name ?? '') }}"
                >
                @error('course_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Enter the official name of the course.</small>
                    @enderror
            </div>

            {{-- Category --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Course Category <span class="text-danger">*</span></label>
                <select
                    name="course_category"
                    class="form-select @error('course_category') is-invalid @enderror"
                >
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}"
                            {{ old('course_category', $course->course_category ?? '') === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
                @error('course_category')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Choose the appropriate course level or type.</small>
                    @enderror
            </div>

            {{-- Course Code --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Course Code <span class="text-danger">*</span></label>
                <input
                    type="text"
                    name="course_code"
                    class="form-control @error('course_code') is-invalid @enderror"
                    placeholder="e.g. ICT101"
                    value="{{ old('course_code', $course->course_code ?? '') }}"
                >
                @error('course_code')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Unique identifier used internally and on timetables.</small>
                    @enderror
            </div>

            {{-- Mode --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Course Mode <span class="text-danger">*</span></label>
                <select
                    name="course_mode"
                    class="form-select @error('course_mode') is-invalid @enderror"
                >
                    <option value="">-- Select Mode --</option>
                    @foreach($modes as $mode)
                        <option value="{{ $mode }}"
                            {{ old('course_mode', $course->course_mode ?? '') === $mode ? 'selected' : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
                @error('course_mode')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Specify if the course is long-term or short-term.</small>
                    @enderror
            </div>

            {{-- Duration --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Duration (months) <span class="text-danger">*</span></label>
                <input
                    type="number"
                    name="course_duration"
                    class="form-control @error('course_duration') is-invalid @enderror"
                    min="1"
                    placeholder="e.g. 12"
                    value="{{ old('course_duration', $course->course_duration ?? '') }}"
                >
                @error('course_duration')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Total duration of the course in months.</small>
                    @enderror
            </div>

            {{-- Cost --}}
            <div class="col-md-3">
                <label class="form-label fw-bold">Cost (KSh)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="cost"
                    class="form-control @error('cost') is-invalid @enderror"
                    placeholder="e.g. 15000"
                    value="{{ old('cost', $course->cost ?? 0) }}"
                >
                @error('cost')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Total tuition cost (set 0 if not applicable yet).</small>
                    @enderror
            </div>

            {{-- Requirement (Yes / No) --}}
            <div class="col-md-3">
                <label class="form-label fw-bold">Requirement</label>
                <select
                    name="requirement"
                    class="form-select @error('requirement') is-invalid @enderror"
                >
                    @php
                        $requirementValue = old('requirement', $course->requirement ?? 1);
                    @endphp
                    <option value="1" {{ $requirementValue == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $requirementValue == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('requirement')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Is there a specific requirement to join this course?</small>
                    @enderror
            </div>

            {{-- Target Group --}}
            <div class="col-md-12">
                <label class="form-label fw-bold">Target Group</label>
                <textarea
                    name="target_group"
                    rows="2"
                    class="form-control @error('target_group') is-invalid @enderror"
                    placeholder="e.g. Form Four leavers, diploma holders, technicians in the construction sector..."
                >{{ old('target_group', $course->target_group ?? '') }}</textarea>
                @error('target_group')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Describe who this course is intended for.</small>
                    @enderror
            </div>

        </div>
    </div>

    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
        <span class="text-muted small">
            <span class="text-danger">*</span> Required fields
        </span>
        <div>
            <a href="{{ route('all.courses') }}" class="btn btn-light border me-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                {{ $buttonText ?? 'Save' }}
            </button>
        </div>
    </div>
</div>

@csrf

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white border-0 pb-0">
        <h5 class="mb-1">Training Details</h5>
        <p class="text-muted small mb-0">
            Fill in the information below to create or update a training.
        </p>
    </div>

    <div class="card-body">
        <div class="row g-3">

            {{-- Course --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Course <span class="text-danger">*</span></label>
                <select
                    name="course_id"
                    class="form-select @error('course_id') is-invalid @enderror"
                >
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $courseItem)
                        <option value="{{ $courseItem->id }}"
                            {{ (int) old('course_id', $training->course_id ?? 0) === $courseItem->id ? 'selected' : '' }}>
                            {{ $courseItem->course_name }} ({{ $courseItem->course_code }})
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Select the course for this training.</small>
                    @enderror
            </div>

            {{-- College --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">College <span class="text-danger">*</span></label>
                <select
                    name="college_id"
                    class="form-select @error('college_id') is-invalid @enderror"
                >
                    <option value="">-- Select College --</option>
                    @foreach($colleges as $collegeItem)
                        <option value="{{ $collegeItem->id }}"
                            {{ (int) old('college_id', $training->college_id ?? 0) === $collegeItem->id ? 'selected' : '' }}>
                            {{ $collegeItem->name }}
                        </option>
                    @endforeach
                </select>
                @error('college_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Select the college offering this training.</small>
                    @enderror
            </div>

            {{-- Start date --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                <input
                    type="date"
                    name="start_date"
                    class="form-control @error('start_date') is-invalid @enderror"
                    value="{{ old('start_date', isset($training->start_date) ? $training->start_date->format('Y-m-d') : '') }}"
                >
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">When the training is scheduled to start.</small>
                    @enderror
            </div>

            {{-- End date --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">End Date</label>
                <input
                    type="date"
                    name="end_date"
                    class="form-control @error('end_date') is-invalid @enderror"
                    value="{{ old('end_date', isset($training->end_date) ? $training->end_date->format('Y-m-d') : '') }}"
                >
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">When the training is expected to end.</small>
                    @enderror
            </div>

            {{-- Cost --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">Cost (KES) <span class="text-danger">*</span></label>
                <input
                    type="number"
                    step="0.01"
                    name="cost"
                    class="form-control @error('cost') is-invalid @enderror"
                    value="{{ old('cost', $training->cost ?? '') }}"
                    required
                >
                @error('cost')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Enter the cost for this training (KES).</small>
                    @enderror
            </div>

        </div>
    </div>

    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
        <span class="text-muted small">
            <span class="text-danger">*</span> Required fields
        </span>
        <div>
            <a href="{{ route('all.trainings') }}" class="btn btn-light border me-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                {{ $buttonText ?? 'Save' }}
            </button>
        </div>
    </div>
</div>

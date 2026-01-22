{{--@csrf--}}

{{--<div class="card shadow-sm border-0 mb-3">--}}
{{--    <div class="card-header bg-white border-0 pb-0">--}}
{{--        <h5 class="mb-1">Training Details</h5>--}}
{{--        <p class="text-muted small mb-0">--}}
{{--            Fill in the information below to create or update a training.--}}
{{--        </p>--}}
{{--    </div>--}}

{{--    <div class="card-body">--}}
{{--        <div class="row g-3">--}}

{{--            --}}{{-- Course --}}
{{--            <div class="col-md-6">--}}
{{--                <label class="form-label fw-bold">--}}
{{--                    Course <span class="text-danger">*</span>--}}
{{--                </label>--}}
{{--                <select--}}
{{--                    name="course_id"--}}
{{--                    class="form-select @error('course_id') is-invalid @enderror"--}}
{{--                    required--}}
{{--                >--}}
{{--                    <option value="">-- Select Course --</option>--}}
{{--                    @foreach($courses as $courseItem)--}}
{{--                        <option value="{{ $courseItem->id }}"--}}
{{--                            {{ (int) old('course_id', $training->course_id ?? 0) === $courseItem->id ? 'selected' : '' }}>--}}
{{--                            {{ $courseItem->course_name }} ({{ $courseItem->course_code }})-{{$courseItem->college->name}}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @error('course_id')--}}
{{--                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                @else--}}
{{--                    <small class="text-muted">Select the course for this training.</small>--}}
{{--                    @enderror--}}
{{--            </div>--}}

{{--            --}}{{-- Cost --}}
{{--            <div class="col-md-6">--}}
{{--                <label class="form-label fw-bold">--}}
{{--                    Cost (KES) <span class="text-danger">*</span>--}}
{{--                </label>--}}
{{--                <input--}}
{{--                    type="number"--}}
{{--                    step="0.01"--}}
{{--                    name="cost"--}}
{{--                    class="form-control @error('cost') is-invalid @enderror"--}}
{{--                    value="{{ old('cost', $training->cost ?? '') }}"--}}
{{--                    min="0"--}}
{{--                    required--}}
{{--                >--}}
{{--                @error('cost')--}}
{{--                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                @else--}}
{{--                    <small class="text-muted">Enter the cost for this training.</small>--}}
{{--                    @enderror--}}
{{--            </div>--}}

{{--            --}}{{-- Start Date --}}
{{--            <div class="col-md-6">--}}
{{--                <label class="form-label fw-bold">--}}
{{--                    Start Date <span class="text-danger">*</span>--}}
{{--                </label>--}}
{{--                <input--}}
{{--                    type="date"--}}
{{--                    name="start_date"--}}
{{--                    id="start_date"--}}
{{--                    class="form-control @error('start_date') is-invalid @enderror"--}}
{{--                    value="{{ old('start_date', isset($training->start_date) ? $training->start_date->format('Y-m-d') : '') }}"--}}
{{--                    min="{{ now()->toDateString() }}"--}}
{{--                    required--}}
{{--                >--}}
{{--                @error('start_date')--}}
{{--                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                @else--}}
{{--                    <small class="text-muted">Training start date.</small>--}}
{{--                    @enderror--}}
{{--            </div>--}}

{{--            --}}{{-- End Date --}}
{{--            <div class="col-md-6">--}}
{{--                <label class="form-label fw-bold">--}}
{{--                    End Date--}}
{{--                </label>--}}
{{--                <input--}}
{{--                    type="date"--}}
{{--                    name="end_date"--}}
{{--                    id="end_date"--}}
{{--                    class="form-control @error('end_date') is-invalid @enderror"--}}
{{--                    value="{{ old('end_date', isset($training->end_date) ? $training->end_date->format('Y-m-d') : '') }}"--}}
{{--                    min="{{ old('start_date', isset($training->start_date) ? $training->start_date->format('Y-m-d') : now()->toDateString()) }}"--}}
{{--                >--}}
{{--                @error('end_date')--}}
{{--                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                @else--}}
{{--                    <small class="text-muted">Must be on or after the start date.</small>--}}
{{--                    @enderror--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">--}}
{{--        <span class="text-muted small">--}}
{{--            <span class="text-danger">*</span> Required fields--}}
{{--        </span>--}}
{{--        <div>--}}
{{--            <a href="{{ route('all.trainings') }}" class="btn btn-light border me-2">--}}
{{--                Cancel--}}
{{--            </a>--}}
{{--            <button type="submit" class="btn btn-primary">--}}
{{--                {{ $buttonText ?? 'Save' }}--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{-- Client-side enforcement: End Date >= Start Date --}}
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        const startDate = document.getElementById('start_date');--}}
{{--        const endDate   = document.getElementById('end_date');--}}

{{--        function syncEndDateMin() {--}}
{{--            if (startDate.value) {--}}
{{--                endDate.min = startDate.value;--}}

{{--                if (endDate.value && endDate.value < startDate.value) {--}}
{{--                    endDate.value = '';--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}

{{--        startDate.addEventListener('change', syncEndDateMin);--}}
{{--        syncEndDateMin();--}}
{{--    });--}}
{{--</script>--}}
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
                <label class="form-label fw-bold">
                    Course <span class="text-danger">*</span>
                </label>
                <select
                    name="course_id"
                    class="form-select @error('course_id') is-invalid @enderror"
                    required
                >
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $courseItem)
                        <option value="{{ $courseItem->id }}"
                            {{ (int) old('course_id', $training->course_id ?? 0) === $courseItem->id ? 'selected' : '' }}>
                            {{ $courseItem->course_name }}
                            ({{ $courseItem->course_code }})
                            - {{ optional($courseItem->college)->name ?? 'No College' }}
                        </option>
                    @endforeach
                </select>

                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Select the course for this training.</small>
                    @enderror
            </div>

            {{-- Cost --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    Cost (KES) <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    step="0.01"
                    name="cost"
                    class="form-control @error('cost') is-invalid @enderror"
                    value="{{ old('cost', $training->cost ?? '') }}"
                    min="0"
                    required
                >

                @error('cost')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Enter the cost for this training.</small>
                    @enderror
            </div>

            {{-- Start Date --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    Start Date <span class="text-danger">*</span>
                </label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    class="form-control @error('start_date') is-invalid @enderror"
                    value="{{ old('start_date', isset($training->start_date) ? $training->start_date->format('Y-m-d') : '') }}"
                    required
                >

                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Training start date.</small>
                    @enderror
            </div>

            {{-- End Date --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    End Date
                </label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    class="form-control @error('end_date') is-invalid @enderror"
                    value="{{ old('end_date', isset($training->end_date) ? $training->end_date->format('Y-m-d') : '') }}"
                >

                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Must be on or after the start date.</small>
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

{{-- Client-side enforcement: End Date >= Start Date --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDate = document.getElementById('start_date');
        const endDate   = document.getElementById('end_date');

        function syncEndDateMin() {
            if (startDate.value) {
                endDate.min = startDate.value;

                if (endDate.value && endDate.value < startDate.value) {
                    endDate.value = '';
                }
            } else {
                endDate.removeAttribute('min');
            }
        }

        startDate.addEventListener('change', syncEndDateMin);
        syncEndDateMin();
    });
</script>

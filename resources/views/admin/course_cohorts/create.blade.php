

{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}

{{--    <div class="container-fluid">--}}

{{--        --}}{{-- Page Header --}}
{{--        <div class="page-breadcrumb d-flex align-items-center mb-3">--}}
{{--            <div class="breadcrumb-title pe-3">Add Course Intake</div>--}}
{{--            <div class="ps-3">--}}
{{--                <nav aria-label="breadcrumb">--}}
{{--                    <ol class="breadcrumb mb-0 p-0">--}}
{{--                        <li class="breadcrumb-item">--}}
{{--                            <a href="{{ route('dashboard') }}">--}}
{{--                                <i class="bx bx-home-alt"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="breadcrumb-item">--}}
{{--                            <a href="{{ route('course_cohorts.index') }}">Course Intakes</a>--}}
{{--                        </li>--}}
{{--                        <li class="breadcrumb-item active">Create</li>--}}
{{--                    </ol>--}}
{{--                </nav>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card">--}}
{{--            <div class="card-body">--}}

{{--                <form method="POST" action="{{ route('course_cohorts.store') }}">--}}
{{--                    @csrf--}}

{{--                    <div class="row">--}}

{{--                        --}}{{-- Course (Select2) --}}
{{--                        <div class="col-md-6 mb-3">--}}
{{--                            <label class="form-label fw-bold">--}}
{{--                                Course <span class="text-danger">*</span>--}}
{{--                            </label>--}}

{{--                            <select name="course_id"--}}
{{--                                    id="course_id"--}}
{{--                                    class="form-select @error('course_id') is-invalid @enderror"--}}
{{--                                    required>--}}
{{--                                <option value="">Search & select course...</option>--}}
{{--                                @foreach($courses as $course)--}}
{{--                                    <option value="{{ $course->id }}"--}}
{{--                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>--}}
{{--                                        {{ $course->course_name }} ({{ $course->course_code }})--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}

{{--                            @error('course_id')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        --}}{{-- Intake Year --}}
{{--                        <div class="col-md-3 mb-3">--}}
{{--                            <label class="form-label fw-bold">Intake Year <span class="text-danger">*</span></label>--}}
{{--                            <input type="number"--}}
{{--                                   name="intake_year"--}}
{{--                                   class="form-control @error('intake_year') is-invalid @enderror"--}}
{{--                                   value="{{ old('intake_year', date('Y')) }}"--}}
{{--                                   required>--}}
{{--                            @error('intake_year')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        --}}{{-- Intake Month --}}
{{--                        <div class="col-md-3 mb-3">--}}
{{--                            <label class="form-label fw-bold">Intake Month <span class="text-danger">*</span></label>--}}
{{--                            <select name="intake_month"--}}
{{--                                    class="form-select @error('intake_month') is-invalid @enderror"--}}
{{--                                    required>--}}
{{--                                <option value="">-- Select --</option>--}}
{{--                                <option value="1" {{ old('intake_month') == 1 ? 'selected' : '' }}>January</option>--}}
{{--                                <option value="5" {{ old('intake_month') == 5 ? 'selected' : '' }}>May</option>--}}
{{--                                <option value="9" {{ old('intake_month') == 9 ? 'selected' : '' }}>September</option>--}}
{{--                            </select>--}}
{{--                            @error('intake_month')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    --}}{{-- Actions --}}
{{--                    <div class="mt-4">--}}
{{--                        <button type="submit" class="btn btn-primary">--}}
{{--                            <i class="fas fa-save me-1"></i> Create Intake--}}
{{--                        </button>--}}

{{--                        <a href="{{ route('course_cohorts.index') }}" class="btn btn-secondary ms-2">--}}
{{--                            Cancel--}}
{{--                        </a>--}}
{{--                    </div>--}}

{{--                </form>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--    @section('scripts')--}}
{{--        <script>--}}
{{--            $(document).ready(function () {--}}
{{--                $('#course_id').select2({--}}
{{--                    placeholder: 'Search & select course',--}}
{{--                    allowClear: true,--}}
{{--                    width: '100%'--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endsection--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="page-breadcrumb d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Course Intake</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('course_cohorts.index') }}">Course Intakes</a>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('course_cohorts.store') }}">
                    @csrf

                    <div class="row">

                        {{-- Course (Searchable – No JS) --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Course <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="course_id"
                                   list="courses_list"
                                   class="form-control @error('course_id') is-invalid @enderror"
                                   placeholder="Start typing course name or code..."
                                   value="{{ old('course_id') }}"
                                   required>

                            <datalist id="courses_list">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            </datalist>

                            <small class="text-muted">
                                Type to search by course name or code
                            </small>

                            @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Intake Year --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                Intake Year <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                   name="intake_year"
                                   class="form-control @error('intake_year') is-invalid @enderror"
                                   value="{{ old('intake_year', date('Y')) }}"
                                   required>

                            @error('intake_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Intake Month --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                Intake Month <span class="text-danger">*</span>
                            </label>

                            <select name="intake_month"
                                    class="form-select @error('intake_month') is-invalid @enderror"
                                    required>
                                <option value="">-- Select --</option>
                                <option value="1" {{ old('intake_month') == 1 ? 'selected' : '' }}>January</option>
                                <option value="5" {{ old('intake_month') == 5 ? 'selected' : '' }}>May</option>
                                <option value="9" {{ old('intake_month') == 9 ? 'selected' : '' }}>September</option>
                            </select>

                            @error('intake_month')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Create Intake
                        </button>

                        <a href="{{ route('course_cohorts.index') }}" class="btn btn-secondary ms-2">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection

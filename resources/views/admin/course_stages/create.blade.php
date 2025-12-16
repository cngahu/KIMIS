@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('course_stages.store') }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stage Code</label>
                            <input type="text"
                                   name="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   placeholder="e.g. 1.1, VACATION"
                                   value="{{ old('code') }}"
                                   required>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Stage Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stage Type</label>
                            <select name="stage_type"
                                    class="form-select @error('stage_type') is-invalid @enderror"
                                    required>
                                <option value="">-- Select Type --</option>
                                @foreach(['academic','vacation','attachment','internship'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('stage_type') === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('stage_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input type="checkbox"
                                       name="is_billable"
                                       class="form-check-input"
                                       id="is_billable"
                                    {{ old('is_billable') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_billable">
                                    Billable Stage
                                </label>
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Stage
                    </button>

                    <a href="{{ route('course_stages.index') }}" class="btn btn-secondary ms-2">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

@endsection

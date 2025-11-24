@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold">Add Admission Document Type</h4>
                <small class="text-muted">Define a new upload requirement (e.g., National ID, KCSE Certificate)</small>
            </div>

            <div>
                <a href="{{ route('admin.admission.documents.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back"></i> Back to list
                </a>
            </div>
        </div>

        <div class="card radius-10 p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.admission.documents.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Document Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" required class="form-control" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mandatory?</label>
                        <select name="is_mandatory" class="form-select">
                            <option value="1" {{ old('is_mandatory','1') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_mandatory') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Allowed File Types (comma separated)</label>
                        <input type="text" name="file_types" class="form-control" value="{{ old('file_types','pdf,jpg,png') }}">
                        <small class="text-muted">e.g. pdf,jpg,png</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Max Size (MB)</label>
                        <input type="number" name="max_size" min="1" max="50" class="form-control" value="{{ old('max_size',5) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status','active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Create Document Type</button>
                    <a href="{{ route('admin.admission.documents.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>

    </div>

@endsection

@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold">Edit Document Type</h4>
                <small class="text-muted">Edit configuration for the upload requirement</small>
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

            <form action="{{ route('admin.admission.documents.update', $doc->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Document Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" required class="form-control" value="{{ old('name', $doc->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description', $doc->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mandatory?</label>
                        <select name="is_mandatory" class="form-select">
                            <option value="1" {{ old('is_mandatory', $doc->is_mandatory) == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_mandatory', $doc->is_mandatory) == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Allowed File Types (comma separated)</label>
                        <input type="text" name="file_types" class="form-control" value="{{ old('file_types', $doc->file_types) }}">
                        <small class="text-muted">e.g. pdf,jpg,png</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Max Size (MB)</label>
                        <input type="number" name="max_size" min="1" max="50" class="form-control" value="{{ old('max_size', $doc->max_size) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $doc->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $doc->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('admin.admission.documents.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>

    </div>

@endsection

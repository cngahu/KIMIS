@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">Add Department</h5>
            </div>

            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row g-3">

                        {{-- College --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                College <span class="text-danger">*</span>
                            </label>
                            <select
                                name="college_id"
                                class="form-select @error('college_id') is-invalid @enderror"
                            >
                                <option value="">-- Select College --</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}"
                                        {{ old('college_id') == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('college_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Department Name --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Department Name <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="e.g. Information Technology"
                                value="{{ old('name') }}"
                            >

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Department Code --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Department Code</label>
                            <input
                                type="text"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                placeholder="e.g. ICT"
                                value="{{ old('code') }}"
                            >

                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between">
                    <a href="{{ route('departments.index') }}" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Save Department
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection

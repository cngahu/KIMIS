@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Academic Departments</div>

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('backend.academic-departments.index') }}">Departments</a>
                        </li>
                        <li class="breadcrumb-item active">Add Department</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <hr/>

        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('backend.academic-departments.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Department Name</label>
                        <div class="col-sm-9">
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Department of ICT">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Campus</label>
                        <div class="col-sm-9">
                            <select name="college_id"
                                    class="form-select @error('college_id') is-invalid @enderror">
                                <option value="">-- Select Campus --</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}"
                                        {{ old('college_id') == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('college_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr/>

                    <div class="text-end">
                        <a href="{{ route('backend.academic-departments.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Save Department
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

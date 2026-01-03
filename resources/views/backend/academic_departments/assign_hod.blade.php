@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Assign HOD</div>

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('backend.academic-departments.index') }}">
                                Academic Departments
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Assign HOD
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <hr/>

        <div class="card">
            <div class="card-body">

                <h6 class="mb-3">
                    Department: <strong>{{ $department->name }}</strong><br>
                    Campus: <strong>{{ $department->college->name }}</strong>
                </h6>

                <form method="POST"
                      action="{{ route('backend.academic-departments.assign-hod.store', $department->id) }}">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Head of Department</label>
                        <div class="col-sm-9">
                            <select name="hod_user_id"
                                    class="form-select @error('hod_user_id') is-invalid @enderror">
                                <option value="">-- No HOD Assigned --</option>

                                @foreach($hods as $hod)
                                    <option value="{{ $hod->id }}"
                                        {{ old('hod_user_id', $department->hod_user_id) == $hod->id ? 'selected' : '' }}>
                                        {{ $hod->name }} ({{ $hod->email }})
                                    </option>
                                @endforeach
                            </select>

                            @error('hod_user_id')
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
                            Save Assignment
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

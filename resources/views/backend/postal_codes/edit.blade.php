@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Postal Codes</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.postal_codes.index') }}">All Postal Codes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Postal Code</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">

                <form action="{{ route('backend.postal_codes.update', $postal_code->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="code" class="form-control"
                               value="{{ old('code', $postal_code->code) }}" required>

                        @error('code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Town</label>
                        <input type="text" name="town" class="form-control"
                               value="{{ old('town', $postal_code->town) }}">

                        @error('town')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <button class="btn btn-primary rounded-pill px-4">Update</button>
                    <a href="{{ route('backend.postal_codes.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>

                </form>

            </div>
        </div>

    </div>

@endsection

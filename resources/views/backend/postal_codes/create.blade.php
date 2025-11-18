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
                        <li class="breadcrumb-item active" aria-current="page">Add Postal Code</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">

                <form action="{{ route('backend.postal_codes.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="code" class="form-control"
                               value="{{ old('code') }}" required>

                        @error('code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Town (optional)</label>
                        <input type="text" name="town" class="form-control"
                               value="{{ old('town') }}">

                        @error('town')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <button class="btn btn-success rounded-pill px-4">Save</button>
                    <a href="{{ route('backend.postal_codes.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>

                </form>

            </div>
        </div>

    </div>

@endsection

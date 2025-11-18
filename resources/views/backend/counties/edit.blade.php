@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Counties</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.counties.index') }}">All Counties</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit County</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">

                <form action="{{ route('backend.counties.update', $county->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">County Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $county->name) }}" required>

                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">County Code</label>
                        <input type="text" class="form-control" id="code" name="code"
                               value="{{ old('code', $county->code) }}">

                        @error('code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                            class="btn btn-primary px-4 py-2 rounded-pill">
                        Update County
                    </button>

                    <a href="{{ route('backend.counties.index') }}"
                       class="btn btn-secondary px-4 py-2 rounded-pill">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

@endsection

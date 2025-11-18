@extends('admin.admin_dashboard')
@section('admin')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Subcounties</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.subcounties.index') }}">All Subcounties</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Subcounty</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->


        <div class="card">
            <div class="card-body">

                <form action="{{ route('backend.subcounties.update', $subcounty->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="county_id" class="form-label">County</label>
                        <select name="county_id" id="county_id" class="form-control select2" required>
                            <option value="">-- Select County --</option>
                            @foreach($counties as $county)
                                <option value="{{ $county->id }}"
                                    {{ $subcounty->county_id == $county->id ? 'selected':'' }}>
                                    {{ $county->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('county_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="name" class="form-label">Subcounty Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $subcounty->name) }}" required>

                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="code" class="form-label">Subcounty Code</label>
                        <input type="text" class="form-control" id="code" name="code"
                               value="{{ old('code', $subcounty->code) }}">

                        @error('code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                        Update Subcounty
                    </button>

                    <a href="{{ route('backend.subcounties.index') }}"
                       class="btn btn-secondary px-4 py-2 rounded-pill">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
    </script>

@endsection

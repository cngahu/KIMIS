
@extends('admin.admin_dashboard')
@section('admin')

    <link href="{{ asset('adminbackend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Postal Codes</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Postal Codes</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <a href="{{ route('backend.postal_codes.create') }}" class="btn btn-primary">
                    Add Postal Code
                </a>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr/>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Town</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($postalCodes as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->town ?? '-' }}</td>

                                <td>
                                    <a href="{{ route('backend.postal_codes.edit', $item->id) }}"
                                       class="btn btn-primary rounded-pill">
                                        Edit
                                    </a>

                                    <form action="{{ route('backend.postal_codes.destroy', $item->id) }}"
                                          method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger rounded-pill"
                                                onclick="return confirm('Delete this postal code?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Town</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>

    </div>

    <script src="{{ asset('adminbackend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminbackend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $('#example').DataTable();
    </script>

@endsection

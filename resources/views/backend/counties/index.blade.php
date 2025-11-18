@extends('admin.admin_dashboard')
@section('admin')
    <link href="{{ asset('adminbackend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Counties</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Counties</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <a href="{{ route('backend.counties.create') }}" class="btn btn-primary">
                    Add County
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
                            <th>County Name</th>
                            <th>Code</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($counties as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->code ?? '-' }}</td>

                                <td>
                                    <a href="{{ route('backend.counties.edit', $item->id) }}"
                                       class="btn btn-primary rounded-pill waves-effect waves-light">
                                        Edit
                                    </a>

                                    <form action="{{ route('backend.counties.destroy', $item->id) }}"
                                          method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger rounded-pill waves-effect waves-light"
                                                onclick="return confirm('Are you sure you want to delete this county?')">
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
                            <th>County Name</th>
                            <th>Code</th>
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

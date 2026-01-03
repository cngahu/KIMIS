@extends('admin.admin_dashboard')

@section('admin')
    <link href="{{ asset('adminbackend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

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
                        <li class="breadcrumb-item active">
                            Academic Departments
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <a href="{{ route('backend.academic-departments.create') }}"
                   class="btn btn-primary">
                    Add Department
                </a>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <hr/>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example"
                           class="table table-striped table-bordered datatable">

                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Campus</th>
                            <th>HOD</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($departments as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>
                                    <strong>{{ $item->name }}</strong>
                                </td>

                                <td>
                                    {{ $item->college->name ?? '-' }}
                                </td>

                                <td>
                                    @if($item->hod)
                                        <span class="badge bg-success">
                                           {{ $item->hod->surname }}
                                            {{ $item->hod->firstname }}
                                            {{ $item->hod->othername }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            Not Assigned
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if(!$item->hod)
                                        <a href="{{ route('backend.academic-departments.assign-hod', $item->id) }}"
                                           class="btn btn-sm btn-warning rounded-pill">
                                            Assign HOD
                                        </a>
                                    @else
                                        <a href="{{ route('backend.academic-departments.assign-hod', $item->id) }}"
                                           class="btn btn-sm btn-info rounded-pill">
                                            Change HOD
                                        </a>
                                    @endif

                                    <a href="{{ route('backend.academic-departments.edit', $item->id) }}"
                                       class="btn btn-sm btn-primary rounded-pill">
                                        Edit
                                    </a>

                                    <form action="{{ route('backend.academic-departments.destroy', $item->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger rounded-pill"
                                                onclick="return confirm('Delete this department?')">
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
                            <th>Department</th>
                            <th>Campus</th>
                            <th>HOD</th>
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
        $('#example').DataTable({
            pageLength: 25
        });
    </script>
@endsection

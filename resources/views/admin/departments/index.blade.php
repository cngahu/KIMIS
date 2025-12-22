@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <h5 class="mb-0">Departments</h5>
                <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
                    Add Department
                </a>
            </div>

            <div class="card-body">
                {{-- Filter --}}
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-4">
                        <select name="college_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Filter by College --</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}"
                                    {{ request('college_id') == $college->id ? 'selected' : '' }}>
                                    {{ $college->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                {{-- Table --}}
                <table class="table table-bordered table-striped" id="departmentsTable">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>College</th>
                        <th>Department</th>
                        <th>Code</th>
                        <th width="120">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->college->name }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->code }}</td>
                            <td>
                                <a href="{{ route('departments.edit', $department) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('departments.destroy', $department) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this department?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    {{-- DataTables --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#departmentsTable').DataTable();
        });
    </script>
@endsection

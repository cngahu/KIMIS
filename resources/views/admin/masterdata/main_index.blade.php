@extends('admin.admin_dashboard')

@section('admin')
    <link href="{{ asset('adminbackend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">

            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Students</p>
                                <h4 class="my-1 text-primary">{{ $totalStudents }}</h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-user fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Activated</p>
                                <h4 class="my-1 text-success">{{ $activeStudents }}</h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Not Activated</p>
                                <h4 class="my-1 text-danger">{{ $inactiveStudents }}</h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-x-circle fs-3 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Master Data</div>

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All Students
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('masterdata.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add New Student
                    </a>
                </div>
            </div>

        </div>
        <!-- end breadcrumb -->

        <hr/>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table id="example" class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Admission No</th>
                            <th>Full Name</th>
                            <th>Campus</th>
                            <th>Department</th>
                            <th>Course</th>
                            <th>Intake</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($masterdata as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->admissionNo }}</td>
                                <td>{{ $item->full_name }}</td>
                                <td>{{ $item->campus }}</td>
                                <td>{{ $item->department }}</td>
                                <td>{{ $item->course_name }}</td>
                                <td>{{ $item->intake }}</td>
                                <td class="text-end">
                                    {{ number_format($item->balance ?? 0, 2) }}
                                </td>
                                <td>
                                    @if($item->is_activated)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Admission No</th>
                            <th>Full Name</th>
                            <th>Campus</th>
                            <th>Department</th>
                            <th>Course</th>
                            <th>Intake</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>
@endsection

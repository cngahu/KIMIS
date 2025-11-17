@extends('applicant.applicant_dashboard')
@section('applicant')
    <link href="{{ asset('adminbackend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Post Secondary Qualifications </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Post Secondary Qualifications</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('applicant.postsecondaryeducation') }}" class="btn btn-primary">Add More</a>
                    <a href="{{ route('applicant.profileapplication') }}" class="btn btn-warning">View Application </a>

                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Institution </th>
                            <th>Course Name </th>
                            <th>Start Date </th>
                            <th>Exit Date </th>
                            <th>Certificate </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($postsecondary as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->institutionName }}</td>
                                <td>{{ $item->course_name }}</td>
                                <td>{{ $item->startDate }}</td>
                                <td>{{ $item->exitDate }}</td>
                                <td><a href="{{asset($item->certificate) }}" target="_blank">Certificate</a> </td>
                                <td>
                                    <a href="" class="btn btn-primary rounded-pill waves-effect waves-light">Edit</a>
                                    <a href="" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete">Delete</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Permission Name </th>
                            <th>Group Name </th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


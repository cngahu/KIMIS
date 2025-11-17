@extends('applicant.applicant_dashboard')
@section('applicant')
<div class="page-content">
    <!--breadcrumb-->

    <div >
        <h2 style="color:indianred; font-size:15pt;">This is how your profile looks like. Should you wish to make corrections, kindly edit accordingly on the sections highlighted on the left </h2>

    </div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

        <div class="breadcrumb-title pe-3">Profile For:</div>

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"></li>

                    <h3>
                        Applicant Profile - <span >

        <a style="text-decoration:none; color:indianred; font-size:20pt;" href="#">
           {{$userid->surname}}, {{$userid->firstname}} {{$userid->othername}}
        </a>


    </span>


                    </h3>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div style="background-color:#073763; color:#FFFFFF; border-bottom:solid;border-width:3px;border-bottom-color:#DE8500;text-align:center;">
                Profile
            </div>
            <div>
                <table class="table table-condensed">
                    <tr>
                        <th>Name</th>
                        <th>Nationality</th>
                        <th>County of Residence</th>
                        <th>Gender</th>
                        <th>Mobile</th>
                        <th>DOB</th>

                    </tr>



                    <tr class=".table-striped">

                        <td>  {{$userid->surname}} {{$userid->firstname}} {{$userid->othername}}</td>
                        <td> {{$userid['cnation']['name']}}</td>
                        <td> {{$userid['ccounty']['name']}}</td>
                        <td> {{$userid['cgender']['name']}}</td>
                        <td> {{$userid->phone}}</td>
                        <td>{{$userid->dob}}</td>


                    </tr>




                </table>
            </div>
        </div>
        <div style="background-color:#555555; color:#FFFFFF; border-bottom:solid;border-width:3px;border-bottom-color:#DE8500;text-align:center;">
            Educational Qualifications
        </div>
        <div>
          <div class="card-body">
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
                  @foreach($educationquals as $key=> $item)
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


    <a href="{{route('applicant.dashboard')}}" class="btn btn-danger">Back To Dashboard</a>

    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#success-alert-modal">Submit Application</button>
</div>

<div id="standard-modal" class="modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Are You Sure?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are You Sure Ypu want to submit thus?</h6>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <a href="" class="btn btn-danger">Submit Application</a>

                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="success-alert-modal00" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-filled bg-success">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-checkmark h1 text-white"></i>
                    <h4 class="mt-2 text-white">Well Done!</h4>
                    <p class="mt-3 text-white">Are You Sure You Want To Submit This Application?</p>
                    <a href="" class="btn btn-danger">Submit Application</a>

                    <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="success-alert-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        @php

        @endphp
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">I, {{$userid->surname}} {{$userid->firstname}} {{$userid->othername}} of P.O.Box {{$userid->address}},{{$userid->city}} do hereby declare that:</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol>
                    <li>The information I have supplied on this form and any attachment is complete, correct and up
                        to date.</li>
                    <li>
                        I undertake to inform the Physiotherapy Council of Kenya (PCK) of any change to my
                        circumstances (e.g. address) while my application is being considered.
                    </li>
                    <li>
                        I authorize the Physiotherapy Council of Kenya to make any inquires necessary to assist in
                        the assessment of my qualifications and to use any information supplied in this application.
                    </li>
                    <li>
                        I have read, understood and commit myself to abide with the rules and regulations in the
                        guidelines.
                    </li>
                </ol>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection

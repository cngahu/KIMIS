@extends('applicant.applicant_dashboard')
@section('applicant')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SECTION 2 </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">PRIMARY SCHOOL DETAILS </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card border-top border-left  border-0 border-4 border-success">
            <div class="card-body p-5">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                    </div>
                </div>
                <hr>
                <form class="row g-3" id="myForm" method="post" action="{{ route('primaryeducation.store') }}" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="userid" value="{{$userid}}">


                    <div class="row">
                        <div class="col-md-6">
                            <label for="institutionName" class="form-label " style="font-size:large">Primary School Name</label>
                            <div class="form-group">
                                <input type="text" name="institutionName"  class="form-control border-start-0" id="surname" placeholder="Primary School Name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dob" class="form-label " style="font-size:large" >Start Date</label>
                            <div class="form-group">
                                <input type="date" id="date_picker" name="startDate" value="" class="form-control"   />

                            </div>
                        </div>



                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dob" class="form-label " style="font-size:large" >Finish Date</label>
                            <div class="form-group">
                                <input type="date" id="date_picker" name="exitDate" value="" class="form-control"   />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="grade" class="form-label" style="font-size:large">Qualification</label>
                            <div class="form-grosup">
                                <input type="text" name="grade"  class="form-control border-start-0" id="grade" placeholder="Qualification" />
                            </div>
                        </div>

                    </div>
                    <p></p>

                    <div class="row">

                        <div class="col-md-6">
                            <label for="country_id" class="form-label " style="font-size:large" >Country</label>
                            <div class="form-group">
                                <select name="country_id" id="country_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Country</option>
                                    @foreach($country as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="certificate" class="form-label" style="font-size:large">Primary School Certificate</label>
                            <div class="form-group">
                                <input name="certificate" class="form-control"  type="file" id="certificate" >

                            </div>
                        </div>

                    </div>
                    <p></p>












                    <div class="col-12">
                        <button type="submit" style="width: 100%" class="btn btn-success " style="font-size:large">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        maxDate: (new Date()).toString()
        today = yyyy + '-' + mm + '-' + dd;
        $('#date_picker').attr('max',today);
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#photo').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });


    </script>
    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    surname: {
                        required : true,
                    },
                    startDate: {
                        required : true,
                    },
                    exitDate: {
                        required : true,
                    },
                    certificate: {
                        required : true,
                    },
                    date_picker: {
                        required : true,
                    },
                    country_id: {
                        required : true,
                    },


                },
                messages :{
                    surname: {
                        required : 'Surname Required',
                    },
                    startDate: {
                        required : 'Start Date Required',
                    },
                    exitDate: {
                        required : 'Finish Date Required',
                    },

                    date_picker: {
                        required : 'Please Enter Date of Birth',
                    },
                    country_id: {
                        required : 'Please Select Country of Birth',
                    },


                    certificate: {
                        required : 'Please Upload Passport Size Photo',
                    },


                },
                errorElement : 'span',
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });

    </script>


@endsection

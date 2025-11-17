@extends('applicant.applicant_dashboard')
@section('applicant')

    <div class="page-content">
        @if($user->level==1)
            <div class="row">
                <h3>Dear {{$user->surname}} {{$user->firstname}}, kindly complete your profile by clicking <a href="{{route('applicant.register')}}">here</a> </h3>
            </div>
{{--       @elseif($user->level==2)--}}
{{--                <div class="row">--}}
{{--                    <h3>Dear {{$user->surname}} {{$user->firstname}}, kindly complete your Primary School profile by clicking <a href="{{route('applicant.primaryeducation')}}">here</a> </h3>--}}
{{--                </div>--}}
{{--        @elseif($user->level==3)--}}
{{--            <div class="row">--}}
{{--                <h3>Dear {{$user->surname}} {{$user->firstname}}, kindly complete your Secondary School profile by clicking <a href="{{route('applicant.secondaryeducation')}}">here</a> </h3>--}}
{{--            </div>--}}
{{--        @elseif($user->level==4)--}}
{{--            <div class="row">--}}
{{--                <h3>Dear {{$user->surname}} {{$user->firstname}}, kindly complete your Post Secondary School profile by clicking <a href="{{route('applicant.postsecondaryeducation')}}">here</a> </h3>--}}
{{--            </div>--}}
        @elseif($user->level==2)
            <div class="row">

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                            <div class="card-body" >
                                <div class="flex flex-col" >
                                    <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />
                                    <hr style="color: black">
                                    <h5 style="font-size: small">EXAMINATION, REGISTRATION AND LICENSING DEPARTMENT</h5>
                                    <hr style="color: black">
                                    <p style="color: black">Apply For Student Indexing</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                        <div class="card-body">
                            <div class="flex flex-col">
                                <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />
                                <hr style="color: black">
                                <h5 style="font-size: small">EXAMINATION, REGISTRATION AND LICENSING DEPARTMENT</h5>
                                <hr style="color: black">
                                <p style="color: black">Apply for Pre-Examination</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                        <div class="card-body">
                            <div class="flex flex-col">
                                <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />
                                <hr style="color: black">
                                <h5 style="font-size: small">EXAMINATION, REGISTRATION AND LICENSING DEPARTMENT</h5>
                                <hr style="color: black">
                                <p style="color: black">Apply For Registration</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                            <div class="card-body">
                                <div class="flex flex-col">
                                    <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />
                                    <hr style="color: black">
                                    <h5 style="font-size: small">EXAMINATION, REGISTRATION AND LICENSING DEPARTMENT</h5>
                                    <hr style="color: black">
                                    <p style="color: black">Application For Indexing</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                            <div class="card-body">
                                <div class="flex flex-col">
                                    <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />
                                    <hr style="color: black">
                                    <h5 style="font-size: small">EXAMINATION, REGISTRATION AND LICENSING DEPARTMENT</h5>
                                    <hr style="color: black">
                                    <p style="color: black">Application For Indexing</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                            <div class="card-body">
                                <div class="flex flex-col">
                                    <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />
                                    <hr style="color: black">
                                    <h5 style="font-size: small">EXAMINATION, REGISTRATION AND LICENSING DEPARTMENT</h5>
                                    <hr style="color: black">
                                    <p style="color: black">Application For Indexing</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="row">
                <h3>Dear {{$user->surname}} {{$user->firstname}},Here is Your Current Profile <a href="{{route('applicant.postsecondaryeducation')}}">here</a> </h3>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card">
                        <img src="{{ asset('images/profile_picture.jpg') }}" class="card-img-top" alt="Profile Picture">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">Bio: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Profile Details -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Details</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Personal Information -->
                                    <h6>Personal Information</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">Name: John Doe</li>
                                        <li class="list-group-item">Age: 30</li>
                                        <!-- Add more fields here -->
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <!-- Contact Information -->
                                    <h6>Contact Information</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">Email: john@example.com</li>
                                        <li class="list-group-item">Phone: 123-456-7890</li>
                                        <!-- Add more fields here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{--            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-deepblue">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="ms-auto">--}}
{{--                                <img src="https://demoadmin.ecitizen.pesaflow.com/assets/uploads/2023/05/agency-national-transport-and-safety-authority.png" width="100" height="50" alt="National Transport And Safety Authority (NTSA) (New)">--}}
{{--                                <img src="{{asset('adminbackend/assets/images/logo-imgbg.png')}}" width="100%" alt="" />--}}

{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white">--}}
{{--                                    National Transport And Safety Authority (NTSA) (New)--}}
{{--                                </h5>--}}

{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">--}}
{{--                                    Dedicated platform for Application and Renewal of Driving Licence, Driving School Management and PSV related services--}}
{{--                                </p>--}}
{{--                            </div>--}}


{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-orange">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white">$8323</h5>--}}
{{--                                <div class="ms-auto">--}}
{{--                                    <i class='bx bx-dollar fs-3 text-white'></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">Total Revenue</p>--}}
{{--                                <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-ohhappiness">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white">6200</h5>--}}
{{--                                <div class="ms-auto">--}}
{{--                                    <i class='bx bx-group fs-3 text-white'></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">Visitors</p>--}}
{{--                                <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-ibiza">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white">5630</h5>--}}
{{--                                <div class="ms-auto">--}}
{{--                                    <i class='bx bx-envelope fs-3 text-white'></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">Messages</p>--}}
{{--                                <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div><!--end row-->--}}

{{--            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-deepblue">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white"> PROFESSIONAL INDEXING SERVICE</h5>--}}

{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-orange">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white"></h5>--}}
{{--                                <div class="ms-auto">--}}
{{--                                    <i class='bx bx-dollar fs-3 text-white'></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">Total Revenue</p>--}}
{{--                                <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-ohhappiness">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white">6200</h5>--}}
{{--                                <div class="ms-auto">--}}
{{--                                    <i class='bx bx-group fs-3 text-white'></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">Visitors</p>--}}
{{--                                <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card radius-10 bg-gradient-ibiza">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <h5 class="mb-0 text-white">5630</h5>--}}
{{--                                <div class="ms-auto">--}}
{{--                                    <i class='bx bx-envelope fs-3 text-white'></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="progress my-3 bg-light-transparent" style="height:3px;">--}}
{{--                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center text-white">--}}
{{--                                <p class="mb-0">Messages</p>--}}
{{--                                <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div><!--end row-->--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-4" style="border-top:2px solid red;border-color: red;">--}}
{{--             <div class="col-md-4">--}}
{{--           <a href="https://google.com" style="color: black">--}}
{{--               <div class="col-md-12" style="border: 1px solid grey;border-radius: 10px">--}}
{{--                   <div class="flex flex-col">--}}
{{--                       --}}{{--                    <div class="p-3 flex-shrink-0 flex justify-between items-center border-b border-gray-300">--}}
{{--                       --}}{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-gray-400">--}}
{{--                       --}}{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>--}}
{{--                       --}}{{--                        </svg>--}}

{{--                       --}}{{--                    </div>--}}
{{--                       <img src="https://demoadmin.ecitizen.pesaflow.com/assets/uploads/2023/05/agency-national-transport-and-safety-authority.png" width="100" height="50" alt="National Transport And Safety Authority (NTSA) (New)">--}}

{{--                       <hr style="color: black">--}}
{{--                       <div class="p-3">--}}
{{--                           <h5 class="text-base line-clamp-2 font-medium text-gray-500 group-hover:text-gray-800 mb-2">--}}
{{--                               National Transport And Safety Authority (NTSA) (New)--}}
{{--                           </h5>--}}
{{--                           Dedicated platform for Application and Renewal of Driving Licence, Driving School Management and PSV related services--}}

{{--                       </div>--}}
{{--                   </div>--}}

{{--               </div>--}}
{{--           </a>--}}
{{--       </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <a href="https://google.com" style="color: black">--}}
{{--                    <div class="col-md-12" style="border: 1px solid grey;border-radius: 10px">--}}
{{--                        <div class="flex flex-col">--}}
{{--                            --}}{{--                    <div class="p-3 flex-shrink-0 flex justify-between items-center border-b border-gray-300">--}}
{{--                            --}}{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-gray-400">--}}
{{--                            --}}{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>--}}
{{--                            --}}{{--                        </svg>--}}

{{--                            --}}{{--                    </div>--}}
{{--                            <img src="https://demoadmin.ecitizen.pesaflow.com/assets/uploads/2023/05/agency-national-transport-and-safety-authority.png" width="100" height="50" alt="National Transport And Safety Authority (NTSA) (New)">--}}

{{--                            <hr style="color: black">--}}
{{--                            <div class="p-3">--}}
{{--                                <h5 class="text-base line-clamp-2 font-medium text-gray-500 group-hover:text-gray-800 mb-2">--}}
{{--                                    National Transport And Safety Authority (NTSA) (New)--}}
{{--                                </h5>--}}
{{--                                Dedicated platform for Application and Renewal of Driving Licence, Driving School Management and PSV related services--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <a href="https://google.com" style="color: black">--}}
{{--                    <div class="col-md-12" style="border: 1px solid grey;border-radius: 10px">--}}
{{--                        <div class="flex flex-col">--}}
{{--                            --}}{{--                    <div class="p-3 flex-shrink-0 flex justify-between items-center border-b border-gray-300">--}}
{{--                            --}}{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-gray-400">--}}
{{--                            --}}{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>--}}
{{--                            --}}{{--                        </svg>--}}

{{--                            --}}{{--                    </div>--}}
{{--                            <img src="https://demoadmin.ecitizen.pesaflow.com/assets/uploads/2023/05/agency-national-transport-and-safety-authority.png" width="100" height="50" alt="National Transport And Safety Authority (NTSA) (New)">--}}

{{--                            <hr style="color: black">--}}
{{--                            <div class="p-3">--}}
{{--                                <h5 class="text-base line-clamp-2 font-medium text-gray-500 group-hover:text-gray-800 mb-2">--}}
{{--                                    National Transport And Safety Authority (NTSA) (New)--}}
{{--                                </h5>--}}
{{--                                Dedicated platform for Application and Renewal of Driving Licence, Driving School Management and PSV related services--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}



        @endif


    </div>

@endsection

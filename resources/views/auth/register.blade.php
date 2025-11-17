<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{asset('adminbackend/assets/images/favicon-32x32.png')}}"  type="image/png" />
    <!--plugins-->
    <link href="{{asset('adminbackend/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('adminbackend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{asset('adminbackend/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{asset('adminbackend/assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{asset('adminbackend/assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('adminbackend/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('adminbackend/assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('adminbackend/assets/css/icons.css')}}" rel="stylesheet">
    <title>Kenya Film Classification Board</title>
</head>

<body class="bg-login">
<!--wrapper-->
<div class="wrapper">
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                <div class="col mx-auto">
                    <div class="my-4 text-center">
                        <img src="{{asset('adminbackend/assets/images/logo-img.png')}}" width="100%" alt="" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h2 class="">Physiotherapy Council of Kenya</h2>
                                    <h3 class="">Sign Up</h3>
                                    <p>Already have an account? <a href="{{route("login")}}">Sign in here</a>
                                    </p>
                                </div>

                                <div class="login-separater text-center mb-4"> <span> SIGN UP WITH EMAIL</span>
                                    <hr/>
                                </div>
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('register') }}">
                                        @csrf



                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="inputFirstName" class="form-label">Surname</label>
                                                    <input type="text" name="surname" class="form-control" id="inputFirstName" placeholder="Surname">
                                                    <x-input-error :messages="$errors->get('surname')" style="color: red" class="mt-2" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="inputFirstName" class="form-label">First Name</label>
                                                    <input type="text" name="firstname" class="form-control" id="inputFirstName" placeholder="First Name">
                                                    <x-input-error :messages="$errors->get('firstname')" style="color: red" class="mt-2" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="inputFirstName" class="form-label">Other Names</label>
                                                    <input type="text" name="othername" class="form-control" id="inputFirstName" placeholder="Other Name">
                                                    <x-input-error :messages="$errors->get('othername')" style="color: red" class="mt-2" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="inputFirstName" class="form-label"> Email Address</label>
                                                    <input type="email" name="email" class="form-control" id="inputFirstName" placeholder="Email">
                                                    <x-input-error :messages="$errors->get('email')" style="color: red" class="mt-2" />
                                                </div>

                                            </div>



                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="inputChoosePassword" class="form-label">Password</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" name="password" id="password" class="form-control border-end-0" id="inputChoosePassword" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                        <x-input-error :messages="$errors->get('password')" style="color: red" class="mt-2" />

                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="inputChoosePassword" class="form-label">Password Confirmation</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" name="password_confirmation" class="form-control border-end-0" id="password_confirmation" value="" placeholder="Confirm Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                        <x-input-error :messages="$errors->get('password_confirmation')" style="color: red" class="mt-2" />

                                                    </div>
                                                </div>
                                            </div>











                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class='bx bx-user'></i>Sign up</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>



<!-- Bootstrap JS -->
<script src="{{asset('adminbackend/assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{asset('adminbackend/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('adminbackend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('adminbackend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('adminbackend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>
<!--app JS-->
<script src="{{asset('adminbackend/assets/js/app.js')}}"></script>
</body>

</html>


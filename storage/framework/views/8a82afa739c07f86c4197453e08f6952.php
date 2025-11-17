<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?php echo e(asset('adminbackend/assets/images/favicon-32x32.png')); ?>" type="image/png" />
    <!--plugins-->
    <link href="<?php echo e(asset('adminbackend/assets/plugins/simplebar/css/simplebar.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('adminbackend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('adminbackend/assets/plugins/metismenu/css/metisMenu.min.css')); ?>" rel="stylesheet" />
    <!-- loader-->
    <link href="<?php echo e(asset('adminbackend/assets/css/pace.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(asset('adminbackend/assets/js/pace.min.js')); ?>"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(asset('adminbackend/assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('adminbackend/assets/css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('adminbackend/assets/css/icons.css')); ?>" rel="stylesheet">
    <title>Application Login</title>
</head>

<body class="bg-login">
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="mb-4 text-center">
                        <img src="<?php echo e(asset('adminbackend/assets/images/logo-img.png')); ?>" width="100%" alt="" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h3 class="">Sign in</h3>
                                    <p>Don't have an account yet? <a href="<?php echo e(route('register')); ?>">Sign up here</a>
                                    </p>
                                </div>


                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="<?php echo e(route('login')); ?>">
                                        <?php echo csrf_field(); ?>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Enter Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password" class="form-control border-end-0" id="password"  placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">	<a href="<?php echo e(route('password.request')); ?>">Forgot Password ?</a>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> <a href="<?php echo e(route('register')); ?>" style="color: green">Register as an Individual</a></div>
                                <div class="col-md-6">     <a href="#" style="color: orange">Register as an Institution</a></div>




                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->
<!-- Bootstrap JS -->
<script src="<?php echo e(asset('adminbackend/assets/js/bootstrap.bundle.min.js')); ?>"></script>
<!--plugins-->
<script src="<?php echo e(asset('adminbackend/assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminbackend/assets/plugins/simplebar/js/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminbackend/assets/plugins/metismenu/js/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminbackend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')); ?>"></script>
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
<script src="assets/js/app.js"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\pck.go.ke\resources\views/auth/login.blade.php ENDPATH**/ ?>
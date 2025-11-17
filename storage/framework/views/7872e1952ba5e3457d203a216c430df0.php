<?php $__env->startSection('applicant'); ?>

    <div class="page-content">
        <?php if($user->level==1): ?>
            <div class="row">
                <h3>Dear <?php echo e($user->surname); ?> <?php echo e($user->firstname); ?>, kindly complete your profile by clicking <a href="<?php echo e(route('applicant.register')); ?>">here</a> </h3>
            </div>












        <?php elseif($user->level==2): ?>
            <div class="row">

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="">
                        <div class="card bg-light text-white" style="border-radius: 20px">
                            <div class="card-body" >
                                <div class="flex flex-col" >
                                    <img src="<?php echo e(asset('adminbackend/assets/images/logo-imgbg.png')); ?>" width="100%" alt="" />
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
                                <img src="<?php echo e(asset('adminbackend/assets/images/logo-imgbg.png')); ?>" width="100%" alt="" />
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
                                <img src="<?php echo e(asset('adminbackend/assets/images/logo-imgbg.png')); ?>" width="100%" alt="" />
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
                                    <img src="<?php echo e(asset('adminbackend/assets/images/logo-imgbg.png')); ?>" width="100%" alt="" />
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
                                    <img src="<?php echo e(asset('adminbackend/assets/images/logo-imgbg.png')); ?>" width="100%" alt="" />
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
                                    <img src="<?php echo e(asset('adminbackend/assets/images/logo-imgbg.png')); ?>" width="100%" alt="" />
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
                <h3>Dear <?php echo e($user->surname); ?> <?php echo e($user->firstname); ?>,Here is Your Current Profile <a href="<?php echo e(route('applicant.postsecondaryeducation')); ?>">here</a> </h3>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card">
                        <img src="<?php echo e(asset('images/profile_picture.jpg')); ?>" class="card-img-top" alt="Profile Picture">
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


















































































































































































































































        <?php endif; ?>


    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('applicant.applicant_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pck.go.ke\resources\views/applicant/index.blade.php ENDPATH**/ ?>
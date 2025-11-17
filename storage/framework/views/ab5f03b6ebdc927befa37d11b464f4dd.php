<?php $__env->startSection('applicant'); ?>
    <div class="container">
<p></p>
        <div class="row">
            <p></p><p></p>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="<?php echo e((!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo):url('upload/no_image.jpg')); ?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4><?php echo e($adminData->name); ?></h4>
                                    <p class="text-secondary mb-1">Email: <?php echo e($adminData->email); ?></p>
                                    <p class="text-muted font-size-sm"><?php echo e($adminData->address); ?></p>

                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>ID/PASSPORT</h6>

                                    <a href="<?php echo e(asset($adminData->national_id)); ?>" target="_blank" >Click To View</a>
                                    </span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <button type="button" class="btn btn-danger px-5 radius-30">Click To Edit Profile</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <!-- Profile Details -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-header">Profile Details</h5>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Surname</label>
                                        <input id="name" type="text" class="form-control" value="<?php echo e($adminData->surname); ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">First Name</label>
                                        <input id="email" type="email" class="form-control" value="<?php echo e($adminData->firstname); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <p></p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Other Name</label>
                                        <input  class="form-control" value="<?php echo e($adminData->othername); ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="created_at">Phone</label>
                                        <input class="form-control" value="<?php echo e($adminData->phone); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Postal Address</label>
                                        <input id="name" type="text" class="form-control" value="<?php echo e($adminData->address); ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Physical Address Name</label>
                                        <input id="email" type="email" class="form-control" value="<?php echo e($adminData->physical_address); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Gender</label>
                                        <input id="name" type="text" class="form-control" value="<?php echo e($adminData['cgender']['name']); ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Country Of Birth</label>
                                        <input id="email" type="email" class="form-control" value="<?php echo e($adminData['ccountry']['name']); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nationality</label>
                                        <input id="name" type="text" class="form-control" value="<?php echo e($adminData['cnation']['name']); ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">County</label>
                                        <input id="email" type="email" class="form-control" value="<?php echo e($adminData['ccounty']['name']); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Date Of Birth</label>
                                        <input id="name" type="text" class="form-control" value="<?php echo e($adminData->dob); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">ID /Passport Number</label>
                                        <input id="name" type="text" class="form-control" value="<?php echo e($adminData->nationalid); ?>" readonly>
                                    </div>
                                </div>

                            </div>
                            <p></p>
                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Next Of Kin</label>
                                        <input  class="form-control" value="<?php echo e($adminData->next_of_kin); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Next Of Kin Contact</label>
                                        <input  class="form-control" value="<?php echo e($adminData->next_of_kin_contact); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <p></p>

                            <!-- Add other fields here -->


                        </div>
                    </div>
                </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('applicant.applicant_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pck.go.ke\resources\views/applicant/profile_view.blade.php ENDPATH**/ ?>
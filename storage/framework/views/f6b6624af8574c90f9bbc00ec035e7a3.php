<?php $__env->startSection('applicant'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SECTION 1 </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">PERSONAL DETAILS </li>
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
                    <h5 class="mb-0 "style="font-size:large">Information</h5>
                </div>
                <hr>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form class="row g-3" id="myForm" method="post" action="<?php echo e(route('register.store')); ?>" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="userid" value="<?php echo e($user->id); ?>">


                        <div class="col-md-6 form-group">
                            <label for="surname" class="form-label " style="font-size:large">Surname</label>

                                <input  type="text" name="surname" value="<?php echo e($user->surname); ?>"  class="form-control" id="surname" placeholder="Staff Name" />

                        </div>
                    <div class="col-md-6 form-group">
                            <label for="firstname" class="form-label " style="font-size:large">First Name</label>

                                <input type="text"  name="firstname"  value="<?php echo e($user->firstname); ?>" class="form-control" id="firstname" placeholder="First Name" />

                        </div>



                    <div class="col-md-6 form-group">
                            <label for="othername" class="form-label " style="font-size:large">Other Names</label>

                                <input type="text" name="othername" value="<?php echo e($user->othername); ?>"  class="form-control" id="othername" placeholder="Other Names" />

                        </div>
                    <div class="col-md-6 form-group">
                            <label for="title_id" class="form-label " style="font-size:large" >Title</label>
                            <div class="form-group">
                                <select name="title_id" id="title_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Title</option>
                                    <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('title_id') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>



                    <div class="col-md-6 form-group">
                            <label for="gender_id" class="form-label " style="font-size:large" >Sex</label>
                            <div class="form-group">
                                <select name="gender_id" id="gender_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Sex</option>
                                    <?php $__currentLoopData = $gender; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('gender_id') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>
                    <div class="col-md-6 form-group">
                            <label for="dob" class="form-label " style="font-size:large" >Date of Birth</label>

                                <input type="date" id="dob" name="dob" value="<?php echo e(old('dob')); ?>" class="form-control"   />


                        </div>


                    <div class="col-md-6 form-group">
                            <label for="country_id" class="form-label " style="font-size:large" >Country of Birth</label>
                            <div class="form-group">
                                <select name="country_id" id="country_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select County of Birth</option>
                                    <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('country_id') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>
                    <div class="col-md-6 form-group">
                            <label for="nationality" class="form-label " style="font-size:large" >Nationality</label>
                            <div class="form-group">
                                <select name="nationality" id="nationality" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Nationality</option>
                                    <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('nationality') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>


                    <div class="col-md-6 form-group">
                            <label for="county" class="form-label " style="font-size:large" >County of Residence</label>
                            <div class="form-group">
                                <select name="county" id="county" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select County</option>
                                    <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('county') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="address" class="form-label " style="font-size:large" >Permanent Postal Address</label>

                                <input type="text" name="address" value="<?php echo e(old('address')); ?>"  class="form-control" id="address" placeholder="Postal Address-Code eg 62000-00200" />

                        </div>

                    <div class="col-md-6 form-group">
                            <label for="inputLastName2" class="form-label" style="font-size:large">Postal City/Town</label>

                                <input type="text" name="city"  value="<?php echo e(old('city')); ?>" class="form-control" id="city" placeholder="Postal City" />

                        </div>
                    <div class="col-md-6 form-group">
                            <label for="physical_address" class="form-label" style="font-size:large" >Physical Address</label>

                                <input name="physical_address" value="<?php echo e(old('physical_address')); ?>" class="form-control" type="text" id="physical_address" placeholder="Physical Address">


                        </div>



                    <div class="col-md-6 form-group">
                            <label for="phone" class="form-label" style="font-size:large">Mobile/Telephone Number</label>

                                <input type="text" name="phone" value="<?php echo e(old('phone')); ?>"  class="form-control" id="phone" placeholder="Phone Number" />

                        </div>
                    <div class="col-md-6 form-group">
                            <label for="nationalid" class="form-label" style="font-size:large">National ID/Passport Number</label>

                                <input type="text" name="nationalid" value="<?php echo e(old('nationalid')); ?>"  class="form-control" id="nationalid" placeholder="ID/Passport Number" />

                        </div>



                    <div class="col-md-6 form-group">
                            <label for="next_of_kin" class="form-label" style="font-size:large">Next of Kin Name</label>

                                <input type="text" name="next_of_kin" value="<?php echo e(old('next_of_kin')); ?>"  class="form-control" id="next_of_kin" placeholder="Next of Kin Name" />

                        </div>
                    <div class="col-md-6 form-group">
                            <label for="inputLastName2" class="form-label" style="font-size:large">Next of Kin Contact</label>

                                <input type="text" name="next_of_kin_contact" value="<?php echo e(old('next_of_kin_contact')); ?>"  class="form-control" id="next_of_kin_contact" placeholder="Next of Kin Contact" />

                        </div>




                    <div class="col-md-6 form-group">
                            <label for="inputLastName2" class="form-label" style="font-size:large" >National ID/Passport (PDF Format, Not larger than 2mb)</label>

                                <input name="national_id" class="form-control"  type="file" id="national_id" >
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('national_id'),'style' => 'color: red','class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('national_id')),'style' => 'color: red','class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>


                        </div>
                    <div class="col-md-6 form-group">
                            <label for="photo" class="form-label" style="font-size:large" >Profile Photo (PNG/JPG Picture Format)</label>
                            <div class="form-group">
                                <input name="photo" class="form-control" type="file" id="photo" >
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('photo'),'style' => 'color: red','class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('photo')),'style' => 'color: red','class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>

                            </div>
                        </div>





                    <div class="col-md-6 form-group">
                            <label for="photo" class="form-label" style="font-size:large" >Preview</label>

                                <img  id="showImage" src="<?php echo e((!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo):url('upload/no_image.jpg')); ?>" alt="Admin" style="width:100px; height: 100px;"  >



                        </div>








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
                    firstname: {
                        required : true,
                    },
                    title_id: {
                        required : true,
                    },
                    gender_id: {
                        required : true,
                    },
                    dob: {
                        required : true,
                    },
                    country_id: {
                        required : true,
                    },
                    nationality: {
                        required : true,
                    },
                    county: {
                        required : true,
                    },
                    address: {
                        required : true,
                    },
                    city: {
                        required : true,
                    },
                    physical_address: {
                        required : true,
                    },
                    phone: {
                        required : true,
                    },
                    next_of_kin: {
                        required : true,
                    },
                    next_of_kin_contact: {
                        required : true,
                    },
                    national_id: {
                        required : true,
                    },
                    photo: {
                        required : true,
                    },
                    nationalid: {
                        required : true,
                    },
                },
                messages :{
                    surname: {
                        required : 'Surname Required',
                    },
                    firstname: {
                        required : 'First Name Required',
                    },
                    title_id: {
                        required : 'Please Select Salutation',
                    },
                    gender_id: {
                        required : 'Please Select Your Sex',
                    },
                    dob: {
                        required : 'Please Enter Date of Birth',
                    },
                    country_id: {
                        required : 'Please Select Country of Birth',
                    },
                    nationality: {
                        required : 'Please Select Nationality',
                    },
                    county: {
                        required : 'Please Select County of Residence',
                    },
                    address: {
                        required : 'Please Input Postal Address',
                    },
                    city: {
                        required : 'Please input City/Town',
                    },
                    physical_address: {
                        required : 'Please input Physical Address',
                    },
                    phone: {
                        required : 'Please input Phone Number',
                    },
                    next_of_kin: {
                        required : 'Please input Next of Kin',
                    },
                    next_of_kin_contact: {
                        required : 'Please input Next of Kin Contact',
                    },
                    national_id: {
                        required : 'Please Upload National ID/Passport',
                    },
                    photo: {
                        required : 'Please Upload Passport Size Photo',
                    },
                    nationalid: {
                        required : 'Please Input National ID/Passport Number',
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


<?php $__env->stopSection(); ?>

<?php echo $__env->make('applicant.applicant_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/applicant/apply/account.blade.php ENDPATH**/ ?>
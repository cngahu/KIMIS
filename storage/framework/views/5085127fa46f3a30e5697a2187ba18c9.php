<?php echo csrf_field(); ?>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white border-0 pb-0">
        <h5 class="mb-1">Training Details</h5>
        <p class="text-muted small mb-0">
            Fill in the information below to create or update a training.
        </p>
    </div>

    <div class="card-body">
        <div class="row g-3">

            
            <div class="col-md-6">
                <label class="form-label fw-bold">Course <span class="text-danger">*</span></label>
                <select
                    name="course_id"
                    class="form-select <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="">-- Select Course --</option>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($courseItem->id); ?>"
                            <?php echo e((int) old('course_id', $training->course_id ?? 0) === $courseItem->id ? 'selected' : ''); ?>>
                            <?php echo e($courseItem->course_name); ?> (<?php echo e($courseItem->course_code); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php else: ?>
                    <small class="text-muted">Select the course for this training.</small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-md-6">
                <label class="form-label fw-bold">College <span class="text-danger">*</span></label>
                <select
                    name="college_id"
                    class="form-select <?php $__errorArgs = ['college_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="">-- Select College --</option>
                    <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collegeItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($collegeItem->id); ?>"
                            <?php echo e((int) old('college_id', $training->college_id ?? 0) === $collegeItem->id ? 'selected' : ''); ?>>
                            <?php echo e($collegeItem->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['college_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php else: ?>
                    <small class="text-muted">Select the college offering this training.</small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-md-6">
                <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                <input
                    type="date"
                    name="start_date"
                    class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('start_date', isset($training->start_date) ? $training->start_date->format('Y-m-d') : '')); ?>"
                >
                <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php else: ?>
                    <small class="text-muted">When the training is scheduled to start.</small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-md-6">
                <label class="form-label fw-bold">End Date</label>
                <input
                    type="date"
                    name="end_date"
                    class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('end_date', isset($training->end_date) ? $training->end_date->format('Y-m-d') : '')); ?>"
                >
                <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php else: ?>
                    <small class="text-muted">When the training is expected to end.</small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>


        </div>
    </div>

    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
        <span class="text-muted small">
            <span class="text-danger">*</span> Required fields
        </span>
        <div>
            <a href="<?php echo e(route('all.trainings')); ?>" class="btn btn-light border me-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <?php echo e($buttonText ?? 'Save'); ?>

            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/trainings/_form.blade.php ENDPATH**/ ?>
<?php $__env->startSection('admin'); ?>
    <div class="container">

        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Add Course Requirements</h1>
                <p class="text-muted mb-0">
                    Course: <strong><?php echo e($course->course_name); ?></strong>
                    (<?php echo e($course->course_code); ?>)
                </p>
            </div>

            <a href="<?php echo e(route('all.courses')); ?>" class="btn btn-light border">
                Back to Courses
            </a>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success py-2"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="mb-1">Entry Requirements</h5>
                <p class="text-muted small mb-0">
                    Specify the entry requirements for this course (e.g. minimum grades, prior qualifications, work experience).
                </p>
            </div>

            <form action="<?php echo e(route('courses.requirements.store', $course)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Requirement Details <span class="text-danger">*</span></label>
                        <textarea
                            name="course_requirement"
                            rows="5"
                            class="form-control <?php $__errorArgs = ['course_requirement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="e.g. KCSE Mean Grade C-, at least C- in Mathematics and English, or equivalent; Diploma holders in related fields may also apply..."
                        ><?php echo e(old('course_requirement')); ?></textarea>
                        <?php $__errorArgs = ['course_requirement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php else: ?>
                            <small class="text-muted">You can describe all the requirements in a paragraph or bullet format.</small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        After saving, you will be redirected back to the course list.
                    </span>
                    <div>
                        <a href="<?php echo e(route('all.courses')); ?>" class="btn btn-light border me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Save Requirement
                        </button>
                    </div>
                </div>
            </form>
        </div>

        
        <?php if($requirements->count()): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-1">Existing Requirements</h5>
                    <p class="text-muted small mb-0">These are already stored for this course.</p>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item">
                                <?php echo nl2br(e($req->course_requirement)); ?>

                                <div class="small text-muted mt-1">
                                    Added on <?php echo e($req->created_at->format('d M Y H:i')); ?>

                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/requirements/create.blade.php ENDPATH**/ ?>
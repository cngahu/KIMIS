<?php $__env->startSection('admin'); ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Course Details</h1>
                <p class="text-muted mb-0">
                    View full details of this course.
                </p>
            </div>
            <div>
                <a href="<?php echo e(route('all.courses')); ?>" class="btn btn-light border me-2">
                    Back to Courses
                </a>
                <a href="<?php echo e(route('courses.edit', $course)); ?>" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h3 class="card-title mb-3"><?php echo e($course->course_name); ?></h3>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p>
                            <strong>Category:</strong>
                            <span class="badge
                                <?php if($course->course_category == 'Diploma'): ?> bg-primary
                                <?php elseif($course->course_category == 'Craft'): ?> bg-success
                                <?php elseif($course->course_category == 'Higher Diploma'): ?> bg-warning text-dark
                                <?php else: ?> bg-info text-dark <?php endif; ?>">
                                <?php echo e($course->course_category); ?>

                            </span>
                        </p>

                        <p><strong>Code:</strong> <code><?php echo e($course->course_code); ?></code></p>

                        <p>
                            <strong>Mode:</strong>
                            <span class="badge
                                <?php if($course->course_mode == 'Long Term'): ?> bg-dark
                                <?php else: ?> bg-secondary <?php endif; ?>">
                                <?php echo e($course->course_mode); ?>

                            </span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Duration:</strong> <?php echo e($course->course_duration); ?> months</p>
                        <p><strong>Cost:</strong> KSh <?php echo e(number_format($course->cost, 2)); ?></p>

                        
                        <p class="mb-1">
                            <strong>Requirement:</strong>
                            <?php if($course->requirement): ?>
                                <span class="badge bg-success">Yes</span>
                                <a href="<?php echo e(route('courses.requirements.create', $course)); ?>"
                                   class="btn btn-sm btn-outline-primary ms-2">
                                    Manage Requirements
                                </a>
                            <?php else: ?>
                                <span class="badge bg-secondary">No specific requirements</span>
                            <?php endif; ?>
                        </p>

                        <?php if($course->target_group): ?>
                            <p class="mt-2">
                                <strong>Target Group:</strong><br>
                                <?php echo e($course->target_group); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if($course->requirement): ?>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Entry Requirements</h5>
                        <p class="text-muted small mb-0">
                            Below are the stored requirements for this course.
                        </p>
                    </div>
                    <a href="<?php echo e(route('courses.requirements.create', $course)); ?>"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Requirement
                    </a>
                </div>
                <div class="card-body">
                    <?php if($course->requirements->count()): ?>
                        <ul class="list-group">
                            <?php $__currentLoopData = $course->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-3">
                                        
                                        <div class="mb-1">
                                            <?php if($req->type === 'text'): ?>
                                                <span class="badge bg-light text-dark">Text</span>
                                            <?php elseif($req->type === 'upload'): ?>
                                                <span class="badge bg-info text-dark">Document</span>
                                            <?php endif; ?>
                                        </div>

                                        
                                        <?php if($req->type === 'text'): ?>
                                            <?php echo nl2br(e($req->course_requirement)); ?>

                                        <?php elseif($req->type === 'upload'): ?>
                                            <?php if($req->file_path): ?>
                                                <strong>Requirement document:</strong>
                                                <a href="<?php echo e(\Illuminate\Support\Facades\Storage::url($req->file_path)); ?>"
                                                   target="_blank">
                                                    View / Download
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">No file available.</span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <div class="small text-muted mt-1">
                                            Added on <?php echo e($req->created_at->format('d M Y H:i')); ?>

                                        </div>
                                    </div>

                                    
                                    <div>
                                        <form action="<?php echo e(route('courses.requirements.delete', [$course, $req])); ?>"
                                              method="POST"
                                              class="d-inline js-confirm-form"
                                              data-confirm-title="Delete this requirement?"
                                              data-confirm-text="This will permanently delete this requirement from the course."
                                              data-confirm-icon="warning"
                                              data-confirm-button="Yes, delete it"
                                              data-cancel-button="Cancel">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete Requirement">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted mb-0">
                            No requirements captured yet.
                            <a href="<?php echo e(route('courses.requirements.create', $course)); ?>">
                                Click here to add one.
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/courses/show.blade.php ENDPATH**/ ?>
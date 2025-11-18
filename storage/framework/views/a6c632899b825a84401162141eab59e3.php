<?php $__env->startSection('admin'); ?>
    <div class="container">
        <h1>Course Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title"><?php echo e($course->course_name); ?></h3>
                <p><strong>Category:</strong> <?php echo e($course->course_category); ?></p>
                <p><strong>Code:</strong> <?php echo e($course->course_code); ?></p>
                <p><strong>Mode:</strong> <?php echo e($course->course_mode); ?></p>
                <p><strong>Duration:</strong> <?php echo e($course->course_duration); ?> months</p>
                <p><strong>User ID:</strong> <?php echo e($course->user_id ?? '-'); ?></p>
            </div>
        </div>

        <a href="<?php echo e(route('courses.edit', $course)); ?>" class="btn btn-warning">Edit</a>
        <a href="<?php echo e(route('all.courses')); ?>" class="btn btn-secondary">Back</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/courses/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('admin'); ?>
    <div class="container">
        <h1>Create Training</h1>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('trainings.store')); ?>" method="POST">
            <?php echo $__env->make('admin.trainings._form', ['buttonText' => 'Create'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/trainings/create.blade.php ENDPATH**/ ?>
<?php $__env->startSection('admin'); ?>
    <div class="container">
        <h1>Training Details</h1>

        <div class="card mb-3">
            <div class="card-body">

                <h5 class="card-title mb-3">
                    <?php echo e(optional($training->course)->course_name ?? 'N/A'); ?>

                </h5>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Course:</strong> <?php echo e(optional($training->course)->course_name ?? '-'); ?></p>
                        <p class="mb-1"><strong>Course Code:</strong> <?php echo e(optional($training->course)->course_code ?? '-'); ?></p>
                        <p class="mb-1"><strong>College:</strong> <?php echo e(optional($training->college)->name ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Start Date:</strong>
                            <?php echo e($training->start_date ? $training->start_date->format('d M Y') : '-'); ?>

                        </p>
                        <p class="mb-1"><strong>End Date:</strong>
                            <?php echo e($training->end_date ? $training->end_date->format('d M Y') : '-'); ?>

                        </p>
                        <p class="mb-1"><strong>Status:</strong> <?php echo e($training->status ?? '-'); ?></p>
                    </div>
                </div>

                <p class="mb-1"><strong>Cost:</strong> KSh <?php echo e(number_format($training->cost, 2)); ?></p>
                <p class="mb-1"><strong>Created By:</strong> <?php echo e(optional($training->user)->name ?? '-'); ?></p>
                <p class="mb-1">
                    <strong>Created At:</strong>
                    <?php echo e($training->created_at ? $training->created_at->format('d M Y H:i') : '-'); ?>

                </p>
                <p class="mb-0">
                    <strong>Last Updated:</strong>
                    <?php echo e($training->updated_at ? $training->updated_at->format('d M Y H:i') : '-'); ?>

                </p>
            </div>
        </div>

        <a href="<?php echo e(route('trainings.edit', $training)); ?>" class="btn btn-warning">
            Edit
        </a>
        <a href="<?php echo e(route('all.trainings')); ?>" class="btn btn-secondary">
            Back
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/trainings/show.blade.php ENDPATH**/ ?>
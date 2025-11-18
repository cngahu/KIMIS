<?php $__env->startSection('admin'); ?>
    <style>
        .icon-brown {
            color: #6B3A0E !important;
        }
    </style>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="mb-0">Courses</h1>

            <div class="d-flex align-items-center gap-2">
                <form action="<?php echo e(route('all.courses')); ?>" method="GET" class="d-flex">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-sm me-2"
                        placeholder="Search by name, code, category..."
                        value="<?php echo e(request('search')); ?>"
                    >
                    <button class="btn btn-sm btn-outline-secondary me-1" type="submit">
                        Search
                    </button>
                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('all.courses')); ?>" class="btn btn-sm btn-outline-light border">
                            Clear
                        </a>
                    <?php endif; ?>
                </form>

                <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary btn-sm">
                    Add Course
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($courses->count()): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Code</th>
                        <th>Mode</th>
                        <th>Duration (months)</th>
                        <th style="width: 200px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($courses->firstItem() + $loop->index); ?></td>
                            <td><?php echo e($course->course_name); ?></td>
                            <td><?php echo e($course->course_category); ?></td>
                            <td><?php echo e($course->course_code); ?></td>
                            <td><?php echo e($course->course_mode); ?></td>
                            <td><?php echo e($course->course_duration); ?></td>
                            <td class="text-center">

                                <a href="<?php echo e(route('courses.show', $course)); ?>"
                                   class="btn btn-sm btn-outline-info"
                                   title="View Course">
                                    <i class="fa-solid fa-eye icon-brown"></i>
                                </a>

                                <a href="<?php echo e(route('courses.edit', $course)); ?>"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit Course">
                                    <i class="fa-solid fa-pen-to-square icon-brown"></i>
                                </a>

                                <form action="<?php echo e(route('courses.delete', $course)); ?>"
                                      method="POST"
                                      class="d-inline js-confirm-form"
                                      data-confirm-title="Delete this course?"
                                      data-confirm-text="This will permanently delete <?php echo e($course->course_name); ?>."
                                      data-confirm-icon="warning"
                                      data-confirm-button="Yes, delete it"
                                      data-cancel-button="No, keep it">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete Course">
                                        <i class="fa-solid fa-trash icon-brown"></i>
                                    </button>
                                </form>

                            </td>


                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="text-muted small">
                    Showing
                    <strong><?php echo e($courses->firstItem()); ?></strong>
                    to
                    <strong><?php echo e($courses->lastItem()); ?></strong>
                    of
                    <strong><?php echo e($courses->total()); ?></strong>
                    results
                    <?php if(request('search')): ?>
                        for "<strong><?php echo e(request('search')); ?></strong>"
                    <?php endif; ?>
                </div>
                <div>
                    <?php echo e($courses->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <?php if(request('search')): ?>
                    No courses found for "<strong><?php echo e(request('search')); ?></strong>".
                    <a href="<?php echo e(route('all.courses')); ?>">Clear search</a>
                <?php else: ?>
                    No courses found.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/courses/index.blade.php ENDPATH**/ ?>
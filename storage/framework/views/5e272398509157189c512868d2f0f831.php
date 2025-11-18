<?php $__env->startSection('admin'); ?>
    <style>
        .icon-brown {
            color: #6B3A0E !important;
        }
    </style>

    <div class="container">

        
        
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="mb-0">Trainings</h1>

            <a href="<?php echo e(route('trainings.create')); ?>" class="btn btn-primary btn-sm">
                Add Training
            </a>
        </div>

        
        <form action="<?php echo e(route('all.trainings')); ?>" method="GET" class="w-100 mb-3">
            <div class="row g-2">

                
                <div class="col-md-3">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-sm"
                        placeholder="Search by course or code..."
                        value="<?php echo e(request('search')); ?>"
                    >
                </div>

                
                <div class="col-md-2">
                    <select name="course_id" class="form-select form-select-sm">
                        <option value="">All Courses</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($courseItem->id); ?>"
                                <?php echo e((int) request('course_id') === $courseItem->id ? 'selected' : ''); ?>>
                                <?php echo e($courseItem->course_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="col-md-2">
                    <select name="college_id" class="form-select form-select-sm">
                        <option value="">All Colleges</option>
                        <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collegeItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($collegeItem->id); ?>"
                                <?php echo e((int) request('college_id') === $collegeItem->id ? 'selected' : ''); ?>>
                                <?php echo e($collegeItem->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($optStatus); ?>" <?php echo e(request('status') === $optStatus ? 'selected' : ''); ?>>
                                <?php echo e($optStatus); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="col-md-3 d-flex gap-2">

                    <button class="btn btn-sm text-white px-3 flex-fill"
                            style="background-color: #6B3A0E;"
                            type="submit">
                        Filter
                    </button>

                    <?php if(request('search') || request('status') || request('course_id') || request('college_id')): ?>
                        <a href="<?php echo e(route('all.trainings')); ?>"
                           class="btn btn-sm btn-outline-secondary px-3 flex-fill">
                            Reset
                        </a>
                    <?php endif; ?>

                </div>

            </div>
        </form>



        
        <?php if(session('success')): ?>
            <div class="alert alert-success py-2"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($trainings->count()): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 60px" class="text-center">#</th>
                        <th>Course</th>
                        <th>College</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th class="text-end">Cost (KSh)</th>
                        <th style="width: 190px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <td class="text-center">
                                <?php echo e($trainings->firstItem() + $loop->index); ?>

                            </td>

                            
                            <td><?php echo e(optional($training->course)->course_name ?? '-'); ?></td>
                            <td><?php echo e(optional($training->college)->name ?? '-'); ?></td>

                            
                            <td>
                                <?php if($training->start_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($training->start_date)->format('d M Y')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            
                            <td>
                                <?php if($training->end_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($training->end_date)->format('d M Y')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            
                            <td>
                                <?php if($training->status): ?>
                                    <?php
                                        $statusClass = match($training->status) {
                                            'Active'    => 'badge bg-success',
                                            'Pending'   => 'badge bg-warning text-dark',
                                            'Completed' => 'badge bg-primary',
                                            'Cancelled' => 'badge bg-danger',
                                            default     => 'badge bg-secondary',
                                        };
                                    ?>
                                    <span class="<?php echo e($statusClass); ?>"><?php echo e($training->status); ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            
                            <td class="text-end">
                                <?php echo e(number_format($training->cost, 2)); ?>

                            </td>

                            
                            <td class="text-center">
                                <a href="<?php echo e(route('trainings.show', $training)); ?>"
                                   class="btn btn-sm btn-outline-info"
                                   title="View Training">
                                    <i class="fa-solid fa-eye icon-brown"></i>
                                </a>

                                <a href="<?php echo e(route('trainings.edit', $training)); ?>"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit Training">
                                    <i class="fa-solid fa-pen-to-square icon-brown"></i>
                                </a>

                                <form action="<?php echo e(route('trainings.delete', $training)); ?>"
                                      method="POST"
                                      class="d-inline js-confirm-form"
                                      data-confirm-title="Delete this training?"
                                      data-confirm-text="This will permanently delete this training record."
                                      data-confirm-icon="warning"
                                      data-confirm-button="Yes, delete it"
                                      data-cancel-button="No, keep it">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete Training">
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
                    <strong><?php echo e($trainings->firstItem()); ?></strong>
                    to
                    <strong><?php echo e($trainings->lastItem()); ?></strong>
                    of
                    <strong><?php echo e($trainings->total()); ?></strong>
                    trainings
                    <?php if(request('search')): ?>
                        for "<strong><?php echo e(request('search')); ?></strong>"
                    <?php endif; ?>
                </div>
                <div>
                    <?php echo e($trainings->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <?php if(request('search') || request('status') || request('course_id') || request('college_id')): ?>
                    No trainings found for the current filters.
                    <a href="<?php echo e(route('all.trainings')); ?>">Clear filters</a>
                <?php else: ?>
                    No trainings found.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/trainings/index.blade.php ENDPATH**/ ?>
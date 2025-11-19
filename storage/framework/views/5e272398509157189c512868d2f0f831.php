<?php $__env->startSection('admin'); ?>
    <style>
        .icon-brown {
            color: #6B3A0E !important;
        }
    </style>
    <?php
        $authUser = auth()->user();
        $isHod    = $authUser->hasRole('hod');
        $isSuper  = $authUser->hasRole('superadmin');
        $isRegistrar = $authUser->hasAnyRole(['campus_registrar', 'kihbt_registrar']);
    ?>

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

                                <?php


                                    $status = $training->status;

                                    $badgeClass = match ($status) {
                                        \App\Models\Training::STATUS_DRAFT                 => 'badge bg-secondary',
                                        \App\Models\Training::STATUS_PENDING_REGISTRAR     => 'badge bg-warning text-dark',
                                        \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ => 'badge bg-info text-dark',
                                        \App\Models\Training::STATUS_HQ_REVIEWED           => 'badge bg-primary',
                                        \App\Models\Training::STATUS_APPROVED              => 'badge bg-success',
                                        \App\Models\Training::STATUS_REJECTED              => 'badge bg-danger',
                                        default                                => 'badge bg-secondary',
                                    };
                                ?>

                                
                                <span class="<?php echo e($badgeClass); ?>">
        <?php echo e($status); ?>

    </span>

                                
                                <?php if($training->status ===  \App\Models\Training::STATUS_REJECTED && $training->rejection_comment): ?>
                                    <span
                                        class="ms-1 text-warning"
                                        style="cursor: pointer;"
                                        data-bs-toggle="tooltip"
                                        data-bs-html="true"
                                        title="
                <strong>Returned with comments</strong><br>
                Stage: <?php echo e(ucfirst(str_replace('_',' ', $training->rejection_stage))); ?><br>
                <?php echo e($training->rejection_comment); ?><br>
                <?php if($training->rejected_at): ?>
                    <small class='text-muted'>On <?php echo e($training->rejected_at->format('d M Y H:i')); ?></small>
                <?php endif; ?>
            "
                                    >
            <i class="fa-solid fa-circle-exclamation"></i>
        </span>
                                <?php endif; ?>

                            </td>



                            


                            
                            <td class="text-center">
                                
                                <a href="<?php echo e(route('trainings.show', $training)); ?>"
                                   class="btn btn-sm btn-outline-info"
                                   title="View Training">
                                    <i class="fa-solid fa-eye icon-brown"></i>
                                </a>

                                <?php
                                    $user = Auth::user();
                                    $isHod      = $user->hasRole('hod');
                                    $isCampus   = $user->hasRole('campus_registrar');
                                    $isKihbt    = $user->hasRole('kihbt_registrar');
                                    $isDirector = $user->hasRole('director');
                                    $isSuper    = $user->hasRole('superadmin');
                                ?>

                                
                                <?php if(($isHod && $training->isEditableByHod()) || $isSuper): ?>
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
                                <?php endif; ?>

                                
                                <?php if(($isHod || $isSuper) && $training->isEditableByHod()): ?>
                                    <form action="<?php echo e(route('trainings.send_for_approval', $training)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Send to Registrar for Approval">
                                            <i class="fa-solid fa-paper-plane icon-brown"></i> Submit
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <?php if(($isCampus || $isSuper) && $training->status === \App\Models\Training::STATUS_PENDING_REGISTRAR): ?>
                                    <form action="<?php echo e(route('trainings.registrar_approve', $training)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-success"
                                                title="Approve and send to HQ">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>

                                    <form action="<?php echo e(route('trainings.registrar_reject', $training)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Reject training">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <?php if(($isKihbt || $isSuper) && $training->status === \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ): ?>
                                    <form action="<?php echo e(route('trainings.hq_review', $training)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-primary"
                                                title="Mark as HQ Reviewed">
                                            <i class="fa-solid fa-search"></i> HQ Review
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <?php if(($isDirector || $isSuper) && $training->status === \App\Models\Training::STATUS_HQ_REVIEWED): ?>
                                    <form action="<?php echo e(route('trainings.director_approve', $training)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-success"
                                                title="Final Approve">
                                            <i class="fa-solid fa-check-double"></i>
                                        </button>
                                    </form>

                                    <form action="<?php echo e(route('trainings.director_reject', $training)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Reject">
                                            <i class="fa-solid fa-times-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
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

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/trainings/index.blade.php ENDPATH**/ ?>
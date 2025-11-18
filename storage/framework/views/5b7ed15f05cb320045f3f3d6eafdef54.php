<?php $__env->startSection('admin'); ?>
    <style>
        .icon-brown { color: #6B3A0E !important; }

        .dataTables_filter input {
            border: 1px solid #dee2e6 !important;
            border-radius: 4px !important;
        }
    </style>

    <div class="container-fluid">

        
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="h3 mb-0">Courses Management</h1>
            <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Course
            </a>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>




        
        
        <form method="GET" action="<?php echo e(route('all.courses')); ?>" class="row g-2 mb-3">

            
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search name, code or category..."
                       value="<?php echo e(request('search')); ?>">
            </div>

            
            <div class="col-md-2">
                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php $__currentLoopData = [10, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($size); ?>" <?php echo e(request('per_page', 10) == $size ? 'selected' : ''); ?>>
                            Show <?php echo e($size); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div class="col-md-2 d-grid">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>

            
            <?php if(request('search') || request('per_page')): ?>
                <div class="col-md-2 d-grid">
                    <a href="<?php echo e(route('all.courses')); ?>" class="btn btn-sm btn-secondary">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                </div>
            <?php endif; ?>
        </form>




        <div class="card-body">
                <div class="table-responsive">
                    <table id="coursesTable" class="table table-hover table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="35%">Course Name</th>
                            <th width="12%">Category</th>
                            <th width="10%">Code</th>
                            <th width="10%">Mode</th>
                            <th width="8%">Duration</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($courses->firstItem() + $loop->index); ?></td>

                                <td><strong><?php echo e($course->course_name); ?></strong></td>

                                <td>
                                    <span class="badge
                                        <?php if($course->course_category == 'Diploma'): ?> bg-primary
                                        <?php elseif($course->course_category == 'Craft'): ?> bg-success
                                        <?php elseif($course->course_category == 'Higher Diploma'): ?> bg-warning text-dark
                                        <?php else: ?> bg-info text-dark <?php endif; ?>">
                                        <?php echo e($course->course_category); ?>

                                    </span>
                                </td>

                                <td><code class="bg-light px-2 py-1 rounded"><?php echo e($course->course_code); ?></code></td>

                                <td>
                                    <span class="badge
                                        <?php if($course->course_mode == 'Long Term'): ?> bg-dark
                                        <?php else: ?> bg-secondary <?php endif; ?>">
                                        <?php echo e($course->course_mode); ?>

                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="fw-bold text-primary"><?php echo e($course->course_duration); ?> months</span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo e(route('courses.show', $course)); ?>" class="btn btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('courses.edit', $course)); ?>" class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('courses.delete', $course)); ?>" method="POST"
                                              class="d-inline js-confirm-form"
                                              data-confirm-title="Delete Course?"
                                              data-confirm-text="Delete '<?php echo e($course->course_name); ?>'? Action cannot be undone."
                                              data-confirm-icon="warning">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>

                
                <?php if($courses->hasPages()): ?>
                    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="text-muted small">
                            Showing <strong><?php echo e($courses->firstItem()); ?></strong>
                            to <strong><?php echo e($courses->lastItem()); ?></strong>
                            of <strong><?php echo e($courses->total()); ?></strong> courses
                        </div>

                        <div>
                            <?php echo e($courses->links('pagination::bootstrap-5')); ?>

                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function () {
            $('#coursesTable').DataTable({
                paging: false,      // disable DataTables pagination
                info: false,        // hide "showing x of y"
                responsive: true,
                order: [[1, 'asc']],
                language: { search: "_INPUT_", searchPlaceholder: "Search courses..." },
                columnDefs: [
                    { targets: [0, 6], orderable: false, searchable: false },
                    { targets: '_all', className: 'align-middle' }
                ]
            });

            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/admin/courses/index.blade.php ENDPATH**/ ?>
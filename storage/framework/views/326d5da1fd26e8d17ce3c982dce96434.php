<?php $__env->startSection('admin'); ?>

    <div class="page-content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">All Roles Permission</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">All Roles Permission</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="<?php echo e(route('add.roles.permission')); ?>" class="btn btn-primary">Add Role in Permission </a>
                    </div>
                </div>
            </div>

            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <table  class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Roles Name </th>
                                    <th>Permission Name </th>
                                    <th width="18%">Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key+1); ?></td>
                                        <td><?php echo e($item->name); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $item->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge rounded-pill bg-danger"> <?php echo e($perm->name); ?> </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </td>
                                        <td width="18%">
                                            <a href="<?php echo e(route('admin.edit.roles',$item->id)); ?>" class="btn btn-primary rounded-pill waves-effect waves-light">Edit</a>
                                            <a href="<?php echo e(route('admin.delete.roles',$item->id)); ?>" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->




        </div> <!-- container -->

    </div> <!-- content -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rukada starter\resources\views/backend/pages/roles/all_roles_permission.blade.php ENDPATH**/ ?>
<?php $__env->startSection('admin'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="alert alert-danger mt-4">
                <h4>No Permission</h4>
                <p>You do not have permission to access this page.</p>
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->







<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/errors/no-permission.blade.php ENDPATH**/ ?>
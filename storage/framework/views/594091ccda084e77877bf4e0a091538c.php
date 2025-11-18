<?php $__env->startComponent('mail::message'); ?>
    # Your Verification Code

    Dear User,

    We received a request to verify your login to **Kihbit ERP**.
    Please use the One-Time Password (OTP) below to continue:

    <?php $__env->startComponent('mail::panel'); ?>
        ## <?php echo e($code); ?>

    <?php echo $__env->renderComponent(); ?>

    This code is valid for **10 minutes**.

    If you did not request this code, you can safely ignore this email.
    For security, kindly ensure that you keep your account credentials confidential.

    Thanks,<br>
    **Kihbit ERP Team**

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\kimis.ac.ke\resources\views/emails/otp.blade.php ENDPATH**/ ?>
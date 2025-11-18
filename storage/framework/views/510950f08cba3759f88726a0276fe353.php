<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - KIHBT Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7f9;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

<!-- Container -->
<div class="w-full max-w-md bg-white shadow-xl rounded-xl overflow-hidden">

    <!-- Header Bar -->
    <div class="bg-[#006699] text-white text-center py-5">
        <h2 class="text-lg font-semibold">KIHBT Portal – Secure Verification</h2>
    </div>

    <!-- Body -->
    <div class="px-8 py-8">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Verify Your OTP</h1>
            <p class="text-gray-600 mt-2 text-sm">
                A 6-digit verification code has been sent to your email.
            </p>
        </div>

        <!-- Status Message -->
        <?php if(session('status')): ?>
            <div class="mb-4 p-3 rounded-lg bg-green-100 border border-green-300 text-green-800 text-sm">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 border border-red-300 text-red-800 text-sm">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('otp.verify')); ?>">
            <?php echo csrf_field(); ?>

            <label class="block text-gray-700 font-semibold mb-1">Enter OTP</label>

            <input
                type="text"
                name="otp"
                maxlength="6"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#006699] focus:outline-none text-center text-xl tracking-widest"
                placeholder="000000"
                required
            >

            <button
                type="submit"
                class="w-full bg-[#006699] hover:bg-[#005580] transition-all text-white font-semibold py-3 rounded-lg shadow-md mt-5"
            >
                Verify OTP
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-600 text-sm">Didn't receive the code?</p>

            <a href="<?php echo e(route('otp.resend')); ?>"
               class="text-[#006699] font-semibold hover:underline text-sm">
                Resend OTP
            </a>
        </div>

        <div class="text-center mt-6">
            <a href="/login" class="text-gray-500 text-xs hover:underline">
                Back to Login
            </a>
        </div>

    </div>

    <!-- Footer -->
    <div class="bg-gray-100 py-3 text-center text-[11px] text-gray-500 border-t">
        © <?php echo e(date('Y')); ?> Kenya Institute of Highways and Building Technology (KIHBT).
        All rights reserved.
    </div>

</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/auth/verify-otp.blade.php ENDPATH**/ ?>
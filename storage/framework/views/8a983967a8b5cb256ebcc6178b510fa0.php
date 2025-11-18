<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>KIHBT – Create Account</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        :root {
            --primary:#3b2818;
            --secondary:#f9a90f;
            --tertiary:#858585;
            --ink:#26211d;
            --line:#e5e7eb;
            --card:#ffffff;
            --bg:#f5f6f5;
        }

        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins', sans-serif;
            min-height:100vh;
            background:
                radial-gradient(800px 400px at 8% -10%, rgba(38,33,29,.06), transparent 60%),
                radial-gradient(800px 400px at 92% 110%, rgba(249,169,15,.10), transparent 60%),
                var(--bg);
            color:var(--ink);
            display:flex;align-items:center;justify-content:center;
            padding:1.2rem;
        }

        /* Shell */
        .auth-shell{
            max-width:1000px;width:100%;
            border-radius:22px;overflow:hidden;
            background:rgba(255,255,255,0.9);
            border:1px solid rgba(0,0,0,0.04);
            backdrop-filter:blur(10px);
            box-shadow:0 22px 60px rgba(0,0,0,0.10);
        }

        /* Header */
        .form-header {
            padding:1.5rem 2rem;
            background:radial-gradient(circle at bottom right, rgba(59,40,24,.85), #1d120b);
            color:#f5f3ef;
            text-align:center;
        }

        .header-content {
            display:flex;
            align-items:center;
            justify-content:center;
            gap:1rem;
            margin-bottom:0.5rem;
        }

        .header-logo{height:50px;width:auto;}
        .header-title{font-weight:800;font-size:1rem;text-transform:uppercase;line-height:1.3;}
        .header-tagline{font-size:.8rem;opacity:.85;}

        /* Form Column */
        .form-column{
            padding:2rem 2rem;
        }

        .login-card{
            width:100%;
            background:var(--card);
            position:relative;
        }

        .current-date{
            position:absolute;right:0;top:-2rem;
            font-size:.78rem;color:var(--tertiary);font-weight:600;
        }

        .title{font-size:1.5rem;font-weight:800;margin-bottom:.3rem;color:var(--primary);text-align:center;}
        .subtitle{font-size:.85rem;color:var(--tertiary);margin-bottom:1.2rem;text-align:center;}

        /* Two-column form layout */
        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group{margin-bottom:1rem;}
        label{font-size:.82rem;font-weight:600;margin-bottom:.28rem;display:block;}
        .input-wrapper{position:relative;}

        input{
            width:100%;padding:.75rem .9rem;font-size:.92rem;
            border-radius:12px;border:1px solid var(--line);
        }
        input:focus{outline:none;border-color:var(--secondary);box-shadow:0 0 0 2px rgba(249,169,15,.23);}

        .toggle-pass{
            position:absolute;right:.75rem;top:50%;transform:translateY(-50%);
            background:none;border:none;color:var(--tertiary);cursor:pointer;font-size:.9rem;
        }

        .error-msg{color:#b3261e;font-size:.75rem;margin-top:.25rem;display:block;}

        .btn{
            width:100%;padding:.8rem;border:none;border-radius:999px;
            font-size:.92rem;font-weight:700;cursor:pointer;color:#fff;
            background:linear-gradient(90deg,var(--primary),#000);
            margin-bottom:.65rem;transition:.16s ease;
            grid-column: 1 / -1;
        }
        .btn:hover{opacity:.94;transform:translateY(-1px);}

        .terms-check {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 1rem 0;
            font-size: .8rem;
            grid-column: 1 / -1;
        }

        .terms-check input {
            width: auto;
            margin-top: 3px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        @media (max-width: 768px) {
            .form-container {
                grid-template-columns: 1fr;
            }

            .header-content {
                flex-direction: column;
                gap: 0.5rem;
            }

            .header-title {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-shell">
    <!-- Header -->
    <div class="form-header">
        <div class="header-content">
            <img src="<?php echo e(asset('adminbackend/assets/images/logokihbt.png')); ?>" class="header-logo">
            <div>
                <div class="header-title">Kenya Institute of Highways & Building Technology</div>
                <div class="header-tagline">Empowering skills for roads, transport & construction</div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <section class="form-column">
        <div class="login-card">
            <div class="current-date" id="currentDate"></div>

            <h2 class="title">Create Account</h2>
            <p class="subtitle">Join KIHBT to access our training programs</p>

            <form id="registerForm" method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-container">
                    <!-- Left Column -->
                    <div class="form-column-left">
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input id="surname" name="surname" type="text" placeholder="Enter surname" required value="<?php echo e(old('surname')); ?>">
                            <?php if($errors->has('surname')): ?>
                                <span class="error-msg"><?php echo e($errors->first('surname')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input id="firstname" name="firstname" type="text" placeholder="Enter first name" required value="<?php echo e(old('firstname')); ?>">
                            <?php if($errors->has('firstname')): ?>
                                <span class="error-msg"><?php echo e($errors->first('firstname')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <input id="password" name="password" type="password" placeholder="Create password" required>
                                <button type="button" class="toggle-pass">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                            <?php if($errors->has('password')): ?>
                                <span class="error-msg"><?php echo e($errors->first('password')); ?></span>
                            <?php endif; ?>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="form-column-right">
                        <div class="form-group">
                            <label for="othername">Other Names</label>
                            <input id="othername" name="othername" type="text" placeholder="Enter other names" value="<?php echo e(old('othername')); ?>">
                            <?php if($errors->has('othername')): ?>
                                <span class="error-msg"><?php echo e($errors->first('othername')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" name="email" type="email" placeholder="Enter email address" required value="<?php echo e(old('email')); ?>">
                            <?php if($errors->has('email')): ?>
                                <span class="error-msg"><?php echo e($errors->first('email')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="input-wrapper">
                                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" required>
                                <button type="button" class="toggle-pass">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="error-msg"><?php echo e($errors->first('password_confirmation')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Full-width elements -->
                    <div class="terms-check">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I agree to the <a href="#" style="color: var(--secondary);">Terms & Conditions</a> and <a href="#" style="color: var(--secondary);">Privacy Policy</a></label>
                    </div>

                    <?php if($errors->has('terms')): ?>
                        <span class="error-msg full-width"><?php echo e($errors->first('terms')); ?></span>
                    <?php endif; ?>

                    <button type="submit" class="btn">Create Account</button>

                    <div class="text-center mt-3 full-width" style="font-size: .85rem;">
                        Already have an account? <a href="<?php echo e(route('login')); ?>" style="color: var(--secondary);">Sign in here</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    // Date
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-GB');

    // Password toggle
    const togglePasswordButtons = document.querySelectorAll('.toggle-pass');
    togglePasswordButtons.forEach(button => {
        button.onclick = function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            input.type = input.type === "password" ? "text" : "password";
            icon.classList.toggle('fa-eye-slash');
            icon.classList.toggle('fa-eye');
        };
    });

    // Form validation for terms
    document.getElementById('registerForm').addEventListener('submit', e => {
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            e.preventDefault();
            alert('Please agree to the Terms & Conditions to continue.');
        }
    });
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\PROJECT2\KIMIS\resources\views/auth/register.blade.php ENDPATH**/ ?>
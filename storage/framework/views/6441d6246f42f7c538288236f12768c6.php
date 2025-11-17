<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kenya Institute of Highways and Building Technology (KIHBT) – Secure Login</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        :root {
            --primary:#26211d;
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
            background:
                radial-gradient(900px 450px at 10% -10%, rgba(38,33,29,.06), transparent 60%),
                radial-gradient(900px 450px at 90% 110%, rgba(249,169,15,.10), transparent 60%),
                var(--bg);
            display:flex;align-items:center;justify-content:center;
            min-height:100vh;padding:1.2rem;
            color:var(--ink);
        }

        .login-card{
            display:flex;flex-wrap:wrap;
            max-width:1120px;width:100%;
            border-radius:20px;overflow:hidden;
            background:var(--card);
            border:1px solid var(--line);
            box-shadow:0 24px 70px rgba(0,0,0,0.10);
            transition:.3s ease;
        }

        .login-card:hover{transform:translateY(-4px);}

        /* Brand Pane */
        .brand-pane{
            flex:0 0 42%;
            background:linear-gradient(180deg, var(--primary), #000);
            color:#f4f4f4;text-align:center;
            display:flex;align-items:center;justify-content:center;
            padding:3rem 2.5rem;
        }
        @media(max-width:860px){ .brand-pane{flex-basis:100%;} }

        .brand-logo{height:75px;margin-bottom:1rem;}
        .brand-name{font-size:1.15rem;font-weight:800;text-transform:uppercase;line-height:1.35;}
        .brand-tag{font-size:.9rem;margin-top:.5rem;color:#e4e4e4;}

        /* Form Pane */
        .form-pane{flex:1;padding:3.2rem 3rem;position:relative;background:#fff;}
        @media(max-width:860px){ .form-pane{padding:2rem;} }

        .current-date{position:absolute;right:1.2rem;top:1rem;font-size:.85rem;color:var(--tertiary);font-weight:600;}

        .title{
            font-size:1.8rem;font-weight:800;text-transform:uppercase;
            text-align:center;margin-bottom:.4rem;
            background:linear-gradient(90deg,var(--primary),#000);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;
        }
        .subtitle{text-align:center;font-size:.95rem;color:var(--tertiary);margin-bottom:1.4rem;}

        .form-group{margin-bottom:1.15rem;}
        label{display:block;font-size:.9rem;font-weight:600;margin-bottom:.35rem;color:var(--ink);}
        .input-wrapper{position:relative;}

        input{
            width:100%;font-size:1rem;padding:.85rem 1rem;
            border:1px solid var(--line);border-radius:12px;
            transition:.2s ease;
        }
        input:focus{
            outline:none;border-color:var(--secondary);
            box-shadow:0 0 0 3px rgba(249,169,15,0.25);
        }

        .toggle-pass{
            position:absolute;right:.9rem;top:50%;transform:translateY(-50%);
            background:none;border:none;color:var(--tertiary);font-size:1rem;cursor:pointer;
        }

        .divider{height:2px;background:#efefef;margin:1.2rem 0;}

        /* Captcha */
        .captcha-row{display:flex;align-items:center;gap:.65rem;}
        #captchaEquation{font-weight:700;color:var(--primary);}
        .captcha-refresh{color:var(--secondary);cursor:pointer;}
        .error-msg{display:none;color:var(--red);font-size:.85rem;margin-top:.4rem;}

        .remember-forgot{
            display:flex;justify-content:space-between;margin:1rem 0 1.4rem;
            font-size:.88rem;color:var(--ink);
        }
        .remember-forgot a{color:var(--secondary);}

        .btn{
            width:100%;padding:.9rem;font-weight:700;border:none;
            border-radius:14px;cursor:pointer;color:#fff;
            background:linear-gradient(90deg,var(--primary),#000);
            margin-bottom:.8rem;transition:.18s ease;
        }
        .btn:hover{opacity:.92;}

        .btn-reset{
            background:#fff;color:var(--primary);
            border:2px solid var(--primary);
        }
        .btn-reset:hover{background:var(--primary);color:#fff;}
    </style>
</head>
<body>

<div class="login-card">

    <!-- Brand Pane -->
    <div class="brand-pane">
        <div>
            <img src="<?php echo e(asset('adminbackend/assets/images/logokihbt.png')); ?>" class="brand-logo" alt="KIHBT Logo">
            <div class="brand-name">Kenya Institute of Highways and Building Technology (KIHBT)</div>
            <div class="brand-tag">Empowering Skills in Transport, Infrastructure & Construction</div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="form-pane">
        <div class="current-date" id="currentDate"></div>

        <h1 class="title">Secure Login</h1>
        <p class="subtitle">Access the KIHBT student & administration portal</p>

        <form id="loginForm" method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="email">Username or Email</label>
                <input id="email" name="email" type="text" placeholder="Enter your username or email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input id="password" name="password" type="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-pass"><i class="fa-solid fa-eye-slash"></i></button>
                </div>
            </div>

            <div class="divider"></div>

            <label>Security Check</label>
            <div class="captcha-row">
                <span id="captchaEquation"></span>
                <i id="refreshCaptcha" class="fa-solid fa-arrows-rotate captcha-refresh"></i>
            </div>
            <input type="text" id="captchaAnswer" placeholder="Answer" required>
            <span class="error-msg" id="captchaError">Incorrect answer. Try again.</span>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Remember Me</label>
                <a href="<?php echo e(route('password.request')); ?>">Forgot Password?</a>
            </div>

            <button type="submit" class="btn">Login</button>
            <button type="button" class="btn btn-reset" onclick="document.getElementById('loginForm').reset()">Reset</button>
        </form>
    </div>

</div>

<script>
    // Date
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-GB');

    // Show/Hide password
    const passInput=document.getElementById('password');
    document.querySelector('.toggle-pass').onclick=function(){
        const icon=this.querySelector('i');
        passInput.type=passInput.type==="password"?"text":"password";
        icon.classList.toggle('fa-eye-slash');
        icon.classList.toggle('fa-eye');
    };

    // CAPTCHA
    let correctAnswer=0;
    function generateCaptcha(){
        const a=Math.floor(Math.random()*11)+5;
        const b=Math.floor(Math.random()*11)+5;
        correctAnswer=a+b;
        document.getElementById('captchaEquation').textContent = `${a} + ${b} =`;
        document.getElementById('captchaAnswer').value="";
        document.getElementById('captchaError').style.display="none";
    }
    generateCaptcha();
    document.getElementById('refreshCaptcha').onclick=generateCaptcha;

    document.getElementById('loginForm').addEventListener('submit',e=>{
        if(parseInt(document.getElementById('captchaAnswer').value,10)!==correctAnswer){
            e.preventDefault();
            document.getElementById('captchaError').style.display="block";
            generateCaptcha();
        }
    });
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\kimis.ac.ke\resources\views/auth/login.blade.php ENDPATH**/ ?>
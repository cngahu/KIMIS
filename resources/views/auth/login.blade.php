<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>KIHBT – Secure Login</title>

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
            --error:#b3261e;
            --error-bg:#fef2f2;
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
            max-width:1100px;width:100%;
            border-radius:22px;overflow:hidden;
            background:rgba(255,255,255,0.9);
            border:1px solid rgba(0,0,0,0.04);
            backdrop-filter:blur(10px);
            box-shadow:0 22px 60px rgba(0,0,0,0.10);
        }
        .auth-layout{
            display:grid;grid-template-columns:1fr 0.9fr;
        }
        @media(max-width:900px){.auth-layout{grid-template-columns:1fr;}}

        /* Left Column Info */
        .info-column{
            padding:2.3rem 2.5rem;
            background:radial-gradient(circle at bottom right, rgba(59,40,24,.85), #1d120b);
            color:#f5f3ef;
            position:relative;
        }
        @media(max-width:900px){.info-column{text-align:center;padding-bottom:2.8rem;}}

        .info-header{display:flex;align-items:center;gap:.75rem;margin-bottom:1.4rem;}
        @media(max-width:900px){.info-header{justify-content:center;}}

        .info-logo{height:58px;width:auto;}
        .info-title{font-weight:800;font-size:.95rem;text-transform:uppercase;line-height:1.3;}
        .info-tagline{font-size:.82rem;opacity:.85;}

        .info-highlight h1{font-size:1.35rem;font-weight:700;margin-bottom:.35rem;}
        .info-highlight p{font-size:.9rem;color:#e8ddce;max-width:360px;line-height:1.45;}
        @media(max-width:900px){.info-highlight p{margin:0 auto;}}

        .info-meta{
            margin-top:1.6rem;font-size:.78rem;opacity:.9;
            display:flex;gap:1rem;flex-wrap:wrap;
        }
        .info-pill{
            background:rgba(0,0,0,0.22);
            padding:.55rem .85rem;border-radius:14px;
        }

        /* Right Column Form */
        .form-column{
            display:flex;align-items:center;justify-content:center;
            padding:2.2rem 2rem;
        }

        .login-card{
            width:100%;max-width:380px;
            background:var(--card);border-radius:18px;
            padding:2rem 1.75rem 2rem;
            border:1px solid var(--line);
            box-shadow:0 16px 38px rgba(0,0,0,0.06);
            position:relative;
        }

        .current-date{
            position:absolute;right:1.4rem;top:1rem;
            font-size:.78rem;color:var(--tertiary);font-weight:600;
        }

        .title{font-size:1.5rem;font-weight:800;margin-bottom:.3rem;color:var(--primary);}
        .subtitle{font-size:.85rem;color:var(--tertiary);margin-bottom:1.2rem;}

        .form-group{margin-bottom:1rem;}
        label{font-size:.82rem;font-weight:600;margin-bottom:.28rem;display:block;}
        .input-wrapper{position:relative;}

        input{
            width:100%;padding:.75rem .9rem .75rem 2.8rem;font-size:.92rem;
            border-radius:12px;border:1px solid var(--line);
            transition:border-color .2s ease, box-shadow .2s ease;
        }
        input:focus{outline:none;border-color:var(--secondary);box-shadow:0 0 0 2px rgba(249,169,15,.23);}
        
        /* ✅ Input icon spacing */
        .input-with-icon input{padding-left:2.8rem;}
        .input-icon{
            position:absolute;left:.9rem;top:50%;transform:translateY(-50%);
            color:var(--tertiary);font-size:.9rem;pointer-events:none;
        }

        /* ✅ Password toggle button */
        .toggle-pass{
            position:absolute;right:.75rem;top:50%;transform:translateY(-50%);
            background:none;border:none;color:var(--tertiary);cursor:pointer;font-size:.9rem;
            padding:.3rem;transition:color .2s ease;
        }
        .toggle-pass:hover{color:var(--primary);}

        /* ✅ Error states */
        input.is-invalid{
            border-color:var(--error);
            background-color:var(--error-bg);
        }
        input.is-invalid:focus{
            box-shadow:0 0 0 2px rgba(179,38,30,.2);
        }
        .error-msg{
            display:none;
            color:var(--error);
            font-size:.75rem;
            margin-top:.35rem;
            font-weight:500;
        }
        .error-msg.show{display:block;}

        /* ✅ Laravel validation error styling */
        .invalid-feedback{
            display:none;
            color:var(--error);
            font-size:.75rem;
            margin-top:.35rem;
            font-weight:500;
        }
        .is-invalid + .invalid-feedback{display:block;}

        .captcha-row{display:flex;align-items:center;gap:.55rem;margin-bottom:.25rem;font-size:.88rem;}
        #captchaEquation{font-weight:700;color:var(--primary);}
        .captcha-refresh{color:var(--secondary);cursor:pointer;transition:transform .2s ease;}
        .captcha-refresh:hover{transform:rotate(180deg);}

        .remember-forgot{
            display:flex;justify-content:space-between;align-items:center;
            margin:1rem 0 1.2rem;font-size:.8rem;
        }
        .remember-forgot a{color:var(--secondary);text-decoration:none;}
        .remember-forgot a:hover{text-decoration:underline;}

        .btn{
            width:100%;padding:.8rem;border:none;border-radius:999px;
            font-size:.92rem;font-weight:700;cursor:pointer;color:#fff;
            background:linear-gradient(90deg,var(--primary),#000);
            margin-bottom:.65rem;transition:.16s ease;
        }
        .btn:hover{opacity:.94;transform:translateY(-1px);}
        .btn:disabled{opacity:.7;cursor:not-allowed;transform:none;}

        .btn-reset{
            background:#fff;color:var(--primary);border:1px solid var(--primary);
        }
        .btn-reset:hover{background:var(--primary);color:#fff;}

        /* ✅ Session error alert */
        .alert-error{
            background:var(--error-bg);
            border:1px solid var(--error);
            color:var(--error);
            padding:.75rem 1rem;
            border-radius:10px;
            font-size:.85rem;
            margin-bottom:1rem;
            display:flex;
            align-items:center;
            gap:.5rem;
        }
        .alert-error i{font-size:1rem;}

        /* Mobile */
        @media(max-width:900px){
            .login-card{padding:1.8rem 1.4rem;}
            .info-column{text-align:center;padding-bottom:2.8rem;}
            .info-header{justify-content:center;}
            .info-highlight p{margin:0 auto;}
        }
    </style>
</head>
<body>

<div class="auth-shell">
    <div class="auth-layout">

        <!-- LEFT: Info Column -->
        <section class="info-column">
            <div class="info-header">
                <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="info-logo" alt="KIHBT Logo">
                <div>
                    <div class="info-title">Kenya Institute of Highways & Building Technology</div>
                    <div class="info-tagline">Empowering skills for roads, transport & construction</div>
                </div>
            </div>

            <div class="info-highlight">
                <h1>Welcome to the KIHBT Portal</h1>
                <p>Sign in to manage student records, applications and institutional services securely.</p>
            </div>

            <div class="info-meta">
                <div class="info-pill">Full-time Training</div>
                <div class="info-pill">Entry: C- (minus)</div>
                <div class="info-pill">Students & Staff</div>
            </div>
        </section>

        <!-- RIGHT: Login Form -->
        <section class="form-column">
            <div class="login-card">
                <div class="current-date" id="currentDate"></div>

                <h2 class="title">Login</h2>
                <p class="subtitle">Enter your credentials to continue</p>

                {{-- ✅ Display session errors (wrong credentials, etc.) --}}
                @if(session('error'))
                    <div class="alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- ✅ Display general validation errors --}}
                @if($errors->any() && !session('error'))
                    <div class="alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email/Username Field --}}
                    <div class="form-group">
                        <label for="email">Username or Email</label>
                        <div class="input-wrapper input-with-icon">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input
                                id="email"
                                name="email"
                                type="text"
                                class="@error('email') is-invalid @enderror"
                                placeholder="Enter username or email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                            >
                        </div>
                        {{-- ✅ Laravel email error --}}
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password Field with Toggle --}}
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper input-with-icon">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="@error('password') is-invalid @enderror"
                                placeholder="Enter password"
                                required
                                autocomplete="current-password"
                            >
                            {{-- ✅ Password visibility toggle --}}
                            <button type="button" class="toggle-pass" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                        {{-- ✅ Laravel password error --}}
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- CAPTCHA Field --}}
                    <div class="form-group">
                        <div class="captcha-row">
                            <span id="captchaEquation"></span>
                            <i id="refreshCaptcha" class="fa-solid fa-arrows-rotate captcha-refresh" title="Refresh"></i>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" id="captchaAnswer" placeholder="Answer" required autocomplete="off">
                        </div>
                        <span class="error-msg" id="captchaError">
                            <i class="fa-solid fa-circle-xmark"></i> Incorrect answer. Try again.
                        </span>
                    </div>

                    {{-- Remember Me + Forgot --}}
                    <div class="remember-forgot">
                        <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember Me</span>
                        </label>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>

                    {{-- Submit Buttons --}}
                    <button type="submit" class="btn" id="loginBtn">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                    </button>
                    <button type="button" class="btn btn-reset" onclick="document.getElementById('loginForm').reset(); generateCaptcha();">
                        Reset
                    </button>
                </form>

                {{-- Optional: Register link if needed --}}
                {{--
                <p style="text-align:center;margin-top:1.2rem;font-size:.85rem;color:var(--tertiary);">
                    New user? <a href="{{ route('register') }}" style="color:var(--secondary);text-decoration:none;font-weight:600;">Create account</a>
                </p>
                --}}

            </div>
        </section>

    </div>
</div>

<script>
    // ✅ Current Date
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-GB', { weekday:'long', year:'numeric', month:'short', day:'numeric' });

    // ✅ Password Visibility Toggle
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleBtn.addEventListener('click', function() {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        // Toggle icon
        toggleIcon.classList.toggle('fa-eye-slash');
        toggleIcon.classList.toggle('fa-eye');
        
        // Update aria-label for accessibility
        toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    });

    // ✅ CAPTCHA Logic
    let correctAnswer = 0;
    
    function generateCaptcha() {
        const a = Math.floor(Math.random() * 11) + 5; // 5-15
        const b = Math.floor(Math.random() * 11) + 5;
        correctAnswer = a + b;
        
        document.getElementById('captchaEquation').textContent = `${a} + ${b} =`;
        document.getElementById('captchaAnswer').value = '';
        document.getElementById('captchaError').classList.remove('show');
        
        // Focus captcha field for better UX
        setTimeout(() => document.getElementById('captchaAnswer').focus(), 100);
    }
    
    // Initialize CAPTCHA
    generateCaptcha();
    
    // Refresh CAPTCHA on click
    document.getElementById('refreshCaptcha').addEventListener('click', generateCaptcha);

    // ✅ Form Submission with CAPTCHA Validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const userAnswer = parseInt(document.getElementById('captchaAnswer').value, 10);
        
        if (userAnswer !== correctAnswer) {
            e.preventDefault();
            
            // Show error
            document.getElementById('captchaError').classList.add('show');
            
            // Shake animation for feedback
            const captchaInput = document.getElementById('captchaAnswer');
            captchaInput.style.borderColor = 'var(--error)';
            captchaInput.classList.add('is-invalid');
            
            // Regenerate CAPTCHA
            setTimeout(generateCaptcha, 800);
            
            // Reset styles after animation
            setTimeout(() => {
                captchaInput.style.borderColor = '';
                captchaInput.classList.remove('is-invalid');
            }, 1000);
        }
    });

    // ✅ Clear error styling when user starts typing
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorMsg = this.closest('.form-group')?.querySelector('.error-msg');
            if (errorMsg) errorMsg.classList.remove('show');
        });
    });

    // ✅ Auto-focus email field on load
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        if (emailInput && !emailInput.value) {
            emailInput.focus();
        }
    });
</script>

</body>
</html>
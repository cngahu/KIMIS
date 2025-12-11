<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>KIHBT – Reset Password</title>

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

        .info-highlight h1{justify-content:center;font-size:1.35rem;font-weight:700;margin-bottom:.35rem; text-align: center;}
        .info-highlight p{justify-content:center;font-size:.9rem;color:#e8ddce;max-width:360px;line-height:1.45; text-align: center;}
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
        /* Position icons inside inputs */
        .form-group {
            position:relative;
            margin-bottom:1rem;
        }

        /* Input icons aligned in the same line as text */
        .form-group i{
            position:absolute;
            left:1rem;
            top:50%;
            transform:translateY(-50%);
            color:var(--tertiary);
            font-size:1rem;
            pointer-events:none;
        }

        /* Add padding so text doesn't overlap the icon */
        .form-group input{
            width:100%;
            padding:0.85rem 1rem 0.85rem 2.8rem; /* <- IMPORTANT */
            border-radius:12px;
            border:1px solid var(--line);
            font-size:.92rem;
        }

        /* Padlock icon larger + centered */
        .reset-icon{
            text-align:center;
            margin-bottom:1rem;
            color:var(--primary);
        }
        .reset-icon i{
            font-size:4.2rem;
            display:block;
            margin:0 auto 0.5rem;
        }


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

        .fa-envelope:before {
            content: "\f0e0";
        }

        .captcha-row{display:flex;align-items:center;gap:.55rem;margin-bottom:.25rem;font-size:.88rem;}
        #captchaEquation{font-weight:700;color:var(--primary);}
        .captcha-refresh{color:var(--secondary);cursor:pointer;}

        .error-msg{display:none;color:#b3261e;font-size:.75rem;margin-top:.25rem;}

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

        .btn-reset{
            background:#fff;color:var(--primary);border:1px solid var(--primary);
        }
        .btn-reset:hover{background:var(--primary);color:#fff;}
    </style>
</head>
<body>

<div class="auth-shell">
    <div class="auth-layout">
        <section class="info-column">
            <div class="info-header">
                <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="info-logo">
                <div>
                    <div class="info-title">Kenya Institute of Highways & Building Technology</div>
                    <div class="info-tagline">Empowering skills for roads, transport & construction</div>
                </div>
            </div>

            <div class="info-highlight">
                <h1>Reset Your Password</h1>
                <p>
                    Enter your new password below.
                </p>
            </div>
            <!--
                        <div class="info-meta">
                            <div class="info-pill">Two-Factor Security</div>
                            <div class="info-pill">Account Protection</div>
                            <div class="info-pill">Students & Staff</div>
                        </div>
            -->
        </section>


        <section class="form-column">
            <div class="login-card">

                <div class="reset-icon">
                    <i class="fa-solid fa-key"></i>
                </div>

                <div class="reset-title">Reset Your Password</div>
                <div class="reset-subtitle">Enter your new password below</div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <i class="fa-solid fa-lock"></i>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="New password"
                            required
                        />

                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <i class="fa-solid fa-lock"></i>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm new password"
                            required
                        />

                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn">
                        Reset Password
                    </button>
                </form>

            </div>
        </section>

    </div>
</div>

</body>
</html>

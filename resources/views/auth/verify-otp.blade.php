<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Verify OTP – KIHBT Portal</title>

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

        .alert{
            padding:.65rem .75rem;border-radius:10px;
            font-size:.78rem;margin-bottom:.9rem;
        }
        .alert-error{
            background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
        }
        .alert-success{
            background:#ecfdf3;border:1px solid #bbf7d0;color:#166534;
        }

        label{font-size:.82rem;font-weight:600;margin-bottom:.28rem;display:block;}
        .otp-input{
            width:100%;padding:.8rem 1rem;font-size:1.2rem;
            border-radius:14px;border:1px solid var(--line);
            text-align:center;letter-spacing:.4em;
        }
        .otp-input:focus{
            outline:none;border-color:var(--secondary);
            box-shadow:0 0 0 2px rgba(249,169,15,.23);
        }

        .btn{
            width:100%;padding:.8rem;border:none;border-radius:999px;
            font-size:.92rem;font-weight:700;cursor:pointer;color:#fff;
            background:linear-gradient(90deg,var(--primary),#000);
            margin-top:.9rem;transition:.16s ease;
        }
        .btn:hover{opacity:.94;transform:translateY(-1px);}

        .helper-text{
            font-size:.78rem;color:var(--tertiary);margin-top:.6rem;text-align:center;
        }

        .resend-block{
            text-align:center;margin-top:1.4rem;font-size:.8rem;color:var(--tertiary);
        }
        .resend-block a{
            color:var(--secondary);text-decoration:none;font-weight:600;
        }
        .resend-block a:hover{text-decoration:underline;}

        .back-link{
            text-align:center;margin-top:1rem;
            font-size:.78rem;color:var(--tertiary);
        }
        .back-link a{
            color:var(--secondary);text-decoration:none;
        }
        .back-link a:hover{text-decoration:underline;}
    </style>
</head>
<body>

<div class="auth-shell">
    <div class="auth-layout">

        <!-- LEFT -->
        <section class="info-column">
            <div class="info-header">
                <img src="{{ asset('adminbackend/assets/images/logokihbt.jpeg') }}" class="info-logo">
                <div>
                    <div class="info-title">Kenya Institute of Highways & Building Technology</div>
                    <div class="info-tagline">Empowering skills for roads, transport & construction</div>
                </div>
            </div>

            <div class="info-highlight">
                <h1>Verify Your Login</h1>
                <p>
                    We’ve sent you a one-time verification code as an extra layer of security.
                    Enter the code below to complete your sign in.
                </p>
            </div>

            <div class="info-meta">
                <div class="info-pill">Two-Factor Security</div>
                <div class="info-pill">Account Protection</div>
                <div class="info-pill">Students & Staff</div>
            </div>
        </section>

        <!-- RIGHT -->
        <section class="form-column">
            <div class="login-card">
                <div class="current-date" id="currentDate"></div>

                <h2 class="title">Verify OTP</h2>
                <p class="subtitle">
                    A 6-digit verification code has been sent
                    @if(isset($channel) && $channel === 'sms')
                        to your <span style="font-weight:600;">phone via SMS</span>.
                    @else
                        to your <span style="font-weight:600;">email address</span>.
                    @endif
                </p>

                {{-- Status Message --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}">
                    @csrf

                    <label for="otp">Enter OTP</label>
                    <input
                        id="otp"
                        type="text"
                        name="otp"
                        maxlength="6"
                        class="otp-input"
                        placeholder="000000"
                        required
                        inputmode="numeric"
                        pattern="[0-9]*"
                    >

                    <button type="submit" class="btn">
                        Verify OTP
                    </button>
                </form>

                <div class="helper-text">
                    Make sure to enter the code exactly as it appears. It will expire after a few minutes.
                </div>

                <div class="resend-block">
                    <p>Didn't receive the code?</p>
                    <a href="{{ route('otp.resend', ['channel' => $channel ?? 'email']) }}">
                        Resend via {{ ($channel ?? 'email') === 'sms' ? 'SMS' : 'Email' }}
                    </a>
                </div>

                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="fa-solid fa-angle-left"></i> Back to Login
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>

<script>
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-GB');
</script>

</body>
</html>

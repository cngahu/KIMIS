<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>KIHBT – Verify Email</title>

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
            --success:#0f7b40;
            --warning:#a16207;
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
        .auth-layout{display:grid;grid-template-columns:1fr 0.9fr;}
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
        .info-highlight p{font-size:.9rem;color:#e8ddce;max-width:380px;line-height:1.45;}
        @media(max-width:900px){.info-highlight p{margin:0 auto;}}
        .info-meta{margin-top:1.6rem;font-size:.78rem;opacity:.9;display:flex;gap:1rem;flex-wrap:wrap;}
        .info-pill{background:rgba(0,0,0,0.22);padding:.55rem .85rem;border-radius:14px;}

        .form-column{display:flex;align-items:center;justify-content:center;padding:2.2rem 2rem;}
        .login-card{
            width:100%;max-width:420px;
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
        .subtitle{font-size:.85rem;color:var(--tertiary);margin-bottom:1.2rem;line-height:1.5;}

        .alert{
            border:1px solid var(--line);
            background:#fff;
            border-radius:14px;
            padding:.85rem .9rem;
            font-size:.85rem;
            margin-bottom:1rem;
        }
        .alert-success{border-color:rgba(15,123,64,.22);background:rgba(15,123,64,.06);color:var(--success);}
        .alert-warning{border-color:rgba(161,98,7,.22);background:rgba(161,98,7,.06);color:var(--warning);}

        .btn{
            width:100%;padding:.8rem;border:none;border-radius:999px;
            font-size:.92rem;font-weight:700;cursor:pointer;color:#fff;
            background:linear-gradient(90deg,var(--primary),#000);
            margin-bottom:.65rem;transition:.16s ease;
            display:inline-flex;align-items:center;justify-content:center;gap:.5rem;
            text-decoration:none;
        }
        .btn:hover{opacity:.94;transform:translateY(-1px);}

        .btn-outline{
            background:#fff;color:var(--primary);border:1px solid var(--primary);
        }
        .btn-outline:hover{background:var(--primary);color:#fff;}

        .small-link{
            display:inline-block;
            margin-top:.35rem;
            font-size:.82rem;
            color:var(--tertiary);
            text-decoration:none;
        }
        .small-link:hover{color:var(--primary);text-decoration:underline;}
    </style>
</head>
<body>

<div class="auth-shell">
    <div class="auth-layout">

        <!-- LEFT -->
        <section class="info-column">
            <div class="info-header">
                <img src="{{ asset('adminbackend/assets/images/logokihbt.png') }}" class="info-logo" alt="KIHBT">
                <div>
                    <div class="info-title">Kenya Institute of Highways & Building Technology</div>
                    <div class="info-tagline">Empowering skills for roads, transport & construction</div>
                </div>
            </div>

            <div class="info-highlight">
                <h1>Verify your email</h1>
                <p>We need to confirm your email address before you can continue using the portal.</p>
            </div>

            <div class="info-meta">
                <div class="info-pill"><i class="fa-solid fa-envelope"></i> Secure access</div>
                <div class="info-pill"><i class="fa-solid fa-shield-halved"></i> Account protection</div>
                <div class="info-pill"><i class="fa-solid fa-lock"></i> Verified users only</div>
            </div>
        </section>

        <!-- RIGHT -->
        <section class="form-column">
            <div class="login-card">
                <div class="current-date" id="currentDate"></div>

                <h2 class="title">Email verification</h2>

                <p class="subtitle">
                    Thanks for signing up! Please verify your email address by clicking the link we sent.
                    If you didn’t receive it, you can request another one below.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        A new verification link has been sent to your email address.
                    </div>
                @else
                    <div class="alert alert-warning">
                        Check your inbox (and spam folder) for the verification email.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn">
                        <i class="fa-solid fa-paper-plane"></i>
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Log Out
                    </button>
                </form>

                <a class="small-link" href="{{ url('/') }}">
                    Back to home
                </a>
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

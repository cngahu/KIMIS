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
        }
        @media(max-width:900px){.info-column{text-align:center;padding-bottom:2.8rem;}}

        .info-header{display:flex;align-items:center;gap:.75rem;margin-bottom:1.4rem;}
        @media(max-width:900px){.info-header{justify-content:center;}}
        .info-logo{height:58px;width:auto;}
        .info-title{font-weight:800;font-size:.95rem;text-transform:uppercase;line-height:1.3;}
        .info-tagline{font-size:.82rem;opacity:.85;}

        .info-highlight h1{font-size:1.35rem;font-weight:700;margin-bottom:.35rem;text-align:center;}
        .info-highlight p{font-size:.9rem;color:#e8ddce;max-width:360px;line-height:1.45;text-align:center;margin:0 auto;}

        .form-column{display:flex;align-items:center;justify-content:center;padding:2.2rem 2rem;}
        .login-card{
            width:100%;max-width:380px;
            background:var(--card);border-radius:18px;
            padding:2rem 1.75rem 2rem;
            border:1px solid var(--line);
            box-shadow:0 16px 38px rgba(0,0,0,0.06);
            position:relative;
        }

        .reset-icon{text-align:center;margin-bottom:1rem;color:var(--primary);}
        .reset-icon i{font-size:4.2rem;display:block;margin:0 auto .5rem;}

        .reset-title{font-size:1.35rem;font-weight:800;color:var(--primary);text-align:center;margin-bottom:.25rem;}
        .reset-subtitle{font-size:.85rem;color:var(--tertiary);text-align:center;margin-bottom:1.2rem;}

        .alert{
            background:#fff3cd;border:1px solid #ffeeba;color:#856404;
            padding:.8rem 1rem;border-radius:12px;margin-bottom:1rem;font-size:.85rem;
        }

        .form-group{position:relative;margin-bottom:1rem;}
        .form-group i.left{
            position:absolute;left:1rem;top:50%;
            transform:translateY(-50%);
            color:var(--tertiary);font-size:1rem;pointer-events:none;
        }
        .form-group button.toggle-pass{
            position:absolute;right:.9rem;top:50%;
            transform:translateY(-50%);
            background:none;border:none;color:var(--tertiary);
            cursor:pointer;font-size:1rem;
        }

        input{
            width:100%;
            padding:0.85rem 2.8rem 0.85rem 2.8rem; /* left icon + right toggle space */
            border-radius:12px;border:1px solid var(--line);
            font-size:.92rem;
        }
        input:focus{outline:none;border-color:var(--secondary);box-shadow:0 0 0 2px rgba(249,169,15,.23);}

        .field-error{
            margin-top:.35rem;
            color:#b3261e;
            font-size:.78rem;
        }

        .hint{
            margin-top:.35rem;
            font-size:.75rem;
            color:var(--tertiary);
            line-height:1.35;
        }
        .rule-ok { color:#137333; }
        .rule-bad { color:#b3261e; }
        .rule-ok::marker { color:#137333; }
        .rule-bad::marker { color:#b3261e; }
        .btn[disabled] { opacity:.55; cursor:not-allowed; transform:none; }
        .match{
            margin-top:.35rem;
            font-size:.75rem;
            display:none;
        }
        .match.ok{color:#137333;}
        .match.bad{color:#b3261e;}

        .btn{
            width:100%;padding:.8rem;border:none;border-radius:999px;
            font-size:.92rem;font-weight:700;cursor:pointer;color:#fff;
            background:linear-gradient(90deg,var(--primary),#000);
            margin-top:.25rem;transition:.16s ease;
        }
        .btn:hover{opacity:.94;transform:translateY(-1px);}
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
                <h1>Reset Your Password</h1>
                <p>Enter your new password below to regain access securely.</p>
            </div>
        </section>

        <!-- RIGHT -->
        <section class="form-column">
            <div class="login-card">

                <div class="reset-icon">
                    <i class="fa-solid fa-key"></i>
                </div>

                <div class="reset-title">Reset Password</div>
                <div class="reset-subtitle">Choose a strong new password</div>

                @if ($errors->any())
                    <div class="alert">
                        Please fix the errors below and try again.
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="form-group">
                        <i class="fa-solid fa-envelope left"></i>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="Email address"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                        >
                        @error('email')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <i class="fa-solid fa-lock left"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="New password"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-pass" data-target="password" aria-label="Toggle password">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>

                        @error('password')
                        <div class="field-error">{{ $message }}</div>
                        @enderror

                        <div id="policyBox" class="hint" style="margin-top:.6rem;">
                            <div style="font-weight:600;color:var(--ink);margin-bottom:.35rem;">Password must have:</div>
                            <ul style="margin-left:1.15rem;line-height:1.45;">
                                <li id="ruleLen">At least 10 characters</li>
                                <li id="ruleUpper">An uppercase letter (A–Z)</li>
                                <li id="ruleLower">A lowercase letter (a–z)</li>
                                <li id="ruleNumber">A number (0–9)</li>
                                <li id="ruleSymbol">A symbol (!@#$...)</li>
                            </ul>
                            <div id="policyMsg" class="match bad" style="display:none;margin-top:.35rem;"></div>
                        </div>

                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <i class="fa-solid fa-lock left"></i>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm new password"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-pass" data-target="password_confirmation" aria-label="Toggle confirm password">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>

                        @error('password_confirmation')
                        <div class="field-error">{{ $message }}</div>
                        @enderror

                        <div id="matchMsg" class="match"></div>
                    </div>

                    <button type="submit" class="btn">
                        Reset Password
                    </button>
                </form>

            </div>
        </section>

    </div>
</div>

<script>
    // show/hide password
    document.querySelectorAll('.toggle-pass').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-target');
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye-slash', !isPassword);
            icon.classList.toggle('fa-eye', isPassword);
        });
    });

    const pass = document.getElementById('password');
    const conf = document.getElementById('password_confirmation');
    const msg  = document.getElementById('matchMsg');

    const ruleLen    = document.getElementById('ruleLen');
    const ruleUpper  = document.getElementById('ruleUpper');
    const ruleLower  = document.getElementById('ruleLower');
    const ruleNumber = document.getElementById('ruleNumber');
    const ruleSymbol = document.getElementById('ruleSymbol');

    const policyMsg  = document.getElementById('policyMsg');
    const form       = document.querySelector('form[action="{{ route('password.store') }}"]');
    const submitBtn  = form.querySelector('button[type="submit"]');

    function setRule(el, ok){
        el.classList.toggle('rule-ok', ok);
        el.classList.toggle('rule-bad', !ok);
    }

    function validatePassword(pw){
        const checks = {
            len: pw.length >= 10,
            upper: /[A-Z]/.test(pw),
            lower: /[a-z]/.test(pw),
            number: /[0-9]/.test(pw),
            symbol: /[^A-Za-z0-9]/.test(pw),
        };
        return checks;
    }

    function checkPolicy(){
        const pw = pass.value || '';
        const c = validatePassword(pw);

        setRule(ruleLen, c.len);
        setRule(ruleUpper, c.upper);
        setRule(ruleLower, c.lower);
        setRule(ruleNumber, c.number);
        setRule(ruleSymbol, c.symbol);

        const ok = c.len && c.upper && c.lower && c.number && c.symbol;

        if (!pw) {
            policyMsg.style.display = 'none';
        } else {
            policyMsg.style.display = ok ? 'none' : 'block';
            policyMsg.textContent = ok ? '' : 'Password does not meet the required policy.';
            policyMsg.className = ok ? 'match ok' : 'match bad';
        }

        return ok;
    }

    function checkMatch(){
        const pw = pass.value || '';
        const cv = conf.value || '';

        if (!pw && !cv) {
            msg.style.display = 'none';
            return false;
        }

        msg.style.display = 'block';

        const same = pw === cv;
        if (same) {
            msg.textContent = 'Passwords match.';
            msg.className = 'match ok';
        } else {
            msg.textContent = 'Passwords do not match.';
            msg.className = 'match bad';
        }
        return same;
    }

    function updateSubmitState(){
        const policyOk = checkPolicy();
        const matchOk  = checkMatch();
        // enable submit only when both are ok
        submitBtn.disabled = !(policyOk && matchOk);
    }

    pass.addEventListener('input', updateSubmitState);
    conf.addEventListener('input', updateSubmitState);

    // Final protection: block submit if invalid
    form.addEventListener('submit', (e) => {
        const policyOk = checkPolicy();
        const matchOk  = checkMatch();
        if (!(policyOk && matchOk)) {
            e.preventDefault();
            updateSubmitState();
        }
    });

    // Initial state
    updateSubmitState();
</script>


</body>
</html>

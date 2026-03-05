@extends('admin.admin_dashboard')

@section('admin')

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    .page-content {
        padding: 40px 30px;
    }

    .password-card {
        border-radius: 16px;
        padding: 40px;
        background: #ffffff;
        box-shadow: 0 8px 28px rgba(0,0,0,0.06);
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        height: 56px;
        font-size: 16px;
        border-radius: 10px;
        padding-left: 18px;
        padding-right: 55px;
    }

    .toggle-icon {
        position: absolute;
        top: 50%;
        right: 18px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.3rem;
        color: #6c757d;
        transition: 0.2s ease;
    }

    .toggle-icon:hover {
        color: #0d6efd;
        transform: translateY(-50%) scale(1.1);
    }

    .toggle-icon:active {
        transform: translateY(-50%) scale(0.95);
    }

    #policyBox div {
        transition: all 0.2s ease;
        margin-bottom: 4px;
        font-size: 14px;
    }

    #policyBox i {
        margin-right: 6px;
    }

    .btn-lg-custom {
        padding: 12px 28px;
        font-size: 15px;
        border-radius: 10px;
    }
</style>

<div class="page-content">

    <div class="card password-card">

        <h4 class="fw-bold mb-4">Change Password</h4>

        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <form method="POST" action="{{ route('password.force.update') }}">
            @csrf

            <div class="row g-4">

                {{-- CURRENT PASSWORD --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-2">
                        Current Password
                    </label>

                    <div class="password-wrapper">
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="form-control @error('current_password') is-invalid @enderror">

                        <span class="toggle-icon"
                              onclick="togglePassword('current_password', this)">
                            <i class="bi bi-eye-fill"></i>
                        </span>
                    </div>

                    @error('current_password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- NEW PASSWORD --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-2">
                        New Password
                    </label>

                    <div class="password-wrapper">
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               aria-describedby="passwordHelp">

                        <span class="toggle-icon"
                              onclick="togglePassword('password', this)">
                            <i class="bi bi-eye-fill"></i>
                        </span>
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- PASSWORD POLICY --}}
                    <div class="small mt-3" id="policyBox">
                        <div id="rLen"><i class="bi bi-x-circle text-danger"></i> At least 10 characters</div>
                        <div id="rUp"><i class="bi bi-x-circle text-danger"></i> One uppercase letter</div>
                        <div id="rLow"><i class="bi bi-x-circle text-danger"></i> One lowercase letter</div>
                        <div id="rNum"><i class="bi bi-x-circle text-danger"></i> One number</div>
                        <div id="rSym"><i class="bi bi-x-circle text-danger"></i> One symbol</div>
                    </div>

                    <small id="passwordHelp" class="form-text text-muted">
                        Must meet all policy requirements above.
                    </small>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-2">
                        Confirm Password
                    </label>

                    <div class="password-wrapper">
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control">

                        <span class="toggle-icon"
                              onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye-fill"></i>
                        </span>
                    </div>

                    <div class="small mt-3" id="matchBox" style="display:none;"></div>
                </div>

            </div>

            <div class="mt-5">
                <button type="submit"
                        class="btn btn-primary btn-lg-custom">
                    <i class="bi bi-check-circle me-1"></i>
                    Update Password
                </button>

                <button type="button"
                        onclick="history.back()"
                        class="btn btn-secondary btn-lg-custom ms-2">
                    <i class="bi bi-arrow-left me-1"></i>
                    Cancel
                </button>
            </div>

        </form>

    </div>

</div>

{{-- TOGGLE SCRIPT --}}
<script>
function togglePassword(fieldId, el) {
    const field = document.getElementById(fieldId);
    const icon = el.querySelector('i');

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("bi-eye-fill");
        icon.classList.add("bi-eye-slash-fill");
    } else {
        field.type = "password";
        icon.classList.remove("bi-eye-slash-fill");
        icon.classList.add("bi-eye-fill");
    }
}
</script>

{{-- PASSWORD POLICY VALIDATION --}}
<script>
(function () {
    const pass = document.getElementById('password');
    const conf = document.getElementById('password_confirmation');

    const rules = {
        len: document.getElementById('rLen'),
        up:  document.getElementById('rUp'),
        low: document.getElementById('rLow'),
        num: document.getElementById('rNum'),
        sym: document.getElementById('rSym'),
    };

    const matchBox = document.getElementById('matchBox');

    function update(el, ok, text) {
        const icon = ok
            ? '<i class="bi bi-check-circle text-success"></i>'
            : '<i class="bi bi-x-circle text-danger"></i>';

        el.innerHTML = icon + ' ' + text;
    }

    function validate() {
        const p = pass.value;
        const c = conf.value;

        const checks = {
            len: p.length >= 10,
            up:  /[A-Z]/.test(p),
            low: /[a-z]/.test(p),
            num: /[0-9]/.test(p),
            sym: /[^A-Za-z0-9]/.test(p),
        };

        update(rules.len, checks.len, 'At least 10 characters');
        update(rules.up,  checks.up,  'One uppercase letter');
        update(rules.low, checks.low, 'One lowercase letter');
        update(rules.num, checks.num, 'One number');
        update(rules.sym, checks.sym, 'One symbol');

        if (!p && !c) {
            matchBox.style.display = 'none';
        } else {
            matchBox.style.display = 'block';
            const ok = p === c && p.length > 0;

            matchBox.innerHTML = ok
                ? '<i class="bi bi-check-circle text-success"></i> Passwords match'
                : '<i class="bi bi-x-circle text-danger"></i> Passwords do not match';
        }
    }

    pass.addEventListener('input', validate);
    conf.addEventListener('input', validate);
})();
</script>

@endsection
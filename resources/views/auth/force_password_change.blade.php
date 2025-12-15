@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-body">
                <h4 class="mb-3">Change Password</h4>

                @if(session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                <form method="POST" action="{{ route('password.force.update') }}">
                    @csrf

                    <div class="row g-3">

                        {{-- Current Password --}}
                        <div class="col-md-4">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="col-md-4">
                            <label class="form-label">New Password</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Password Policy --}}
                            <div class="small mt-2" id="policyBox">
                                <div id="rLen">✗ At least 10 characters</div>
                                <div id="rUp">✗ One uppercase letter</div>
                                <div id="rLow">✗ One lowercase letter</div>
                                <div id="rNum">✗ One number</div>
                                <div id="rSym">✗ One symbol</div>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="col-md-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control">

                            <div class="small mt-2" id="matchBox" style="display:none;"></div>
                        </div>

                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 🔐 Password Policy Live Validation --}}
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
                el.textContent = (ok ? '✓ ' : '✗ ') + text;
                el.style.color = ok ? '#198754' : '#dc3545';
            }

            function validate() {
                const p = pass.value || '';
                const c = conf.value || '';

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
                    const ok = p === c;
                    matchBox.textContent = ok ? '✓ Passwords match' : '✗ Passwords do not match';
                    matchBox.style.color = ok ? '#198754' : '#dc3545';
                }
            }

            pass.addEventListener('input', validate);
            conf.addEventListener('input', validate);
        })();
    </script>
@endsection

@extends('admin.admin_dashboard')
@section('admin')

<style>
    /* ================= CSS VARIABLES - KIHBT BROWN THEME ================= */
    :root {
        /* Brand Colors */
        --primary: #3b2818;           /* KIHBT Brown */
        --primary-light: #5a3d2b;     /* Lighter Brown */
        --primary-dark: #2a1a0f;      /* Darker Brown */
        --accent: #f9a90f;            /* KIHBT Gold */
        --accent-hover: #d18b00;      /* Darker Gold */
        
        /* Semantic Colors */
        --secondary: #858585;
        --success: #099139;
        --warning: #f9a90f;
        --danger: #b3261e;
        --info: #3b2818;
        
        /* Backgrounds */
        --bg-card: #ffffff;
        --bg-soft: #f5f6f5;
        --bg-gradient: linear-gradient(135deg, #fffefc, #ffffff);
        --bg-accent: rgba(249, 169, 15, 0.1);
        --bg-primary: rgba(59, 40, 24, 0.05);
        
        /* Borders */
        --border-light: #e8e8e8;
        --border-primary: rgba(59, 40, 24, 0.2);
        --border-accent: rgba(249, 169, 15, 0.3);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(59, 40, 24, 0.06);
        --shadow-md: 0 6px 18px rgba(59, 40, 24, 0.08);
        --shadow-lg: 0 10px 25px rgba(59, 40, 24, 0.1);
        --shadow-hover: 0 12px 32px rgba(59, 40, 24, 0.15);
        
        /* Text */
        --text-primary: #26211d;
        --text-secondary: #858585;
        --text-on-primary: #ffffff;
        --text-on-accent: #000000;
        
        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        
        /* Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        
        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition-normal: 0.25s ease;
    }

    /* ================= PAGE CONTENT ================= */
    .page-content {
        padding: calc(var(--header-height, 60px) + var(--spacing-lg)) var(--spacing-lg) var(--spacing-lg);
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= BREADCRUMB ================= */
    .page-breadcrumb {
        background: var(--bg-gradient);
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--accent);
        margin-bottom: var(--spacing-xl);
    }

    .page-breadcrumb .breadcrumb-title {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
    }

    .page-breadcrumb .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
        transition: color var(--transition-fast);
    }

    .page-breadcrumb .breadcrumb-item a:hover {
        color: var(--accent);
    }

    .page-breadcrumb .breadcrumb-item.active {
        color: var(--secondary);
    }

    /* ================= PASSWORD CARD ================= */
    .password-card {
        background: var(--bg-card);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-light);
        border-top: 4px solid var(--accent);
        max-width: 600px;
        margin: 0 auto;
        overflow: hidden;
    }

    .password-card .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--text-on-primary);
        padding: var(--spacing-lg) var(--spacing-xl);
        text-align: center;
    }

    .password-card .card-header h4 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: var(--spacing-xs);
    }

    .password-card .card-header .text-muted {
        color: rgba(255,255,255,0.9) !important;
        font-size: 0.95rem;
    }

    .password-card .card-body {
        padding: var(--spacing-xl);
    }

    /* ================= FORM FIELDS ================= */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .form-control {
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-light);
        font-size: 0.95rem;
        transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
        background: #fff;
    }

    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(249, 169, 15, 0.15);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(179, 38, 30, 0.15);
    }

    .invalid-feedback {
        font-size: 0.85rem;
        color: var(--danger);
        margin-top: var(--spacing-xs);
    }

    /* ================= ALERTS ================= */
    .alert {
        border-radius: var(--radius-md);
        padding: var(--spacing-md) var(--spacing-lg);
        border: none;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .alert-success {
        background: rgba(9, 145, 57, 0.1);
        color: var(--success);
        border-left: 4px solid var(--success);
    }

    .alert-danger {
        background: rgba(179, 38, 30, 0.1);
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }

    /* ================= BUTTONS ================= */
    .btn {
        border-radius: var(--radius-md);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all var(--transition-fast);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--text-on-primary);
        box-shadow: 0 2px 4px rgba(59, 40, 24, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--text-on-primary);
    }

    .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-outline-secondary {
        border: 2px solid var(--secondary);
        color: var(--secondary);
        background: transparent;
        font-weight: 600;
    }

    .btn-outline-secondary:hover {
        background: var(--secondary);
        color: var(--text-on-primary);
        transform: translateY(-2px);
    }

    /* ================= PASSWORD STRENGTH ================= */
    .password-strength {
        margin-top: var(--spacing-xs);
        font-size: 0.85rem;
    }

    .password-strength .strength-bar {
        height: 4px;
        background: var(--border-light);
        border-radius: 2px;
        margin-top: var(--spacing-xs);
        overflow: hidden;
    }

    .password-strength .strength-fill {
        height: 100%;
        width: 0%;
        background: var(--danger);
        transition: width var(--transition-fast), background var(--transition-fast);
        border-radius: 2px;
    }

    .password-strength.weak .strength-fill { width: 33%; background: var(--danger); }
    .password-strength.medium .strength-fill { width: 66%; background: var(--warning); }
    .password-strength.strong .strength-fill { width: 100%; background: var(--success); }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 767px) {
        .page-content { padding: var(--spacing-sm); }
        .password-card { margin: 0 var(--spacing-sm); }
        .password-card .card-header,
        .password-card .card-body { padding: var(--spacing-md); }
        .form-label { font-size: 0.85rem; }
        .btn { width: 100%; justify-content: center; }
    }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    .btn:focus, .form-control:focus, a:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .password-card { border: 2px solid var(--primary); }
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Change Password</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="container">
        <div class="main-body">
            <div class="row justify-content-center">

                <div class="col-lg-8">
                    <div class="password-card">
                        <div class="card-header">
                            <h4><i class="bx bx-lock-alt me-2"></i>Change Password</h4>
                            <p class="text-muted mb-0">Update your account password securely</p>
                        </div>
                        
                        <div class="card-body">
                            
                            {{-- Success / Error Messages --}}
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bx bx-check-circle me-2"></i>
                                    {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bx bx-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="post" action="{{ route('admin.password.update') }}">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label">Current Password *</label>
                                    <input type="password" name="old_password" 
                                           class="form-control @error('old_password') is-invalid @enderror" 
                                           id="current_password" 
                                           placeholder="Enter your current password" 
                                           required />
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">New Password *</label>
                                    <input type="password" name="new_password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           placeholder="Enter new password" 
                                           required />
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    {{-- Password Strength Indicator --}}
                                    <div class="password-strength" id="passwordStrength">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Password Strength:</span>
                                            <span id="strengthText">Not entered</span>
                                        </div>
                                        <div class="strength-bar">
                                            <div class="strength-fill" id="strengthFill"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Confirm New Password *</label>
                                    <input type="password" name="new_password_confirmation" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           placeholder="Confirm new password" 
                                           required />
                                    {{-- Match Indicator --}}
                                    <div class="invalid-feedback d-none" id="passwordMatchError">
                                        Passwords do not match
                                    </div>
                                </div>

                                {{-- Password Requirements --}}
                                <div class="alert alert-info mb-4">
                                    <i class="bx bx-info-circle me-2"></i>
                                    <strong>Password Requirements:</strong>
                                    <ul class="mb-0 mt-2" style="font-size: 0.9rem;">
                                        <li>At least 8 characters long</li>
                                        <li>Contains uppercase and lowercase letters</li>
                                        <li>Contains at least one number</li>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="bx bx-save me-1"></i>Update Password
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-x me-1"></i>Cancel
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Auto-hide alerts after 5 seconds
    setTimeout(function(){
        $('.alert').alert('close');
    }, 5000);
    
    // Password strength checker
    const passwordInput = $('#new_password');
    const strengthFill = $('#strengthFill');
    const strengthText = $('#strengthText');
    
    passwordInput.on('input', function() {
        const password = $(this).val();
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/) && password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[^a-zA-Z0-9]+/)) strength++;
        
        // Update UI
        strengthFill.removeClass('weak medium strong');
        if (password.length === 0) {
            strengthText.text('Not entered');
            strengthFill.css('width', '0%');
        } else if (strength <= 2) {
            strengthText.text('Weak');
            strengthFill.addClass('weak').css('width', '33%');
        } else if (strength === 3) {
            strengthText.text('Medium');
            strengthFill.addClass('medium').css('width', '66%');
        } else {
            strengthText.text('Strong');
            strengthFill.addClass('strong').css('width', '100%');
        }
    });
    
    // Password match checker
    const confirmInput = $('#new_password_confirmation');
    const matchError = $('#passwordMatchError');
    
    confirmInput.on('input', function() {
        if (passwordInput.val() !== $(this).val() && $(this).val().length > 0) {
            $(this).addClass('is-invalid');
            matchError.removeClass('d-none');
        } else {
            $(this).removeClass('is-invalid');
            matchError.addClass('d-none');
        }
    });
    
    // Disable submit button during form submission
    $('form').on('submit', function() {
        $('#submitBtn').prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i>Updating...');
    });
});
</script>

@endsection
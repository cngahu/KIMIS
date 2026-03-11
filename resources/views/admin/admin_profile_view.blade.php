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

    /* ================= PROFILE CARD ================= */
    .profile-card {
        background: var(--bg-gradient);
        border-radius: var(--radius-xl);
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        border-top: 4px solid var(--accent);
        text-align: center;
        transition: transform var(--transition-normal), box-shadow var(--transition-normal);
    }

    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .profile-card .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--accent);
        padding: 3px;
        background: var(--bg-card);
        margin-bottom: var(--spacing-md);
        transition: transform var(--transition-fast);
    }

    .profile-card .profile-photo:hover {
        transform: scale(1.05);
    }

    .profile-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .profile-card .text-secondary {
        color: var(--secondary) !important;
        font-size: 0.95rem;
        margin-bottom: var(--spacing-md);
    }

    .profile-card .photo-form {
        margin-top: var(--spacing-md);
    }

    .profile-card .photo-form .form-control {
        border-radius: var(--radius-md);
        padding: 0.5rem;
        font-size: 0.9rem;
        border: 1px solid var(--border-light);
    }

    .profile-card .photo-form .btn {
        border-radius: var(--radius-md);
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* ================= FORM CARD ================= */
    .form-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
    }

    .form-card .card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--border-light);
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

    .alert-warning {
        background: var(--bg-accent);
        color: var(--primary);
        border-left: 4px solid var(--accent);
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

    .form-control:disabled {
        background: var(--bg-soft);
        color: var(--secondary);
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

    /* ================= READ-ONLY FIELDS ================= */
    .text-secondary {
        color: var(--secondary) !important;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        background: var(--bg-soft);
        border-radius: var(--radius-md);
        display: inline-block;
        min-width: 100%;
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

    .btn-outline-primary {
        border: 2px solid var(--primary);
        color: var(--primary);
        background: transparent;
        font-weight: 600;
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        color: var(--text-on-primary);
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* ================= FIELD GROUPS ================= */
    .field-group {
        margin-bottom: var(--spacing-md);
    }

    .field-group .field-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .field-group .field-value {
        color: var(--text-primary);
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        background: var(--bg-soft);
        border-radius: var(--radius-md);
    }

    /* ================= SOCIAL LINKS (Optional) ================= */
    .social-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .social-links li {
        padding: var(--spacing-sm) 0;
        border-bottom: 1px dashed var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .social-links li:last-child {
        border-bottom: none;
    }

    .social-links .label {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .social-links .value {
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .social-links .label svg {
        width: 18px;
        height: 18px;
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 991px) {
        .page-content { padding: var(--spacing-md); }
        .profile-card { padding: var(--spacing-lg); }
        .form-card { padding: var(--spacing-md); }
        .field-group { margin-bottom: var(--spacing-sm); }
    }

    @media (max-width: 767px) {
        :root { --spacing-lg: 1.25rem; --spacing-xl: 1.5rem; }
        .page-content { padding: var(--spacing-sm); }
        .profile-card .profile-photo { width: 100px; height: 100px; }
        .profile-card h4 { font-size: 1.1rem; }
        .form-card .card-title { font-size: 1.05rem; }
        .btn { width: 100%; justify-content: center; }
        .field-group .field-label,
        .field-group .field-value { font-size: 0.9rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    .btn:focus, .form-control:focus, a:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .profile-card, .form-card { border: 2px solid var(--primary); }
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Admin Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        {{-- ✅ FIXED: was route('dashboard'), now route('admin.dashboard') --}}
                        <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="container">
        <div class="main-body">
            <div class="row">

                {{-- Profile Photo Card --}}
                <div class="col-lg-4">
                    <div class="profile-card">
                        <img src="{{ !empty($adminData->photo) ? asset('upload/admin_images/' . $adminData->photo) : asset('adminbackend/assets/images/no-image.jpg') }}"
                             alt="Admin" class="profile-photo">
                        
                        <h4>{{ $adminData->name ?? 'Admin User' }}</h4>
                        <p class="text-secondary mb-0">{{ $adminData->email }}</p>

                        {{-- Photo Update Form --}}
                        <form method="POST" action="{{ route('admin.profile.photo') }}" enctype="multipart/form-data" class="photo-form">
                            @csrf
                            <input type="file" name="photo" class="form-control mb-2" accept="image/*" required>
                            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bx bx-camera me-1"></i>Update Photo
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Bio Data Form Card --}}
                <div class="col-lg-8">
                    <div class="form-card">
                        <h5 class="card-title">
                            <i class="bx bx-user me-2"></i>Personal Information
                        </h5>

                        {{-- Success / Error Messages --}}
                        @if(session('message'))
                            <div class="alert alert-{{ session('alert-type') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                                <i class="bx bx-{{ session('alert-type') === 'success' ? 'check-circle' : 'error-circle' }} me-2"></i>
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="bx bx-error-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.profile.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                {{-- Read-only Fields --}}
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <div class="field-label">Username</div>
                                        <div class="field-value">{{ $adminData->username ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <div class="field-label">Role</div>
                                        <div class="field-value">{{ $adminData->userrole ?? 'Admin' }}</div>
                                    </div>
                                </div>

                                {{-- Editable Fields --}}
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label class="form-label">Full Name *</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $adminData->name) }}" required />
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $adminData->email) }}" required />
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                               value="{{ old('phone', $adminData->phone) }}" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control"
                                               value="{{ old('address', $adminData->address) }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i>Save Changes
                                </button>
                                {{-- ✅ FIXED: was route('dashboard'), now route('admin.dashboard') --}}
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary ms-2">
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

{{-- JavaScript for enhanced UX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success alerts after 5 seconds
    setTimeout(function(){
        document.querySelectorAll('.alert-success').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // Image preview for photo upload
    const photoInput = document.querySelector('input[name="photo"]');
    const profilePhoto = document.querySelector('.profile-photo');
    
    if (photoInput && profilePhoto) {
        photoInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePhoto.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Disable submit button during form submission to prevent double-submit
    const profileForm = document.querySelector('form[action*="profile.store"]');
    if (profileForm) {
        profileForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Saving...';
            }
        });
    }
});
</script>

@endsection
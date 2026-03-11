{{-- resources/views/public/hostel/book.blade.php --}}
@extends('layouts.public')

@section('content')

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

    /* ================= PAGE WRAPPER ================= */
    .hostel-booking-page {
        min-height: 100vh;
        background: var(--bg-gradient);
        padding: var(--spacing-xl) 0;
    }

    /* ================= BOOKING CARD ================= */
    .booking-card {
        background: var(--bg-card);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-light);
        border-top: 4px solid var(--accent);
        max-width: 900px;
        margin: 0 auto;
        overflow: hidden;
    }

    .booking-card .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--text-on-primary);
        padding: var(--spacing-lg) var(--spacing-xl);
        text-align: center;
    }

    .booking-card .card-header h3 {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: var(--spacing-xs);
    }

    .booking-card .card-header .text-muted {
        color: rgba(255,255,255,0.9) !important;
        font-size: 0.95rem;
    }

    .booking-card .card-body {
        padding: var(--spacing-xl);
    }

    /* ================= FORM FIELDS ================= */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary);
        margin-bottom: var(--spacing-xs);
    }

    .form-control,
    .form-select {
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-light);
        font-size: 0.95rem;
        transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
        background: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(249, 169, 15, 0.15);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(179, 38, 30, 0.15);
    }

    .invalid-feedback,
    .text-danger {
        font-size: 0.85rem;
        color: var(--danger);
        margin-top: var(--spacing-xs);
    }

    .form-text {
        font-size: 0.85rem;
        color: var(--secondary);
    }

    /* ================= RADIO GROUP ================= */
    .boarding-options {
        display: flex;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .boarding-option {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all var(--transition-fast);
        background: var(--bg-soft);
    }

    .boarding-option:hover {
        border-color: var(--accent);
        background: var(--bg-accent);
    }

    .boarding-option input[type="radio"]:checked + label,
    .boarding-option:has(input[type="radio"]:checked) {
        border-color: var(--accent);
        background: var(--bg-primary);
        font-weight: 600;
        color: var(--primary);
    }

    .boarding-option .form-check-input {
        margin: 0;
        width: 18px;
        height: 18px;
        border-color: var(--border-light);
    }

    .boarding-option .form-check-input:checked {
        background-color: var(--accent);
        border-color: var(--accent);
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

    .alert-info {
        background: var(--bg-primary);
        color: var(--primary);
        border-left: 4px solid var(--primary);
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

    .btn-lg {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }

    /* ================= SELECT2 CUSTOMIZATION ================= */
    .select2-container--default .select2-selection--single {
        border-radius: var(--radius-md) !important;
        border: 1px solid var(--border-light) !important;
        height: auto !important;
        padding: 0.6rem 1rem !important;
        font-size: 0.95rem !important;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(249, 169, 15, 0.15) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text-primary) !important;
        line-height: 1.4 !important;
        padding: 0 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 10px !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border-radius: var(--radius-sm) !important;
        border: 1px solid var(--border-light) !important;
        padding: 0.5rem !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: var(--accent) !important;
        color: var(--text-on-accent) !important;
    }

    .select2-container--default .select2-results__option[aria-selected="true"] {
        background: var(--bg-primary) !important;
        color: var(--primary) !important;
    }

    /* ================= INFO BOX ================= */
    .info-box {
        background: var(--bg-accent);
        border-left: 4px solid var(--accent);
        border-radius: var(--radius-sm);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        font-size: 0.9rem;
        color: var(--primary);
    }

    .info-box i {
        color: var(--accent);
        margin-right: var(--spacing-xs);
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 767px) {
        .hostel-booking-page { padding: var(--spacing-md) 0; }
        .booking-card { margin: 0 var(--spacing-sm); }
        .booking-card .card-header,
        .booking-card .card-body { padding: var(--spacing-md); }
        .boarding-options { flex-direction: column; gap: var(--spacing-sm); }
        .boarding-option { width: 100%; justify-content: center; }
        .btn { width: 100%; justify-content: center; }
        .form-label { font-size: 0.85rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    .btn:focus, .form-control:focus, .form-select:focus, a:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .booking-card { border: 2px solid var(--primary); }
    }
</style>

<div class="hostel-booking-page">
    <div class="container">
        
        {{-- Booking Card --}}
        <div class="booking-card">
            <div class="card-header">
                <h3><i class="la la-bed me-2"></i>Hostel Booking</h3>
                <p class="text-muted mb-0">Apply for accommodation - Short & Long Term Courses</p>
            </div>
            
            <div class="card-body">
                
                {{-- Info Box --}}
                <div class="info-box">
                    <i class="la la-info-circle"></i>
                    <strong>Important:</strong> Please ensure all details are accurate. Applications are reviewed within 3-5 working days.
                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="la la-exclamation-circle me-2"></i>
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="la la-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('hostel.book.store') }}">
                    @csrf
                    
                    {{-- Personal Information Section --}}
                    <h5 class="fw-bold mb-3 pb-2 border-bottom" style="color: var(--primary);">
                        <i class="la la-user me-2"></i>Personal Information
                    </h5>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" 
                                   name="full_name" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   value="{{ old('full_name') }}"
                                   placeholder="Enter your full name"
                                   required>
                            @error('full_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ID / Passport Number *</label>
                            <input type="text" 
                                   name="id_number" 
                                   class="form-control @error('id_number') is-invalid @enderror" 
                                   value="{{ old('id_number') }}"
                                   placeholder="Enter ID or Passport number"
                                   required>
                            @error('id_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Email Address *</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}"
                                   placeholder="your.email@example.com"
                                   required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" 
                                   name="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}"
                                   placeholder="+254 7XX XXX XXX"
                                   pattern="^\+?[0-9\s\-\(\)]{10,15}$"
                                   required>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Course Selection --}}
                    <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4" style="color: var(--primary);">
                        <i class="la la-graduation-cap me-2"></i>Course Details
                    </h5>
                    
                    <div class="mb-4">
                        <label class="form-label">Select Course & Campus *</label>
                        <select name="course_id" class="form-select select2 @error('course_id') is-invalid @enderror" required>
                            <option value="">Search and select your course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_name }} — {{ $course->college->name ?? 'Unknown Campus' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text">
                            <i class="la la-search me-1"></i>Start typing to search by course name or campus.
                        </small>
                        @error('course_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Boarding Type --}}
                    <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4" style="color: var(--primary);">
                        <i class="la la-home me-2"></i>Accommodation Type
                    </h5>
                    
                    <div class="mb-4">
                        <label class="form-label d-block mb-2">Select Boarding Type *</label>
                        <div class="boarding-options">
                            <label class="boarding-option">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="boarding_type" 
                                       value="half" 
                                       {{ old('boarding_type') == 'half' ? 'checked' : '' }}
                                       required>
                                <span><i class="la la-sun me-1"></i>Half Board</span>
                            </label>

                            <label class="boarding-option">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="boarding_type" 
                                       value="full"
                                       {{ old('boarding_type') == 'full' ? 'checked' : '' }}>
                                <span><i class="la la-moon me-1"></i>Full Board</span>
                            </label>
                        </div>
                        <small class="form-text mt-2">
                            <strong>Half Board:</strong> Accommodation + Breakfast & Dinner<br>
                            <strong>Full Board:</strong> Accommodation + All Meals (Breakfast, Lunch, Dinner)
                        </small>
                        @error('boarding_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-flex justify-content-center pt-3 border-top mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="la la-paper-plane me-1"></i>Apply for Hostel
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2 with KIHBT styling
        $('.select2').select2({
            placeholder: 'Search course or campus',
            allowClear: true,
            width: '100%',
            dropdownParent: $(document.body),
            language: {
                noResults: function() {
                    return "No course or campus found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function(){
            $('.alert').alert('close');
        }, 5000);

        // Disable submit button during form submission
        $('form').on('submit', function() {
            $('#submitBtn').prop('disabled', true).html('<i class="la la-spinner la-spin me-1"></i>Submitting...');
        });

        // Phone number formatting (basic)
        $('input[name="phone"]').on('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0) {
                value = '+254' + value.slice(-9);
                this.value = value;
            }
        });
    });
</script>
@endpush

@endsection
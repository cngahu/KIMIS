@php
    $user = \Illuminate\Support\Facades\Auth::user();

    // Ensure $admission is always defined
    $admission = $admission ?? null;
@endphp

{{-- Only show student menu if $admission exists --}}
@if(!empty($admission))

    {{-- OFFER SENT --}}
    @if($admission->status === 'offer_sent')
        <li>
            <a href="{{ route('student.student_dashboard') }}">
                <div class="parent-icon"><i class="bx bx-home"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{ route('student.student_dashboard') }}">
                <div class="parent-icon"><i class="bx bx-envelope"></i></div>
                <div class="menu-title">Admission Offer</div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class="bx bx-help-circle"></i></div>
                <div class="menu-title">Help & Support</div>
            </a>
        </li>
    @endif

    {{-- IN PROGRESS STATUSES --}}
    @if(in_array($admission->status, [
        'offer_accepted', 'form_submitted',
        'documents_uploaded', 'fee_paid', 'docs_verified',
        'awaiting_sponsor_verification','awaiting_fee_decision'
    ]))
        <li>
            <a href="{{ route('student.student_dashboard') }}">
                <div class="parent-icon"><i class="bx bx-home"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{ route('student.admission.form') }}">
                <div class="parent-icon"><i class="bx bx-edit"></i></div>
                <div class="menu-title">Admission Form</div>
            </a>
        </li>
        <li>
            <a href="{{ route('student.admission.documents') }}">
                <div class="parent-icon"><i class="bx bx-upload"></i></div>
                <div class="menu-title">Document Upload</div>
            </a>
        </li>
        <li>
            <a href="{{ route('student.admission.payment') }}">
                <div class="parent-icon"><i class="bx bx-credit-card"></i></div>
                <div class="menu-title">Fee Payment</div>
            </a>
        </li>
        <li>
            <a href="{{ route('student.student_dashboard') }}">
                <div class="parent-icon"><i class="bx bx-check-circle"></i></div>
                <div class="menu-title">Admission Status</div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class="bx bx-help-circle"></i></div>
                <div class="menu-title">Help & Support</div>
            </a>
        </li>
    @endif

@endif

{{-- ADMITTED STATUSES --}}
<li>
    <a href="{{ route('student.student_dashboard') }}">
        <div class="parent-icon"><i class="bx bx-home"></i></div>
        <div class="menu-title">Dashboard</div>
    </a>
</li>

<li>
    <a href="{{ route('student.profile.show') }}">
        <div class="parent-icon"><i class="bx bx-user"></i></div>
        <div class="menu-title">My Profile</div>
    </a>
</li>

<li>
    <a href="{{ route('student.fees.index') }}">
        <div class="parent-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="menu-title">Fees & Statements</div>
    </a>
</li>

<li>
    <a href="{{ route('student.student_dashboard') }}">
        <div class="parent-icon"><i class="bx bx-bell"></i></div>
        <div class="menu-title">Notices</div>
    </a>
</li>

<li>
    <a href="#">
        <div class="parent-icon"><i class="bx bx-help-circle"></i></div>
        <div class="menu-title">Help & Support</div>
    </a>
</li>
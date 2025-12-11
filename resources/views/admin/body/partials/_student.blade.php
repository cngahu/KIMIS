@php $user = \Illuminate\Support\Facades\Auth::user(); @endphp

@if($admission)


@if($admission->status === 'offer_sent')

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-home"></i></div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
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

@if(in_array($admission->status, [
    'offer_accepted', 'form_submitted',
    'documents_uploaded', 'fee_paid', 'docs_verified','awaiting_sponsor_verification','awaiting_fee_decision'
]))

    <li>
        <a href="{{ route('student.dashboard') }}">
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
        <a href="{{ route('student.dashboard') }}">
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
@if(in_array($admission->status, ['admission_number_assigned', 'admitted']))

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-home"></i></div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-user"></i></div>
            <div class="menu-title">My Profile</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-money"></i></div>
            <div class="menu-title">Fees & Payments</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-book"></i></div>
            <div class="menu-title">Course Units</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-award"></i></div>
            <div class="menu-title">Exam Results</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
            <div class="parent-icon"><i class="bx bx-calendar"></i></div>
            <div class="menu-title">Class Timetable</div>
        </a>
    </li>

    <li>
        <a href="{{ route('student.dashboard') }}">
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

@endif
@else
@endif

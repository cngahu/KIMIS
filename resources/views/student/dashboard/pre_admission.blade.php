@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .kpi-card {
            border-radius: 10px;
            padding: 1.5rem;
            color: #fff;
        }
    </style>

    <div class="page-content">

        <h4 class="fw-bold">Welcome, {{ auth()->user()->firstname }}</h4>
        <p class="text-muted">Your admission offer is ready.</p>

        <div class="row g-3">

            {{-- Admission Offer Card --}}
            <div class="col-md-8">
                <div class="card radius-10 p-4 shadow-sm">
                    <h5 class="fw-bold mb-2">Admission Offer</h5>
                    <p>
                        @if($admission->application && $admission->application->course)
                            You have been offered admission to:
                            <strong>{{ $admission->application->course->course_name }}</strong>
                        @elseif($admission->application)
                            You have been offered admission (course info not available).
                        @else
                            Your admission record exists, but the original application is missing.
                            Please contact Admissions for help.
                        @endif
                    </p>


                    <div class="d-flex gap-2 mt-3">

                        <form method="POST" action="{{ route('student.accept.offer') }}">
                            @csrf
                            <button class="btn btn-primary">
                                Accept Offer
                            </button>
                        </form>

                        <a class="btn btn-dark" href="#">
                            Download Admission Letter
                        </a>
                    </div>
                </div>
            </div>

            {{-- Status Card --}}
            <div class="col-md-4">
                <div class="kpi-card" style="background:linear-gradient(135deg,#3B2818,#3B2818);">
                    <h6 class="fw-bold mb-1">Current Status</h6>
                    <h4 class="fw-bold text-white">OFFER SENT</h4>
                    <small class="text-white-50">Waiting for your acceptance</small>
                </div>
            </div>

        </div>

    </div>

@endsection

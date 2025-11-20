@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .section-title {
            font-weight: bold;
            color: #003366;
            border-bottom: 2px solid #F4B400;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .info-label {
            font-weight: bold;
            color: #003366;
        }
        .attachment-box a {
            text-decoration: none;
        }
    </style>

    <div class="page-content">

        <h4 class="mb-3">Application Review</h4>

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- ===== APPLICANT DETAILS ===== -->
                <div class="section-title">Applicant Details</div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <span class="info-label">Full Name: </span>
                        {{ $application->full_name }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">ID Number: </span>
                        {{ $application->id_number }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">Phone: </span>
                        {{ $application->phone }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">Email: </span>
                        {{ $application->email }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">Date of Birth: </span>
                        {{ $application->date_of_birth }}
                    </div>
                </div>


                <!-- ===== LOCATION DETAILS ===== -->
                <div class="section-title">Address & Location</div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <span class="info-label">Home County: </span>
                        {{ optional($application->homeCounty)->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Current County: </span>
                        {{ optional($application->currentCounty)->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Subcounty: </span>
                        {{ optional($application->currentSubcounty)->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Postal Address: </span>
                        {{ $application->postal_address }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Postal Code: </span>
                        {{ optional($application->postalCode)->code }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Town: </span>
                        {{ $application->town }}
                    </div>
                </div>


                <!-- ===== COURSE DETAILS ===== -->
                <div class="section-title">Course Applied For</div>

                <div class="mb-3">
                    <span class="info-label">Course: </span>
                    {{ $application->course->course_name }}
                </div>


                <!-- ===== PAYMENT DETAILS ===== -->
                <div class="section-title">Payment Information</div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <span class="info-label">Invoice Number: </span>
                        {{ $application->invoice->invoice_number ?? 'N/A' }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Amount Paid: </span>
                        KES {{ number_format($application->invoice->amount ?? 0) }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Payment Status: </span>
                        <span class="badge bg-success">{{ ucfirst($application->payment_status) }}</span>
                    </div>
                </div>


                <!-- ===== REQUIREMENT ANSWERS ===== -->
                <div class="section-title">Submitted Requirements</div>

                @foreach($application->answers as $ans)
                    <div class="mb-3">
                        <span class="info-label">{{ $ans->requirement->course_requirement }}:</span>

                        @if($ans->requirement->type === 'upload')
                            <div class="attachment-box mt-1">
                                <a href="{{ asset('storage/'.$ans->value) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    View File
                                </a>
                            </div>
                        @else
                            <p>{{ $ans->value }}</p>
                        @endif
                    </div>
                @endforeach


                <!-- ===== OFFICER ACTIONS ===== -->
                <div class="section-title">Officer Decision</div>

                <form action="" method="POST" id="decisionForm">
                    @csrf

                    <div class="mb-3">
                        <label class="info-label">Comments / Notes</label>
                        <textarea name="comments" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="d-flex gap-3 mt-3">

                        <!-- Approve Button -->
                        <button formaction="{{ route('officer.applications.approve', $application->id) }}"
                                class="btn btn-success px-4">
                            Approve Application
                        </button>

                        <!-- Reject Button -->
                        <button formaction="{{ route('officer.applications.reject', $application->id) }}"
                                class="btn btn-danger px-4">
                            Reject Application
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection

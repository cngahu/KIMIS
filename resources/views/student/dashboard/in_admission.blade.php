@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .step-card {
            border-left: 4px solid #003366;
            border-radius: 8px;
        }
    </style>

    <div class="page-content">

        <h4 class="fw-bold">Admission Progress</h4>
        <p class="text-muted">Complete the steps below to finalize your admission.</p>

        <div class="row g-3">

            {{-- Progress Steps --}}
            <div class="col-md-8">

                {{-- Offer Accepted --}}
                <div class="card step-card p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>1. Offer Accepted</strong><br>
                            <small class="text-muted">You accepted your admission offer</small>
                        </div>
                        <span class="badge bg-success">Done</span>
                    </div>
                </div>

                {{-- Admission Form --}}
                <div class="card step-card p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>2. Fill Admission Form</strong><br>
                            <small class="text-muted">Personal & guardian details</small>
                        </div>

                        @if($admission->status === 'offer_accepted')
                            <a href="#" class="btn btn-primary btn-sm">Complete</a>
                        @else
                            <span class="badge bg-success">Done</span>
                        @endif

                    </div>
                </div>

                {{-- Documents Upload --}}
                <div class="card step-card p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>3. Upload Required Documents</strong><br>
                            <small class="text-muted">Birth Cert, KCSE, ID, etc.</small>
                        </div>

                        @if($admission->status === 'form_submitted')
                            <a href="#" class="btn btn-info btn-sm">Upload</a>
                        @elseif(in_array($admission->status, ['documents_uploaded','fee_paid','docs_verified']))
                            <span class="badge bg-success">Done</span>
                        @endif

                    </div>
                </div>

                {{-- Fee Payment --}}
                <div class="card step-card p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>4. Pay School Fees</strong><br>
                            <small class="text-muted">Pay via eCitizen or manually</small>
                        </div>

                        @if($admission->status === 'documents_uploaded')
                            <a href="#" class="btn btn-success btn-sm">Pay Now</a>
                        @elseif(in_array($admission->status, ['fee_paid','docs_verified']))
                            <span class="badge bg-success">Paid</span>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Status Summary --}}
            <div class="col-md-4">
                <div class="card radius-10 p-4 shadow-sm">
                    <h6 class="fw-bold mb-2">Current Status</h6>
                    <h4 class="fw-bold text-primary">
                        {{ strtoupper(str_replace('_',' ', $admission->status)) }}
                    </h4>
                </div>
            </div>

        </div>

    </div>

@endsection

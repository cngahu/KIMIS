{{-- resources/views/public/certificate_verify.blade.php --}}
@extends('layouts.public')

@section('content')
    <style>
        .cert-page {
            max-width: 720px;
            margin: 2rem auto;
        }

        .cert-card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .cert-card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cert-card-body {
            padding: 1.5rem;
        }

        .brand-heading {
            font-weight: 700;
            color: #3B2818; /* KIHBT brown */
        }

        .brand-accent {
            color: #099139; /* KIHBT green */
        }

        .result-label {
            font-weight: 600;
            color: #374151;
        }

        .result-value {
            font-weight: 600;
            color: #111827;
        }

        .badge-valid {
            background: #d1fae5;
            color: #065f46;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
        }

        .badge-invalid {
            background: #fee2e2;
            color: #b91c1c;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
        }
    </style>

    <div class="cert-page">
        <div class="mb-3 text-center">
            <h3 class="brand-heading mb-1">Certificate Verification</h3>
            <p class="text-muted mb-0">
                Enter a KIHBT certificate number to confirm if it is valid.
            </p>
        </div>

        <div class="cert-card">
            <div class="cert-card-header">
                <form method="GET" action="{{ route('certificates.verify') }}" class="row g-2">
                    <div class="col-12 col-md-9">
                        <label class="form-label mb-1 fw-semibold">
                            Certificate Number
                        </label>
                        <input
                            type="text"
                            name="cert_no"
                            class="form-control"
                            placeholder="e.g. 45990 / 2025/C/M02/B/590"
                            value="{{ old('cert_no', $query) }}"
                            autocomplete="off"
                        >
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-end">
                        <button class="btn w-100 text-white" type="submit"
                                style="background-color:#3B2818;border-color:#3B2818;">
                            Verify
                        </button>
                    </div>
                </form>
            </div>

            <div class="cert-card-body">
                @if($query === null || $query === '')
                    <p class="text-muted mb-0">
                        Enter a certificate number above and click <strong>Verify</strong>.
                    </p>
                @else
                    @if($record)
                        {{-- VALID RESULT --}}
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">
                                Result for:
                                <span class="brand-accent">{{ $query }}</span>
                            </span>
                            <span class="badge-valid">VALID CERTIFICATE</span>
                        </div>

                        <hr class="my-2">

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="small result-label">Student Name</div>
                                <div class="result-value">{{ $record->Students_Name }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="small result-label">Admission No.</div>
                                <div class="result-value">{{ $record->Admn_No }}</div>
                            </div>

                            <div class="col-md-12">
                                <div class="small result-label">Course</div>
                                <div class="result-value">{{ $record->COURSE }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="small result-label">Gender</div>
                                <div class="result-value">{{ $record->Gender }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="small result-label">ID / Passport No.</div>
                                <div class="result-value">{{ $record->ID_No }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="small result-label">County</div>
                                <div class="result-value">{{ $record->COUNTY }}</div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="small result-label">Start Date</div>
                                <div class="result-value">
                                    {{ $record->START_DATE ? \Carbon\Carbon::parse($record->START_DATE)->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="small result-label">End Date</div>
                                <div class="result-value">
                                    {{ $record->END_DATE ? \Carbon\Carbon::parse($record->END_DATE)->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="small result-label">Certificate No.</div>
                                <div class="result-value">{{ $record->CERT_NO }}</div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="small result-label">Amount Paid</div>
                                <div class="result-value">
                                    @if($record->AMOUNT_PAID !== null)
                                        KSh {{ number_format($record->AMOUNT_PAID, 2) }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            @if($record->COMMENT_SIGNATURE)
                                <div class="col-12 mt-3">
                                    <div class="small result-label">Comment / Signature</div>
                                    <div class="result-value">{{ $record->COMMENT_SIGNATURE }}</div>
                                </div>
                            @endif
                        </div>
                    @else
                        {{-- NOT FOUND --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>
                                Result for:
                                <span class="brand-accent">{{ $query }}</span>
                            </span>
                            <span class="badge-invalid">NOT FOUND</span>
                        </div>
                        <hr class="my-2">
                        <p class="mb-1">
                            We could not find any certificate matching the number you provided.
                        </p>
                        <p class="text-muted mb-0">
                            Please confirm the certificate number and try again. If the problem persists,
                            contact KIHBT for verification.
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

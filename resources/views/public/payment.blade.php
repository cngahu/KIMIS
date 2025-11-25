@extends('layouts.public')

@section('content')

    @php
        $meta    = $application->metadata ?? [];
        $isShort = !empty($meta['short_term']);
        $appCount = $meta['applicant_count'] ?? null;
        $amountPerApplicant = $meta['amount_per_applicant'] ?? null;
    @endphp

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- SUCCESS FLASH (optional) --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}<br>

                    @if(session('total_amount'))
                        <strong>Total to pay:</strong>
                        KSh {{ number_format(session('total_amount'), 2) }}
                        @if(session('applicant_count'))
                            <span class="text-muted">
                                ({{ session('applicant_count') }} applicant{{ session('applicant_count') > 1 ? 's' : '' }})
                            </span>
                        @endif
                    @endif
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        Payment for Application:
                        <strong>{{ $application->reference }}</strong>
                    </h4>
                    <small class="text-muted">
                        @if($isShort)
                            Short Course (Group Application)
                        @else
                            Standard Application
                        @endif
                    </small>
                </div>

                <div class="card-body">

                    <p class="mb-4">
                        Please review the invoice below and click the button to proceed with payment.
                    </p>

                    {{-- INVOICE DETAILS --}}
                    <div class="border p-3 rounded mb-4 bg-light">
                        <h5 class="mb-3">Invoice Details</h5>

                        <p><strong>Invoice Number:</strong> {{ $application->invoice->invoice_number }}</p>
                        <p><strong>Applicant Name:</strong> {{ $application->full_name }}</p>
                        <p><strong>Course:</strong> {{ $application->course->course_name }}</p>

                        @if($isShort && $appCount && $amountPerApplicant)
                            <p class="mb-1">
                                <strong>Amount per Applicant:</strong>
                                KES {{ number_format($amountPerApplicant, 2) }}
                            </p>
                            <p class="mb-1">
                                <strong>Number of Applicants:</strong>
                                {{ $appCount }}
                            </p>
                            <p class="mb-1">
                                <strong>Total Amount:</strong>
                                KES {{ number_format($application->invoice->amount, 2) }}
                            </p>
                        @else
                            <p class="mb-1">
                                <strong>Amount:</strong>
                                KES {{ number_format($application->invoice->amount, 2) }}
                            </p>
                        @endif

                        <p class="mt-2 mb-0">
                            <strong>Status:</strong>
                            @if($application->invoice->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending Payment</span>
                            @endif
                        </p>
                    </div>

                    {{-- SHORT-TERM: APPLICANT LIST --}}
                    @if($isShort && isset($shortApplicants) && $shortApplicants->count())
                        <div class="border p-3 rounded mb-4">
                            <h5 class="mb-3">Applicant Details</h5>

                            @if($application->financier === 'employer' && !empty($meta['employer_name']))
                                <p class="mb-2">
                                    <strong>Employer / Institution:</strong>
                                    {{ $meta['employer_name'] }}
                                </p>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>ID No</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shortApplicants as $idx => $applicant)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $applicant->full_name }}</td>
                                            <td>{{ $applicant->id_no ?? '-' }}</td>
                                            <td>{{ $applicant->phone ?? '-' }}</td>
                                            <td>{{ $applicant->email ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- PAY BUTTON (only if not yet paid) --}}
                    @if($application->invoice->status !== 'paid')
                        <a href="{{ route('applications.pay.now', $application->id) }}"
                           class="btn btn-success btn-lg w-100 mb-3">
                            Pay Now
                        </a>

                        <p class="text-muted small text-center mb-0">
                            You will be redirected to the secure payment page.
                        </p>
                    @else
                        <div class="alert alert-success text-center">
                            Payment has already been received for this invoice.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection

@extends('layouts.public')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        Payment for Application: <strong>{{ $application->reference }}</strong>
                    </h4>
                </div>

                <div class="card-body">

                    <p class="mb-4">
                        Please review the invoice below and click the button to proceed with payment.
                    </p>

                    <!-- INVOICE DETAILS -->
                    <div class="border p-3 rounded mb-4 bg-light">
                        <h5 class="mb-3">Invoice Details</h5>

                        <p><strong>Invoice Number:</strong> {{ $application->invoice->invoice_number }}</p>
                        <p><strong>Applicant Name:</strong> {{ $application->full_name }}</p>
                        <p><strong>Course:</strong> {{ $application->course->course_name }}</p>
                        <p><strong>Amount:</strong> KES {{ number_format($application->invoice->amount, 2) }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-warning text-dark">Pending Payment</span>
                        </p>
                    </div>

                    <a href="{{ route('applications.pay.now', $application->id) }}"
                       class="btn btn-success btn-lg w-100 mb-3">
                        Pay Now
                    </a>

                    <p class="text-muted small text-center">
                        You will be redirected to the secure payment page.
                    </p>

                </div>
            </div>

        </div>
    </div>

@endsection

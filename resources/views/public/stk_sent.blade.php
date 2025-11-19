@extends('layouts.public')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h4 class="mb-3 text-success">Payment Request Sent</h4>

                    <p>Please check your phone (<strong>{{ $application->phone }}</strong>)</p>
                    <p class="mb-4">Enter your M-PESA PIN to complete the transaction.</p>

                    <div class="alert alert-info">
                        <strong>Invoice:</strong> {{ $invoice->invoice_number }}<br>
                        <strong>Amount:</strong> KES {{ number_format($invoice->amount, 2) }}
                    </div>

                    <a href="{{ route('applications.payment', $application->id) }}" class="btn btn-primary">
                        Refresh Payment Status
                    </a>

                </div>
            </div>

        </div>
    </div>

@endsection

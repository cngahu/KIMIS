@extends('layouts.public')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg p-4 text-center">

            <h2 class="text-success mb-3">
                🎉 Payment Submitted Successfully!
            </h2>

            <p class="lead">
                Thank you for completing your payment.
            </p>

            @if($invoiceNo)
                <p class="mt-3">
                    <strong>Invoice Number:</strong> {{ $invoiceNo }}
                </p>
            @endif

            <p class="text-muted mt-2">
                Your payment is being verified. This may take a few moments.
            </p>

            <p class="text-muted">
                Once verified, your application will be updated automatically.
            </p>

            <a href="{{ route('/') }}" class="btn btn-primary mt-4">
            Home
            </a>
        </div>
    </div>
@endsection

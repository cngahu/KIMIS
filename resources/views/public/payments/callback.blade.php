@extends('layouts.public')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg p-4 text-center">

            <h2 class="text-success mb-3">
                🎉 Payment Submitted!
            </h2>

            @if(session('success'))
                <p class="lead">{{ session('success') }}</p>
            @else
                <p class="lead">Your payment was processed. Thank you!</p>
            @endif

            <p class="text-muted mt-2">
                You will receive confirmation once the payment has been verified.
            </p>

            <a href="{{ url('/') }}" class="btn btn-primary mt-4">
                Back To Home
            </a>

        </div>
    </div>
@endsection

@extends('layouts.public')

@section('content')
    <div class="container mt-5" style="max-width:520px;">
        <div class="card shadow-sm">
            <div class="card-body text-center p-4">

                <div class="mb-3">
                    <i class="la la-envelope-open-text"
                       style="font-size:3rem;color:#28a745;"></i>
                </div>

                <h4 class="mb-2">Account Activated Successfully</h4>

                <p class="text-muted mb-3">
                    Your student portal account has been created.
                </p>

                <div class="alert alert-success text-start">
                    <strong>What happens next?</strong>
                    <ul class="mb-0 mt-2">
                        <li>An email has been sent to <strong>{{ session('activation_email') }}</strong></li>
                        <li>The email contains your <strong>username</strong> and <strong>temporary password</strong></li>
                        <li>You will be required to <strong>change your password</strong> on first login</li>
                    </ul>
                </div>

                <p class="small text-muted">
                    Didn’t receive the email? Please check your <strong>Spam / Junk</strong> folder
                    or contact the ICT office.
                </p>

                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Proceed to Login
                    </a>

                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        Back to Home
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

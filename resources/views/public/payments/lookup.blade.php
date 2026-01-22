@extends('layouts.public')

@section('content')
    <section class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="fw-bold mb-3 text-center">
                            Find Your Application
                        </h4>

                        <p class="text-muted text-center mb-4">
                            Enter your application reference to view balance and make payment
                        </p>

                        <form method="POST" action="{{ route('payments.lookup') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Application Reference</label>
                                <input type="text"
                                       name="reference"
                                       class="form-control"
                                       placeholder="e.g. STAPP-ABC123"
                                       required>
                                @error('reference')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button class="btn btn-primary w-100 btn-lg">
                                Continue
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection

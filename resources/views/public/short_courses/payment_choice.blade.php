@extends('layouts.public')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h4 class="fw-bold mb-3">Short Course Payment</h4>

                            <p class="mb-2">
                                <strong>Application Reference:</strong>
                                {{ $application->reference }}
                            </p>

                            <p class="mb-3">
                                <strong>Training:</strong>
                                {{ optional($application->training)->name }}
                            </p>

                            <div class="alert alert-info">
                                Outstanding Balance:
                                <strong>KES {{ number_format($outstanding, 2) }}</strong>
                            </div>

                            @if($outstanding <= 0)
                                <div class="alert alert-success">
                                    ✔ This application is fully paid.
                                </div>
                            @else
                                <form method="POST"
                                      action="{{ route('short_training.application.payment.create', $application->reference) }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Amount to Pay</label>
                                        <input type="number"
                                               name="amount"
                                               class="form-control"
                                               min="1"
                                               max="{{ $outstanding }}"
                                               required>
                                    </div>

                                    <button class="btn btn-primary btn-lg w-100">
                                        Proceed to Payment
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

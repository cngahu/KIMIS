@extends('layouts.public')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h4 class="fw-bold mb-3">
                                <i class="la la-bed me-1"></i> Hostel Payment
                            </h4>

                            {{-- Booking reference --}}
                            <p class="mb-2">
                                <strong>Booking Reference:</strong>
                                {{ $booking->reference }}
                            </p>

                            {{-- Course --}}
                            <p class="mb-2">
                                <strong>Course:</strong>
                                {{ optional($booking->course)->course_name }}
                            </p>

                            {{-- Campus --}}
                            <p class="mb-2">
                                <strong>Campus:</strong>
                                {{ optional($booking->college)->name }}
                            </p>

                            {{-- Boarding type --}}
                            <p class="mb-3">
                                <strong>Boarding Type:</strong>
                                {{ ucfirst($booking->boarding_type) }} Board
                            </p>

                            {{-- Outstanding --}}
                            <div class="alert alert-info">
                                Amount Payable:
                                <strong>KES {{ number_format($outstanding, 2) }}</strong>
                            </div>

                            @if($outstanding <= 0)
                                <div class="alert alert-success">
                                    ✔ This hostel booking is fully paid.
                                </div>
                            @else
                                {{-- FULL PAYMENT ONLY --}}
                                <form method="POST"
                                      action="{{ route('hostel.booking.payment.create', $booking->reference) }}">
                                    @csrf

                                    <input type="hidden"
                                           name="amount"
                                           value="{{ $outstanding }}">

                                    <div class="mb-3">
                                        <label class="form-label">Amount to Pay</label>
                                        <input type="text"
                                               class="form-control"
                                               value="KES {{ number_format($outstanding, 2) }}"
                                               readonly>
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

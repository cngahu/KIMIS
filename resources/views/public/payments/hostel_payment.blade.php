@extends('layouts.public')

@section('content')

    {{-- HERO --}}
    <section class="page-hero text-center py-4" style="background:#3b2818; color:white;">
        <img src="{{ asset('images/kihbt-logo.png') }}" alt="KIHBT" height="80" class="mb-3">
        <h1 class="fw-bold">Hostel Invoice</h1>
        <p class="mb-0">
            Invoice No:
            <strong>{{ $invoice->invoice_number }}</strong>
        </p>
    </section>

    <section class="px-4 pb-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                {{-- BILL TO --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light fw-bold">Bill To</div>
                    <div class="card-body">

                        <h5 class="fw-bold mb-1">{{ $payer['name'] }}</h5>

                        <p class="mb-0">
                            Phone: {{ $payer['phone'] }} <br>
                            Email: {{ $payer['email'] }}
                        </p>

                        @if(!empty($payer['town']))
                            <p class="text-muted mt-2 mb-0">
                                Campus: {{ $payer['town'] }}
                            </p>
                        @endif

                    </div>
                </div>

                {{-- INVOICE SUMMARY --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light fw-bold">Invoice Summary</div>
                    <div class="card-body">

                        <p class="mb-1">
                            <strong>Invoice Date:</strong>
                            {{ $invoice->created_at->format('d M, Y') }}
                        </p>

                        <p class="mb-3">
                            <strong>Amount Due:</strong>
                            <span class="text-success fw-bold">
                                KSh {{ number_format($invoice->amount, 2) }}
                            </span>
                        </p>

                        {{-- HOSTEL DETAILS --}}
                        <div class="border rounded p-3 mb-3 bg-light">
                            <h6 class="fw-bold mb-2">Hostel Booking Details</h6>

                            <p class="mb-1">
                                <strong>Booking Reference:</strong>
                                {{ $booking->reference }}
                            </p>

                            <p class="mb-1">
                                <strong>Course:</strong>
                                {{ optional($booking->course)->course_name }}
                            </p>

                            <p class="mb-1">
                                <strong>Campus:</strong>
                                {{ optional($booking->college)->name }}
                            </p>

                            <p class="mb-1">
                                <strong>Boarding Type:</strong>
                                {{ ucfirst($booking->boarding_type) }} Board
                            </p>
                        </div>

                        {{-- NOTE --}}
                        <div class="alert alert-info mb-0">
                            Hostel accommodation requires full payment before allocation.
                        </div>

                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <a href="{{ route('hostel.invoice.pdf', $invoice->id) }}"
                           class="btn btn-outline-secondary btn-lg mb-3">
                            <i class="la la-file-pdf"></i> Download Invoice (PDF)
                        </a>

                        <br>

                        <a href="{{ route('hostel.invoice.pay', $invoice->id) }}"
                           class="btn btn-primary btn-lg">
                            Pay Now (KSh {{ number_format($invoice->amount, 2) }})
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

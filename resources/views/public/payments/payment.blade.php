{{--@extends('layouts.public')--}}

{{--@section('content')--}}
{{--    <section class="page-hero">--}}
{{--        <h1>Short Course Payment</h1>--}}
{{--        <p>Invoice Number: <strong>{{ $invoice->invoice_number }}</strong></p>--}}
{{--    </section>--}}

{{--    <section class="px-4 pb-5">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-lg-9">--}}

{{--                <div class="card public-card mb-4">--}}
{{--                    <div class="card-header">Bill To</div>--}}
{{--                    <div class="card-body">--}}

{{--                        <h5 class="mb-1">{{ $payer['name'] }}</h5>--}}

{{--                        @if($payer['type'] === 'employer')--}}
{{--                            <p class="text-muted mb-0">--}}
{{--                                Attn: {{ $payer['contact_person'] }}<br>--}}
{{--                                {{ $payer['address'] }}<br>--}}
{{--                                {{ $payer['town'] }},--}}
{{--                                {{ $payer['county'] }}--}}
{{--                            </p>--}}
{{--                            <p class="mt-2 mb-0 text-muted">--}}
{{--                                Phone: {{ $payer['phone'] }}<br>--}}
{{--                                Email: {{ $payer['email'] }}--}}
{{--                            </p>--}}
{{--                        @else--}}
{{--                            <p class="text-muted mb-0">--}}
{{--                                {{ $payer['address'] }}<br>--}}
{{--                                {{ $payer['town'] }},--}}
{{--                                {{ $payer['county'] }}--}}
{{--                            </p>--}}
{{--                            <p class="mt-2 mb-0 text-muted">--}}
{{--                                Phone: {{ $payer['phone'] }}<br>--}}
{{--                                Email: {{ $payer['email'] }}--}}
{{--                            </p>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="card public-card mb-4">--}}
{{--                    <div class="card-header">Invoice Summary</div>--}}
{{--                    <div class="card-body">--}}
{{--                        <p><strong>Total Amount:</strong>--}}
{{--                            KSh {{ number_format($invoice->amount, 2) }}--}}
{{--                        </p>--}}

{{--                        <p><strong>Participants:</strong></p>--}}

{{--                        <table class="table table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Full Name</th>--}}
{{--                                <th>ID No</th>--}}
{{--                                <th>Phone</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($participants as $index => $person)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $index + 1 }}</td>--}}
{{--                                    <td>{{ $person->full_name }}</td>--}}
{{--                                    <td>{{ $person->id_no }}</td>--}}
{{--                                    <td>{{ $person->phone }}</td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="card public-card">--}}
{{--                    <div class="card-body text-center">--}}
{{--                        <h5 class="mb-3">Ready to Proceed with Payment?</h5>--}}

{{--                        --}}{{-- Placeholder for payment button --}}
{{--                        <a href="#" class="btn btn-primary btn-lg">--}}
{{--                            Pay Now (KSh {{ number_format($invoice->amount, 2) }})--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--@endsection--}}
@extends('layouts.public')

@section('content')
    <section class="page-hero text-center py-4" style="background:#0a664a; color:white;">
        <img src="{{ asset('images/kihbt-logo.png') }}" alt="KIHBT" height="80" class="mb-3">
        <h1 class="fw-bold">Short Course Invoice</h1>
        <p class="mb-0">Invoice No: <strong>{{ $invoice->invoice_number }}</strong></p>
    </section>

    <section class="px-4 pb-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                {{-- BILL TO --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light fw-bold">Bill To</div>
                    <div class="card-body">

                        <h5 class="fw-bold mb-1">{{ $payer['name'] }}</h5>

                        @if($payer['type'] === 'employer')
                            <p class="mb-0">
                                <strong>Attn:</strong> {{ $payer['contact_person'] }} <br>
                                {{ $payer['address'] }} <br>
                                {{ $payer['town'] }}, {{ $payer['county'] }} <br>
                            </p>
                            <p class="text-muted mt-2 mb-0">
                                Phone: {{ $payer['phone'] }} <br>
                                Email: {{ $payer['email'] }}
                            </p>
                        @else
                            <p class="mb-0">
                                {{ $payer['address'] }} <br>
                                {{ $payer['town'] }}, {{ $payer['county'] }} <br>
                            </p>
                            <p class="text-muted mt-2 mb-0">
                                Phone: {{ $payer['phone'] }} <br>
                                Email: {{ $payer['email'] }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- INVOICE DETAILS --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light fw-bold">Invoice Summary</div>
                    <div class="card-body">

                        <p class="mb-1"><strong>Invoice Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
                        <p class="mb-3"><strong>Amount Due:</strong>
                            <span class="text-success fw-bold">KSh {{ number_format($invoice->amount, 2) }}</span>
                        </p>

                        {{-- Training Details --}}
                        @php
                            $training = \App\Models\Training::find($application->training_id);
                        @endphp

                        <div class="border rounded p-3 mb-3 bg-light">
                            <h6 class="fw-bold mb-2">Training Details</h6>
                            <p class="mb-1"><strong>Course:</strong> {{ optional($training->course)->course_name }}</p>
                            <p class="mb-1"><strong>Schedule:</strong> {{ $training->schedule_label ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Campus:</strong> {{ optional($training->college)->name }}</p>
                        </div>

                        {{-- Participants Table --}}
                        <h6 class="fw-bold mb-2">Participants</h6>

                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>ID No</th>
                                <th>Phone</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($participants as $index => $person)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $person->full_name }}</td>
                                    <td>{{ $person->id_no }}</td>
                                    <td>{{ $person->phone }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <a href="{{ route('invoices.pdf', $invoice->id) }}"
                           class="btn btn-outline-secondary btn-lg mb-3">
                            <i class="la la-file-pdf"></i> Download Invoice (PDF)
                        </a>

                        <br>

                        <a href="{{ route('invoices.pay', $invoice->id) }}"
                           class="btn btn-primary btn-lg">
                            Pay Now (KSh {{ number_format($invoice->amount, 2) }})
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

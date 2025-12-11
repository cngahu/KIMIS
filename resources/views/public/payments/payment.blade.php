@extends('layouts.public')

@section('content')
    <section class="page-hero">
        <h1>Short Course Payment</h1>
        <p>Invoice Number: <strong>{{ $invoice->invoice_number }}</strong></p>
    </section>

    <section class="px-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="card public-card mb-4">
                    <div class="card-header">Bill To</div>
                    <div class="card-body">

                        <h5 class="mb-1">{{ $payer['name'] }}</h5>

                        @if($payer['type'] === 'employer')
                            <p class="text-muted mb-0">
                                Attn: {{ $payer['contact_person'] }}<br>
                                {{ $payer['address'] }}<br>
                                {{ $payer['town'] }},
                                {{ $payer['county'] }}
                            </p>
                            <p class="mt-2 mb-0 text-muted">
                                Phone: {{ $payer['phone'] }}<br>
                                Email: {{ $payer['email'] }}
                            </p>
                        @else
                            <p class="text-muted mb-0">
                                {{ $payer['address'] }}<br>
                                {{ $payer['town'] }},
                                {{ $payer['county'] }}
                            </p>
                            <p class="mt-2 mb-0 text-muted">
                                Phone: {{ $payer['phone'] }}<br>
                                Email: {{ $payer['email'] }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="card public-card mb-4">
                    <div class="card-header">Invoice Summary</div>
                    <div class="card-body">
                        <p><strong>Total Amount:</strong>
                            KSh {{ number_format($invoice->amount, 2) }}
                        </p>

                        <p><strong>Participants:</strong></p>

                        <table class="table table-bordered">
                            <thead>
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

                <div class="card public-card">
                    <div class="card-body text-center">
                        <h5 class="mb-3">Ready to Proceed with Payment?</h5>

                        {{-- Placeholder for payment button --}}
                        <a href="#" class="btn btn-primary btn-lg">
                            Pay Now (KSh {{ number_format($invoice->amount, 2) }})
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

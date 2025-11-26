{{--@extends('admin.admin_dashboard')--}}
{{--@section('admin')--}}

{{--    <div class="page-content">--}}
{{--        <h4 class="fw-bold">Fee Payment</h4>--}}

{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--        @endif--}}

{{--        <div class="card p-3 mb-3">--}}
{{--            <p><strong>Course Fee:</strong> KES {{ number_format($courseFee,2) }}</p>--}}
{{--            <p><strong>Total Paid:</strong> KES {{ number_format($totalPaid,2) }}</p>--}}
{{--            <p><strong>Balance:</strong> KES {{ number_format($balance,2) }}</p>--}}
{{--        </div>--}}

{{--        <div class="row g-3 mb-4">--}}
{{--            <div class="col-md-6">--}}
{{--                <div class="card p-3">--}}
{{--                    <h5>Pay Full Amount</h5>--}}
{{--                    <p>Pay the outstanding balance in full.</p>--}}
{{--                    <form action="{{ route('student.admission.payment.create') }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="mode" value="full">--}}
{{--                        <input type="hidden" name="amount" value="{{ $balance }}">--}}
{{--                        <button class="btn btn-primary">Proceed to Pay KES {{ number_format($balance,2) }}</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-6">--}}
{{--                <div class="card p-3">--}}
{{--                    <h5>Pay Partial Amount</h5>--}}
{{--                    <p>Make a part payment towards the balance.</p>--}}
{{--                    <form action="{{ route('student.admission.payment.create') }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="mode" value="partial">--}}
{{--                        <label>Amount (KES)</label>--}}
{{--                        <input type="number" name="amount" min="1" max="{{ $balance }}" class="form-control" required>--}}
{{--                        <button class="btn btn-outline-primary mt-2">Create Invoice & Pay</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-6">--}}
{{--                <div class="card p-3">--}}
{{--                    <h5>Sponsored / Bursary</h5>--}}
{{--                    <p>If a sponsor will pay on your behalf, submit sponsor details for verification.</p>--}}
{{--                    <a href="{{ route('student.admission.payment.sponsor') }}" class="btn btn-secondary">Submit Sponsor Info</a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-6">--}}
{{--                <div class="card p-3">--}}
{{--                    <h5>Request Pay Later</h5>--}}
{{--                    <p>If you cannot pay now, submit a request explaining your situation.</p>--}}
{{--                    <a href="{{ route('student.admission.payment.later') }}" class="btn btn-outline-secondary">Request Pay Later</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- Payment history --}}
{{--        <div class="card p-3">--}}
{{--            <h5>Payment History</h5>--}}
{{--            <table class="table">--}}
{{--                <thead><tr><th>Type</th><th>Amount</th><th>Status</th><th>Invoice</th><th>Paid At</th></tr></thead>--}}
{{--                <tbody>--}}
{{--                @foreach($payments as $p)--}}
{{--                    <tr>--}}
{{--                        <td>{{ ucfirst($p->payment_type) }}</td>--}}
{{--                        <td>{{ number_format($p->amount,2) }}</td>--}}
{{--                        <td>{{ $p->status }}</td>--}}
{{--                        <td>--}}
{{--                            @if($p->invoice)--}}
{{--                                <a href="{{ route('student.admission.payment.iframe', $p->invoice->id) }}" target="_blank">{{ $p->invoice->invoice_number }}</a>--}}
{{--                            @else--}}
{{--                                ---}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                        <td>{{ optional($p->paid_at)->format('d M Y H:i') ?? '-' }}</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <h4 class="fw-bold">Fee Payment</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- SUMMARY CARD --}}
        <div class="card p-3 mb-3">
            <p><strong>Course Fee:</strong> KES {{ number_format($courseFee,2) }}</p>
            <p><strong>Total Paid:</strong> KES {{ number_format($totalPaid,2) }}</p>
            <p><strong>Balance:</strong> KES {{ number_format($balance,2) }}</p>
        </div>

        {{-- IF FULLY PAID --}}
        @if($balance <= 0)

            <div class="alert alert-success p-4">
                <h5 class="fw-bold mb-2">🎉 Fee Fully Paid</h5>
                <p class="mb-0">
                    Thank you. You have successfully cleared all required fees for admission.
                </p>
            </div>

            {{-- PAYMENT HISTORY --}}
            <div class="card p-3 mt-4">
                <h5>Payment History</h5>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Invoice</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $p)
                        <tr>
                            <td>{{ ucfirst($p->payment_type) }}</td>
                            <td>{{ number_format($p->amount,2) }}</td>
                            <td>{{ $p->status }}</td>
                            <td>
                                @if($p->invoice)
                                    <a href="{{ route('student.admission.payment.iframe', $p->invoice->id) }}" target="_blank">
                                        {{ $p->invoice->invoice_number }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ optional($p->updated_at)->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        @endif


        {{-- ========================================================= --}}
        {{--        PAYMENT OPTIONS (Only when balance > 0)             --}}
        {{-- ========================================================= --}}

        @if($balance>0)
            <div class="row g-3 mb-4">

                {{-- PAY FULL BALANCE --}}
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <h5>Pay Full Amount</h5>
                        <p>Pay the outstanding balance in one payment.</p>

                        <form action="{{ route('student.admission.payment.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="mode" value="full">
                            <input type="hidden" name="amount" value="{{ $balance }}">

                            <button class="btn btn-primary w-100">
                                Pay KES {{ number_format($balance,2) }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- PARTIAL PAYMENT --}}
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <h5>Pay Partial Amount</h5>
                        <p>Make a part payment toward your balance.</p>

                        <form action="{{ route('student.admission.payment.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="mode" value="partial">

                            <label class="form-label">Amount (KES)</label>
                            <input type="number"
                                   name="amount"
                                   class="form-control"
                                   min="1"
                                   max="{{ $balance }}"
                                   required>

                            <button class="btn btn-outline-primary w-100 mt-3">
                                Create Invoice & Pay
                            </button>
                        </form>
                    </div>
                </div>

                {{-- SPONSOR INFO --}}
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <h5>Sponsored / Bursary</h5>
                        <p>If a sponsor or bursary will pay on your behalf, upload the supporting documents.</p>

                        <a href="{{ route('student.admission.payment.sponsor') }}"
                           class="btn btn-secondary w-100">
                            Submit Sponsor Details
                        </a>
                    </div>
                </div>

                {{-- PAY LATER REQUEST --}}
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <h5>Request Pay Later</h5>
                        <p>Request permission to pay at a later date with an explanation.</p>

                        <a href="{{ route('student.admission.payment.later') }}"
                           class="btn btn-outline-secondary w-100">
                            Request Pay Later
                        </a>
                    </div>
                </div>

            </div>


            {{-- PAYMENT HISTORY --}}
            <div class="card p-3">
                <h5>Payment History</h5>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Invoice</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $p)
                        <tr>
                            <td>{{ ucfirst($p->payment_type) }}</td>
                            <td>{{ number_format($p->amount,2) }}</td>
                            <td>{{ $p->status }}</td>
                            <td>
                                @if($p->invoice)
                                    <a href="{{ route('student.admission.payment.iframe', $p->invoice->id) }}" target="_blank">
                                        {{ $p->invoice->invoice_number }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ optional($p->paid_at)->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        @endif
    </div>

@endsection

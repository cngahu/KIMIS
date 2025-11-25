@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-3">Fee Payment</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif


        {{-- ===== FEE SUMMARY CARD ===== --}}
        <div class="card p-3 mb-3">

            <p><strong>Course Fee:</strong> KES {{ number_format($courseFee,2) }}</p>
            <p><strong>Total Paid:</strong> KES {{ number_format($totalPaid,2) }}</p>

            @if($balance <= 0)
                <p><strong>Balance:</strong> <span class="text-success">PAID IN FULL</span></p>
            @else
                <p><strong>Balance:</strong> KES {{ number_format($balance,2) }}</p>
            @endif

            {{-- Status label --}}
            <p class="mt-2">
                <strong>Status: </strong>
                @if($balance <= 0)
                    <span class="badge bg-success">Fee Fully Paid</span>
                @elseif($admission->status === 'awaiting_sponsor_verification')
                    <span class="badge bg-warning text-dark">Awaiting Sponsor Verification</span>
                @elseif($admission->status === 'awaiting_fee_decision')
                    <span class="badge bg-warning text-dark">Awaiting Finance Decision</span>
                @elseif($admission->status === 'awaiting_fee_balance')
                    <span class="badge bg-info text-dark">Partial Payment Made</span>
                @else
                    <span class="badge bg-danger">Fee Not Fully Cleared</span>
                @endif
            </p>

        </div>



        {{-- ===== PAYMENT OPTIONS ===== --}}
        @if($balance > 0 && $admission->status !== 'awaiting_sponsor_verification')

            <div class="row g-3 mb-4">

                {{-- === FULL PAYMENT === --}}
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5>Pay Full Amount</h5>
                        <p>Pay the remaining balance at once.</p>

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

                {{-- === PARTIAL PAYMENT === --}}
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5>Partial Payment</h5>
                        <p>Make a smaller payment and finish the rest later.</p>

                        <form action="{{ route('student.admission.payment.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="mode" value="partial">
                            <label>Amount (KES)</label>
                            <input type="number" name="amount" class="form-control"
                                   min="1" max="{{ $balance }}" required>
                            <button class="btn btn-outline-primary w-100 mt-2">
                                Pay Selected Amount
                            </button>
                        </form>
                    </div>
                </div>

                {{-- === SPONSOR / BURSARY === --}}
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5>Sponsored / Bursary</h5>
                        <p>A sponsor will pay on your behalf.</p>
                        <a href="{{ route('student.admission.payment.sponsor') }}"
                           class="btn btn-secondary w-100">Submit Sponsor Details</a>
                    </div>
                </div>

                {{-- === PAY LATER REQUEST === --}}
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5>Request Pay Later</h5>
                        <p>Submit a request explaining why you cannot pay now.</p>
                        <a href="{{ route('student.admission.payment.later') }}"
                           class="btn btn-outline-secondary w-100">Request Pay Later</a>
                    </div>
                </div>

            </div>

        @else
            {{-- FULLY PAID MESSAGE --}}
            <div class="alert alert-success">
                🎉 <strong>Your fee is fully paid!</strong> You can now proceed with the admission process.
            </div>
        @endif




        {{-- ===== PAYMENT HISTORY TABLE ===== --}}
        <div class="card p-3">
            <h5>Payment History</h5>

            <table class="table table-bordered">
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

                        <td>
                            @if($p->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($p->invoice)
                                <a href="{{ route('student.admission.payment.iframe', $p->invoice->id) }}"
                                   target="_blank">
                                    {{ $p->invoice->invoice_number }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td>
                            {{ optional($p->paid_at)->format('d M Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    </div>

@endsection

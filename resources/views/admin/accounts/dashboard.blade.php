@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-3">Accounts Dashboard</h4>

        <div class="row g-3 mb-4">

            @foreach([
                ['Total Invoices', $totalInvoices, 'bx-receipt', 'bg-primary'],
                ['Paid', $paidInvoices, 'bx-check-circle', 'bg-success'],
                ['Pending', $pendingInvoices, 'bx-time-five', 'bg-warning'],
                ['Sponsor Pending', $sponsorPending, 'bx-user-voice', 'bg-info'],
                ['Pay-Later Requests', $payLaterPending, 'bx-help-circle', 'bg-secondary'],
                ['Partial Payments', $partialPending, 'bx-bitcoin', 'bg-dark'],
            ] as $card)

                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>{{ $card[0] }}</h5>
                                <h2>{{ $card[1] }}</h2>
                            </div>
                            <div>
                                <i class="bx {{ $card[2] }} fs-2 {{ $card[3] }} text-white p-2 rounded-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>Total Invoiced</h5>
                    <h3>{{ number_format($totalInvoiced, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>Total Paid</h5>
                    <h3>{{ number_format($totalPaid, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>Total Pending</h5>
                    <h3>{{ number_format($totalPending, 2) }}</h3>
                </div>
            </div>
        </div>

    </div>
@endsection

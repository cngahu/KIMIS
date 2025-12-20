@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold">Invoice</h4>
                <p class="text-muted mb-0">
                    Invoice No: <strong>{{ $invoice->invoice_number }}</strong>
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('student.fees.invoice.pdf', $invoice) }}"
                   class="btn btn-outline-secondary">
                    <i class="fas fa-download me-1"></i>
                    PDF
                </a>

                @if($invoice->status === 'pending')
                    <a href="{{ route('student.payments.iframe', $invoice) }}"
                       class="btn btn-primary">
                        Pay Now
                    </a>
                @endif

                @if($invoice->status === 'paid')
                    <a href="{{ route('student.fees.receipt.pdf', $invoice) }}"
                       class="btn btn-success">
                        Download Receipt
                    </a>
                @endif
            </div>
        </div>

        {{-- Invoice card --}}
        <div class="card radius-10 shadow-sm">
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status:</strong>
                            @if($invoice->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </p>
                        <p class="mb-1"><strong>Date:</strong>
                            {{ $invoice->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Total Amount:</strong></p>
                        <h5 class="fw-bold">
                            KES {{ number_format($invoice->amount, 2) }}
                        </h5>
                    </div>
                </div>

                {{-- Items --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th class="text-end">Amount (KES)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td class="text-end">
                                    {{ number_format($item->total_amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th class="text-end">
                                {{ number_format($invoice->amount, 2) }}
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection

{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}

{{--    <div class="page-content">--}}

{{--        <div class="mb-4">--}}
{{--            <h4 class="fw-bold">Fees & Financials</h4>--}}
{{--            <p class="text-muted mb-0">--}}
{{--                View invoices, receipts, and download your fee statement--}}
{{--            </p>--}}
{{--        </div>--}}

{{--        --}}{{-- Action buttons --}}
{{--        <div class="d-flex gap-2 mb-3">--}}
{{--            <a href="{{ route('student.fees.statement') }}"--}}
{{--               class="btn btn-outline-primary">--}}
{{--                <i class="fas fa-file-pdf me-1"></i>--}}
{{--                Download Fee Statement--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        --}}{{-- Invoices table --}}
{{--        <div class="card radius-10 shadow-sm">--}}
{{--            <div class="card-body">--}}

{{--                <h6 class="fw-bold mb-3">Invoices</h6>--}}

{{--                <div class="table-responsive">--}}
{{--                    <table class="table table-hover align-middle">--}}
{{--                        <thead class="table-light">--}}
{{--                        <tr>--}}
{{--                            <th>Date</th>--}}
{{--                            <th>Invoice No</th>--}}
{{--                            <th>Description</th>--}}
{{--                            <th class="text-end">Amount (KES)</th>--}}
{{--                            <th>Status</th>--}}
{{--                            <th class="text-end">Action</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}

{{--                        <tbody>--}}
{{--                        @forelse($invoices as $invoice)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $invoice->created_at->format('d M Y') }}</td>--}}

{{--                                <td>--}}
{{--                                    <strong>{{ $invoice->invoice_number }}</strong>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    @if($invoice->category === 'tuition_fee')--}}
{{--                                        Tuition Fee--}}
{{--                                    @elseif($invoice->category === 'admission_fee')--}}
{{--                                        Admission Fee--}}
{{--                                    @elseif($invoice->category === 'short_course')--}}
{{--                                        Short Course Fee--}}
{{--                                    @else--}}
{{--                                        {{ ucfirst(str_replace('_',' ', $invoice->category)) }}--}}
{{--                                    @endif--}}
{{--                                </td>--}}

{{--                                <td class="text-end">--}}
{{--                                    {{ number_format($invoice->amount, 2) }}--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    @if($invoice->status === 'paid')--}}
{{--                                        <span class="badge bg-success">Paid</span>--}}
{{--                                    @elseif($invoice->status === 'pending')--}}
{{--                                        <span class="badge bg-warning text-dark">Pending</span>--}}
{{--                                    @else--}}
{{--                                        <span class="badge bg-secondary">Failed</span>--}}
{{--                                    @endif--}}
{{--                                </td>--}}

{{--                                <td class="text-end">--}}
{{--                                    <div class="btn-group btn-group-sm">--}}

{{--                                        --}}{{-- View invoice --}}
{{--                                        <a href="{{ route('student.fees.invoice.show', $invoice) }}"--}}
{{--                                           class="btn btn-outline-primary">--}}
{{--                                            View--}}
{{--                                        </a>--}}

{{--                                        --}}{{-- Pay --}}
{{--                                        @if($invoice->status === 'pending')--}}
{{--                                            <a href="{{ route('student.payments.iframe', $invoice) }}"--}}
{{--                                               class="btn btn-outline-warning">--}}
{{--                                                Pay--}}
{{--                                            </a>--}}
{{--                                        @endif--}}

{{--                                        --}}{{-- Receipt --}}
{{--                                        @if($invoice->status === 'paid')--}}
{{--                                            <a href="{{ route('student.fees.receipt.pdf', $invoice) }}"--}}
{{--                                               class="btn btn-outline-success">--}}
{{--                                                Receipt--}}
{{--                                            </a>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @empty--}}
{{--                            <tr>--}}
{{--                                <td colspan="6" class="text-center text-muted py-4">--}}
{{--                                    No invoices found.--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforelse--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')

{{--    <div class="page-content">--}}
    <div class="container">

        <h5 class="mb-3">My Fee Statement</h5>

        <div class="alert {{ $balance <= 0 ? 'alert-success' : 'alert-warning' }}">
            <strong>Current Balance:</strong>
            {{ number_format($balance, 2) }}
        </div>

        <div class="card mb-4">
            <div class="card-body table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th class="text-end">Debit</th>
                        <th class="text-end">Credit</th>
                        <th class="text-end">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ledger as $row)
                        <tr>
                            <td>{{ $row->created_at->format('d M Y') }}</td>
                            <td>{{ $row->description }}</td>
                            <td class="text-end">
                                {{ $row->entry_type === 'debit' ? number_format($row->amount,2) : '' }}
                            </td>
                            <td class="text-end">
                                {{ $row->entry_type === 'credit' ? number_format($row->amount,2) : '' }}
                            </td>
                            <td class="text-end">
                                {{ number_format($row->running_balance,2) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('student.fees.download') }}"
           class="btn btn-primary">
            Download Official Fee Statement (PDF)
        </a>

    </div>
@endsection

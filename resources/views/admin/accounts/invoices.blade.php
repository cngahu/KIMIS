@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-3">Invoices</h4>

        <div class="card radius-10 p-3">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Invoice No</th>
                        <th>Categorization</th>
                        <th>Payer</th>
                        <th>Billable Item</th>
                        <th>Description</th>
                        <th class="text-end">Amount (KES)</th>
                        <th>Status</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($invoices as $inv)
                        <tr>

                            {{-- Invoice Number --}}
                            <td class="fw-semibold">
                                {{ $inv->invoice_number }}
                            </td>

                            {{-- Raised By --}}
                            <td>
                                {{ $inv->category }}
                            </td>

                            {{-- Who is paying --}}
                            <td>
                                {{ $inv->payer_display }}
                            </td>

                            {{-- Category --}}
                            <td>
                            <span class="badge bg-secondary">
                                {{ $inv->billable_label }}
                            </span>
                            </td>

                            {{-- What is being paid for --}}
                            <td>
                                {{ $inv->billable_description }}
                            </td>

                            {{-- Amount --}}
                            <td class="text-end fw-semibold">
                                {{ number_format($inv->amount, 2) }}
                            </td>

                            {{-- Status --}}
                            <td>
                            <span class="badge
                                @if($inv->status === 'paid') bg-success
                                @elseif($inv->status === 'pending') bg-warning text-dark
                                @else bg-danger
                                @endif">
                                {{ strtoupper($inv->status) }}
                            </span>
                            </td>

                            {{-- Paid At --}}
                            <td>
                                {{ optional($inv->paid_at)->format('d M Y H:i') ?? '—' }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No invoices found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>

@endsection

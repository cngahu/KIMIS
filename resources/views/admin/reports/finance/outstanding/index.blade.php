@extends('admin.admin_dashboard')

@section('admin')

    @php
        // Helper: Resolve course/training name from billable record
        function invoiceCourseName($invoice) {

            $billable = $invoice->billable;
            if (!$billable) return 'N/A';

            // Long Course Application
            if ($invoice->billable_type === \App\Models\Application::class) {
                return optional($billable->course)->course_name ?? 'N/A';
            }

            // Short Course Application
            if ($invoice->billable_type === \App\Models\ShortTrainingApplication::class) {
                return optional($billable->training->course)->course_name ?? 'N/A';
            }

            return 'N/A';
        }

        // Helper: Resolve payer name
        function invoicePayer($invoice) {

            $billable = $invoice->billable;
            if (!$billable) return 'Unknown';

            // Long Course Application
            if ($invoice->billable_type === \App\Models\Application::class) {
                return $billable->full_name;
            }

            // Short Course Application
            if ($invoice->billable_type === \App\Models\ShortTrainingApplication::class) {
                return $billable->financier === 'employer'
                        ? $billable->employer_name
                        : optional($billable->participants->first())->full_name;
            }

            return 'Unknown';
        }
    @endphp


    <div class="page-content">

        <h4 class="mb-3">Outstanding Payments Report</h4>

        <div class="card shadow-sm">
            <div class="card-body">

                <table id="outstandingTable" class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Invoice No.</th>
                        <th>Payer</th>
                        <th>Category</th>
                        <th>Course / Training</th>
                        <th>Expected Amount</th>
                        <th>Ecitizen Amount</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Days Outstanding</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($invoices as $inv)
                        <tr>
                            <td>{{ $inv->invoice_number }}</td>

                            <td>{{ invoicePayer($inv) }}</td>

                            <td>{{ ucfirst(str_replace('_', ' ', $inv->category)) }}</td>

                            <td>{{ invoiceCourseName($inv) }}</td>

                            <td>KSh {{ number_format($inv->amount, 2) }}</td>

                            <td>
                                {{ $inv->invoice_amount ? 'KSh '.number_format($inv->invoice_amount,2) : '-' }}
                            </td>

                            <td>{{ $inv->payment_channel ?? '-' }}</td>

                            <td class="text-danger fw-bold">Pending</td>

                            <td>{{ $inv->created_at->format('d M Y') }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($inv->created_at)->diffInDays(now()) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection


@push('scripts')
    <script>
        new DataTable('#outstandingTable', {
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']]
        });
    </script>
@endpush

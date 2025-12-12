@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <h4 class="mb-3">Daily Collections Report</h4>

        <!-- FILTERS -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET">

                    <div class="row">
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                        </div>

                        <div class="col-md-3">
                            <label>From</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label>To</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Category</label>
                            <select name="category" class="form-select">
                                <option value="">All</option>
                                @foreach(['application_fee','admission_fee','course_fee','knec_application','misc','short_course'] as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ', $cat)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">Filter</button>

                        <a href="{{ route('reports.daily.collections.pdf') }}?{{ request()->getQueryString() }}"
                           target="_blank" class="btn btn-success">
                            Download PDF
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="dailyTable" class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Invoice #</th>
                        <th>Category</th>
                        <th>Payer</th>
                        <th>Amount</th>
                        <th>Amount Paid</th>
                        <th>Channel</th>
                        <th>Ecitizen Ref</th>
                        <th>Gateway Ref</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($invoices as $inv)
                        <tr>
                            <td>{{ $inv->invoice_number }}</td>
                            <td>{{ ucfirst($inv->category) }}</td>
                            <td>{{ optional($inv->billable)->full_name ?? optional($inv->billable)->employer_name ?? 'N/A' }}</td>
                            <td>KSh {{ number_format($inv->amount, 2) }}</td>
                            <td class="fw-bold text-success">KSh {{ number_format($inv->amount_paid, 2) }}</td>
                            <td>{{ $inv->payment_channel }}</td>
                            <td>{{ $inv->ecitizen_invoice_number }}</td>
                            <td>{{ $inv->gateway_reference }}</td>
                            <td>{{ optional($inv->paid_at)->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            new DataTable('#dailyTable', {
                responsive: true,
                pageLength: 50,
                order: [[8, 'desc']]
            });
        </script>
    @endpush

@endsection

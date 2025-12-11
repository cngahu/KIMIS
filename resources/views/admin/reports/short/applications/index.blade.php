@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="mb-3">Short Course Applications Report</h4>

        <!-- FILTERS -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <form method="GET" id="filterForm">

                    <div class="row">

                        <div class="col-md-3">
                            <label class="form-label">Training / Schedule</label>
                            <select name="training_id" class="form-select">
                                <option value="">All</option>
                                @foreach($trainings as $t)
                                    <option value="{{ $t->id }}">{{ $t->course->course_name }} – {{ $t->start_date }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Financier</label>
                            <select name="financier" class="form-select">
                                <option value="">All</option>
                                <option value="self">Self</option>
                                <option value="employer">Employer</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="">All</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date From</label>
                            <input type="date" name="from_date" class="form-control">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label class="form-label">Date To</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">Apply Filters</button>

                        <a class="btn btn-success"
                           target="_blank"
                           href="{{ route('reports.short.applications.pdf') }}?{{ request()->getQueryString() }}">
                            Download PDF
                        </a>
                    </div>

                </form>

            </div>
        </div>


        <!-- TABLE -->
        <div class="card shadow-sm">
            <div class="card-body">

                <table id="shortAppsTable" class="table table-striped table-bordered">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Training</th>
                        <th>Financier</th>
                        <th>Participants</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($data as $app)
                        <tr>
                            <td>{{ $app->id }}</td>
                            <td>{{ optional($app->training->course)->course_name }}</td>
                            <td>{{ ucfirst($app->financier) }}</td>
                            <td>{{ $app->total_participants }}</td>
                            <td>KSh {{ number_format($app->metadata['total_amount'] ?? 0, 2) }}</td>
                            <td><span class="badge bg-{{ $app->payment_status == 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($app->payment_status) }}
                        </span></td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>
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
        new DataTable('#shortAppsTable', {
            responsive: true,
            pageLength: 25
        });
    </script>
@endpush

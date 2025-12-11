@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="mb-3">Short Course Training Summary</h4>

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <form method="GET" id="filterForm">

                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label">Course</label>
                            <select name="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}">{{ $c->course_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">Apply Filters</button>

                        <a class="btn btn-success"
                           target="_blank"
                           href="{{ route('reports.short.training.summary.pdf') }}?{{ request()->getQueryString() }}">
                            Download PDF
                        </a>
                    </div>

                </form>

            </div>
        </div>

        <!-- SUMMARY TABLE -->
        <div class="card shadow-sm">
            <div class="card-body">

                <table id="trainingSummaryTable" class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Course</th>
                        <th>Schedule</th>
                        <th>Total Applications</th>
                        <th>Total Participants</th>
                        <th>Self</th>
                        <th>Employer</th>
                        <th>Expected Revenue</th>
                        <th>Paid</th>
                        <th>Pending</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($summary as $row)
                        <tr>
                            <td>{{ $row['course_name'] }}</td>
                            <td>{{ $row['start_date'] }} → {{ $row['end_date'] }}</td>
                            <td>{{ $row['total_applications'] }}</td>
                            <td>{{ $row['total_participants'] }}</td>
                            <td>{{ $row['self_sponsored'] }}</td>
                            <td>{{ $row['employer_sponsored'] }}</td>
                            <td>KSh {{ number_format($row['expected_revenue'], 2) }}</td>
                            <td class="text-success fw-bold">KSh {{ number_format($row['paid_revenue'], 2) }}</td>
                            <td class="text-danger fw-bold">KSh {{ number_format($row['pending_revenue'], 2) }}</td>
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
        new DataTable('#trainingSummaryTable', {
            responsive: true,
            pageLength: 25,
            order: [[0, 'asc']]
        });
    </script>
@endpush

@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="mb-3">Short Course Revenue Report</h4>

        <!-- FILTERS -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET">

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

                    <div class="text-end mt-3">
                        <button class="btn btn-primary">Apply Filters</button>

                        <a class="btn btn-success"
                           target="_blank"
                           href="{{ route('reports.short.revenue.pdf') }}?{{ request()->getQueryString() }}">
                            Download PDF
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card shadow-sm">
            <div class="card-body">

                <table id="revenueTable"
                       class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">
                    <tr>
                        <th>Course</th>
                        <th>Schedule</th>
                        <th>Participants</th>
                        <th>Expected</th>
                        <th>Paid</th>
                        <th>Pending</th>
                        <th>Paid %</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($summary as $row)
                        <tr>
                            <td>{{ $row['course'] }}</td>
                            <td>{{ $row['start_date'] }} → {{ $row['end_date'] }}</td>
                            <td class="text-center">{{ $row['participants'] }}</td>
                            <td>KSh {{ number_format($row['expected'], 2) }}</td>
                            <td class="text-success fw-bold">KSh {{ number_format($row['paid'], 2) }}</td>
                            <td class="text-danger fw-bold">KSh {{ number_format($row['pending'], 2) }}</td>
                            <td>{{ $row['payment_rate'] }}%</td>
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
        new DataTable('#revenueTable', {
            pageLength: 25,
            responsive: true,
            order: [[0, 'asc']]
        });
    </script>
@endpush

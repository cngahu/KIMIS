@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <h4 class="mb-3">Short Course – Participants Master Report</h4>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="filterForm" method="GET">

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

                        <div class="col-md-4">
                            <label class="form-label">Training Schedule</label>
                            <select name="training_id" class="form-select">
                                <option value="">All Schedules</option>
                                @foreach($trainings as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->course->course_name }} —
                                        ({{ $t->start_date }} to {{ $t->end_date }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">Apply Filters</button>

                        <a class="btn btn-success" target="_blank"
                           href="{{ route('reports.short.participants.pdf') }}?{{ request()->getQueryString() }}">
                            Download PDF
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <table id="participantsTable" class="table table-striped table-bordered">
                    <thead class="table-dark">
                    <tr>
                        <th>Participant</th>
                        <th>ID No</th>
                        <th>Phone</th>
                        <th>Training</th>
                        <th>Course</th>
                        <th>Financier</th>
                        <th>Employer</th>
                        <th>Payment</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($participants as $p)
                        <tr>
                            <td>{{ $p->full_name }}</td>
                            <td>{{ $p->id_no }}</td>
                            <td>{{ $p->phone }}</td>

                            <td>{{ $p->application->training->start_date }}
                                → {{ $p->application->training->end_date }}</td>

                            <td>{{ $p->application->training->course->course_name }}</td>

                            <td>{{ ucfirst($p->application->financier) }}</td>

                            <td>{{ $p->application->employer_name ?? '-' }}</td>

                            <td>
                                @if(optional($p->application->invoice)->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
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
        new DataTable('#participantsTable', {
            responsive: true,
            pageLength: 25,
        });
    </script>
@endpush

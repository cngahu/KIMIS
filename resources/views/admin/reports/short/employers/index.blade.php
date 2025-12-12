@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="mb-3">Short Courses — Employer Sponsorship Summary</h4>

        @include('admin.reports.short.participants.filters')

        <div class="card shadow-sm mt-3">
            <div class="card-body">

                <table id="employerTable" class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Employer</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Total Applications</th>
                        <th>Total Participants</th>
                        <th>Expected Revenue</th>
                        <th>Paid</th>
                        <th>Pending</th>
                        <th>Statement</th>

                    </tr>
                    </thead>

                    <tbody>
                    @foreach($employers as $employer)
                        <tr>
                            <td>
                                <strong>{{ $employer['employer_name'] }}</strong><br>
                                <small>{{ count($employer['trainings']) }} training(s)</small>
                            </td>

                            <td>{{ $employer['contact_person'] }}</td>
                            <td>{{ $employer['phone'] }}</td>

                            <td>{{ $employer['applications'] }}</td>
                            <td>{{ $employer['participants'] }}</td>

                            <td>KSh {{ number_format($employer['expected_revenue'], 2) }}</td>
                            <td class="text-success fw-bold">KSh {{ number_format($employer['paid_revenue'], 2) }}</td>
                            <td class="text-danger fw-bold">KSh {{ number_format($employer['pending_revenue'], 2) }}</td>
                            <td>
                                <a href="{{ route('reports.short.employer.statement', urlencode($employer['employer_name'])) }}"
                                   class="btn btn-sm btn-info"
                                   target="_blank">
                                    View Statement
                                </a>
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
        new DataTable('#employerTable', {
            responsive: true,
            pageLength: 25,
            order: [[0, 'asc']]
        });
    </script>
@endpush

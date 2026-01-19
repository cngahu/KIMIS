@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <img src="https://kihbt.ac.ke/sites/default/files/coat_of_arms_kihbt_0.png"
                         height="80">

                    <div class="text-end">
                        <h5 class="mb-0">KIHBT OFFICIAL FEE STATEMENT</h5>
                        <small>Date: {{ $statement_date->format('d M Y') }}</small>
                    </div>
                </div>

                <hr>

                <h6>Learner Information</h6>
                <table class="table table-sm table-bordered w-50">
                    <tr>
                        <th>Admission No</th>
                        <td>{{ $student->student_number ?? $master->admissionNo }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $student->user->surname ?? $master->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>{{ $master->course_name ?? '-' }}</td>
                    </tr>
                </table>

                <hr>

                <h6>Fee Statement</h6>

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
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
                            <td class="text-end">{{ number_format($row->running_balance,2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="alert {{ $balance <= 0 ? 'alert-success' : 'alert-warning' }}">
                    <strong>Closing Balance:</strong> {{ number_format($balance, 2) }}
                </div>

                <a href="{{ route('finance.fee-statement.download', request()->query()) }}"
                   class="btn btn-primary">
                    Download PDF
                </a>

            </div>
        </div>

    </div>
@endsection

@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <h4 class="fw-bold mb-3">Verified Students – Ready for Admission</h4>

        <div class="card p-3">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Verification Issues</th>
                    <th>Fee Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($students as $index => $adm)
                    @php
                        $application = $adm->application;
                        $invoice = $application?->invoice;
                        $hasPaid = $invoice && $invoice->status === 'paid';

                        // Verification issues stored as JSON or string
                        $issues = $adm->verification_issues
                            ? (is_array($adm->verification_issues)
                                ? $adm->verification_issues
                                : json_decode($adm->verification_issues, true))
                            : [];
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @php $st = $adm->student; @endphp

                            @if($st)
                                <strong>{{ $st->surname }} {{ $st->firstname }}</strong><br>
                                <small class="text-muted">{{ $st->email }}</small>
                            @else
                                <strong class="text-danger">No User Account</strong><br>
                                <small class="text-muted">Student account missing</small>
                            @endif
                        </td>


                        <td>
                            {{ $application?->course?->course_name ?? 'N/A' }}
                        </td>

                        <td>
                            {{--                            @if(!empty($adm->verification_issues))--}}
                            {{--                                <ul class="mb-0">--}}
                            {{--                                    @foreach($adm->verification_issues as $issue)--}}
                            {{--                                        <li>{{ $issue }}</li>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </ul>--}}
                            {{--                            @else--}}
                            {{--                                <span class="text-success">None</span>--}}
                            {{--                            @endif--}}

                        </td>

                        <td>
                            @if($hasPaid)
                                <span class="badge bg-success">Fee Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($hasPaid)
                                <a href="{{ route('admin.admissions.admit', $adm->id) }}"
                                   class="btn btn-success btn-sm">
                                    Admit Student
                                </a>
                            @else
                                <span class="badge bg-danger">Awaiting Accounts Clearance</span>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            No verified students yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

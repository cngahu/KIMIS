@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-3">Verified Students Pending Admission</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card p-3">

            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Fee Status</th>
                    <th>Issues</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                @forelse($students as $s)

                    @php
//                        $courseFee  = optional($s->application->course)->cost ?? 0;
                        $courseFee = $s->required_fee ?? 0;

                        $paidTotal  = $s->feePayments->where('status','paid')->sum('amount');
                        $fullyPaid  = bccomp($paidTotal, $courseFee, 2) >= 0;
                    @endphp

                    <tr>

                        {{-- Student --}}
                        <td>
                            <strong>{{ $s->user->surname }} {{ $s->user->firstname }}</strong><br>
                            <small>{{ $s->user->email }}</small>
                        </td>

                        {{-- Course --}}
                        <td>
                            {{ optional($s->application->course)->course_name }}
                        </td>

                        {{-- Doc Status --}}
                        <td>
                        <span class="badge bg-info text-dark">
                            {{ strtoupper($s->status) }}
                        </span>
                        </td>

                        {{-- Fee Status --}}
                        <td>
                            @if($fullyPaid)
                                <span class="badge bg-success">Fee Fully Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">
                                Paid: KES {{ number_format($paidTotal, 2) }} /
                                Required: {{ number_format($courseFee, 2) }}
                            </span>
                            @endif
                        </td>

                        {{-- Verification Issues --}}
                        <td>
                            @if($s->verification_issues && is_array($s->verification_issues) && count($s->verification_issues) > 0)

                                <button class="btn btn-sm btn-outline-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#issuesModal{{ $s->id }}">
                                    View Issues
                                </button>

                                {{-- Modal --}}
                                <div class="modal fade" id="issuesModal{{ $s->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header bg-secondary text-white">
                                                <h5 class="modal-title">Verification Issues</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                @foreach($s->verification_issues as $issue)
                                                    <p>
                                                        <strong>{{ $issue['name'] }}</strong><br>
                                                        {{ $issue['comment'] ?? 'Missing document' }}
                                                    </p>
                                                    <hr>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td>
                            @if($fullyPaid)
                                <form action="{{ route('admin.admissions.admit', $s->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Admit Student</button>
                                </form>
                            @else
                                <span class="badge bg-warning text-dark">
                                Awaiting Finance Clearance
                            </span>
                            @endif
                        </td>

                    </tr>
                @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            No verified students found.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

        </div>

    </div>

@endsection

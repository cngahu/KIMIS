@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Class List</h4>
                <p class="text-muted mb-0">
                    {{ $course->course_name }} ({{ $course->course_code }})<br>
                    Intake: {{ $cohort->intake_year }} / {{ $cohort->intake_month }}
                </p>
            </div>

            <a href="{{ route('admin.class-lists.participants.print', [
                'course' => $course->id,
                'cohort' => $cohort->id
            ]) }}"
               class="btn btn-primary">
                Download PDF
            </a>
        </div>

        {{-- Table --}}
        <div class="card radius-10">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Admission No</th>
                            <th>Participant Name</th>
                            <th>Gender</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($participants as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->admissionNo }}</td>
                                <td>
                                    {{ trim(($p->firstName ?? '') . ' ' . ($p->lastName ?? '')) }}
                                </td>
                                <td>{{ $p->gender ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No participants found for this cohort.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

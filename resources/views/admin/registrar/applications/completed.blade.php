@extends('admin.registrar.applications.layout')

@section('registrar-content')

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Completed Applications (Approved or Rejected)</h5>

            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Applicant</th>
                    <th>Applied Course</th>
                    <th>Admitted Course</th>
                    <th>Status</th>
                    <th>Reviewed By</th>
                    <th>Decision Date</th>
                    <th>View</th>
                </tr>
                </thead>

                <tbody>
                @forelse($apps as $app)
                    @php
                        $meta = $app->metadata ?? [];

                        // IDs from metadata (fallback to current course_id where needed)
                        $appliedCourseId  = $meta['applied_course_id']  ?? $app->course_id;
                        $admittedCourseId = $meta['admitted_course_id'] ?? $app->course_id;

                        $appliedCourse  = \App\Models\Course::find($appliedCourseId);
                        $admittedCourse = \App\Models\Course::find($admittedCourseId);

                        $appliedCourseName  = $appliedCourse
                            ? ($appliedCourse->course_name ?? $appliedCourse->name)
                            : 'N/A';

                        $admittedCourseName = $admittedCourse
                            ? ($admittedCourse->course_name ?? $admittedCourse->name)
                            : $appliedCourseName;

                        $isAlternative = (int)$admittedCourseId !== (int)$appliedCourseId;

                        // For nice text: which option is admitted?
                        $alt1Id = $meta['alt_course_1_id'] ?? null;
                        $alt2Id = $meta['alt_course_2_id'] ?? null;

                        if (!$isAlternative) {
                            $admittedOptionLabel = 'Primary option';
                        } elseif ($alt1Id && (int)$admittedCourseId === (int)$alt1Id) {
                            $admittedOptionLabel = 'Option 1';
                        } elseif ($alt2Id && (int)$admittedCourseId === (int)$alt2Id) {
                            $admittedOptionLabel = 'Option 2';
                        } else {
                            $admittedOptionLabel = 'Alternative option';
                        }
                    @endphp

                    <tr>
                        {{-- Reference --}}
                        <td>{{ $app->reference }}</td>

                        {{-- Applicant --}}
                        <td>{{ $app->full_name }}</td>

                        {{-- Applied course --}}
                        <td>
                            {{ $appliedCourseName }}
                        </td>

                        {{-- Admitted course (may be same or different) --}}
                        <td>
                            <strong>{{ $admittedCourseName }}</strong>

                            @if($isAlternative)
                                <br>
                                <small class="text-muted">
                                    Student applied for
                                    <strong>{{ $appliedCourseName }}</strong>,
                                    but based on the entry requirements was
                                    <strong>recommended and admitted</strong>
                                    to this course ({{ $admittedOptionLabel }}).
                                </small>
                            @else
                                <br>
                                <small class="text-muted">
                                    Student admitted to the same course they applied for
                                    ({{ $admittedOptionLabel }}).
                                </small>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge bg-{{ $app->status === 'approved' ? 'success' : 'danger' }}">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>

                        {{-- Reviewer (safe if null) --}}
                        <td>
                            @if($app->reviewer)
                                {{ $app->reviewer->surname }} {{ $app->reviewer->firstname }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        {{-- Decision date --}}
                        <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>

                        {{-- View button (modal) --}}
                        <td>
                            <button class="btn btn-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewApplicationModal"
                                    onclick="loadApplication({{ $app->id }})">
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No completed applications found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $apps->links() }}

        </div>
    </div>

    @include('admin.registrar.applications.modal')

@endsection

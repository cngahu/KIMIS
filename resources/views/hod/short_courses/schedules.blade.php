@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .schedule-card {
            border-left: 4px solid #3b2818;
            transition: all .2s ease-in-out;
        }
        .schedule-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,.08);
        }
        .metric {
            font-weight: 700;
            font-size: 1.1rem;
        }
        .metric-label {
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
        }
    </style>

    <div class="page-content">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h4 class="fw-bold mb-1">
                    {{ $course->course_name }} – Schedules
                </h4>
                <p class="mb-0 text-muted">
                    Manage class schedules, participants, and revenue for this short course.
                </p>
            </div>
        </div>

        {{-- QUICK STATS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">{{ $trainings->count() }}</div>
                        <div class="metric-label">Total Schedules</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">
                            {{ $trainings->sum('applications_count') }}
                        </div>
                        <div class="metric-label">Applications</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">
                            {{ $trainings->sum('participants_count') }}
                        </div>
                        <div class="metric-label">Participants</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SCHEDULES TABLE --}}
        <div class="card radius-10">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Schedule</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-center">Applications</th>
                        <th class="text-center">Participants</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($trainings as $training)

                        @php
                            $statusBadge = match ($training->status) {
                                'draft' => 'bg-secondary',
                                'pending_registrar' => 'bg-warning text-dark',
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                default => 'bg-light text-dark',
                            };
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- Schedule --}}
                            <td>
                                <div class="fw-semibold">
                                    {{ $training->series_code ?? 'Schedule #' . $training->id }}
                                </div>
                                <small class="text-muted">
                                    {{ optional($training->start_date)?->format('d M Y') }}
                                    –
                                    {{ optional($training->end_date)?->format('d M Y') }}
                                </small>
                            </td>

                            {{-- Duration --}}
                            <td>
                                @if($training->start_date && $training->end_date)
                                    {{ \Carbon\Carbon::parse($training->start_date)
                                        ->diffInDays(\Carbon\Carbon::parse($training->end_date)) + 1 }}
                                    days
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                            <span class="badge {{ $statusBadge }}">
                                {{ strtoupper(str_replace('_',' ', $training->status)) }}
                            </span>
                            </td>

                            {{-- Applications --}}
                            <td class="text-center fw-semibold">
                                {{ $training->applications_count }}
                            </td>

                            {{-- Participants --}}
                            <td class="text-center fw-semibold">
                                {{ $training->participants_count }}
                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-center">

                                {{-- Applications --}}
                                <a href="{{ route('hod.short_courses.applications', $training) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="View applications">
                                    <i class="bx bx-file"></i>
                                </a>

                                {{-- Participants --}}
                                <a href="{{ route('hod.short_courses.participants', $training) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="View class list">
                                    <i class="bx bx-group"></i>
                                </a>

                                {{-- Revenue --}}
                                <a href="{{ route('hod.short_courses.revenue', $training) }}"
                                   class="btn btn-sm btn-outline-success"
                                   title="View revenue">
                                    <i class="bx bx-money"></i>
                                </a>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                No schedules created for this course yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection

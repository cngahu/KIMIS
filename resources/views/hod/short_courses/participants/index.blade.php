@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .metric {
            font-weight: 700;
            font-size: 1.2rem;
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
        <div class="mb-3">
            <h4 class="fw-bold mb-1">
                Class List – {{ $training->course->course_name }}
            </h4>
            <p class="text-muted mb-0">
                Schedule:
                <strong>
                    {{ optional($training->start_date)?->format('d M Y') }}
                    –
                    {{ optional($training->end_date)?->format('d M Y') }}
                </strong>
            </p>
        </div>

        {{-- SUMMARY STRIP --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">{{ $participants->count() }}</div>
                        <div class="metric-label">Total Participants</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">
                            {{ $participants->filter(fn($p) => $p->application?->financier === 'self')->count() }}
                        </div>
                        <div class="metric-label">Self Sponsored</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="metric">
                            {{ $participants->filter(fn($p) => $p->application?->financier === 'employer')->count() }}
                        </div>
                        <div class="metric-label">Employer Sponsored</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PARTICIPANTS TABLE --}}
        <div class="card radius-10">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Participant</th>
                        <th>ID Number</th>
                        <th>Contact</th>
                        <th>Financier</th>
                        <th>Employer</th>
                    </tr>
                    </thead>


                    <tbody>
                    @forelse($participants as $participant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- Participant Name --}}
                            <td class="fw-semibold">
                                {{ $participant->full_name }}
                            </td>

                            {{-- ID Number --}}
                            <td>
                                {{ $participant->id_no ?? '—' }}
                            </td>

                            {{-- Contact --}}
                            <td>
                                @if($participant->phone)
                                    <div>{{ $participant->phone }}</div>
                                @endif
                                @if($participant->email)
                                    <small class="text-muted">{{ $participant->email }}</small>
                                @endif
                                @if(!$participant->phone && !$participant->email)
                                    —
                                @endif
                            </td>

                            {{-- Financier --}}
                            <td>
                                @php
                                    $financier = $participant->application?->financier;
                                @endphp

                                @if($financier === 'self')
                                    <span class="badge bg-primary">Self</span>
                                @elseif($financier === 'employer')
                                    <span class="badge bg-success">Employer</span>
                                @else
                                    <span class="badge bg-secondary">—</span>
                                @endif
                            </td>

                            {{-- Employer --}}
                            <td>
                                {{ $participant->application?->employer_name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No participants registered for this schedule yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection

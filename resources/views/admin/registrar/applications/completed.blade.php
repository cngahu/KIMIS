@extends('admin.registrar.applications.layout')

@section('registrar-content')

    <div class="page-content">

        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Title + Search Bar --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h5 class="mb-0">My Completed Applications (Approved / Rejected)</h5>

                    {{-- Search form --}}
                    <form method="GET" class="d-flex gap-2">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control form-control-sm"
                               placeholder="Search ref, name, course...">

                        <button class="btn btn-sm btn-primary" type="submit">
                            Search
                        </button>

                        @if(request('search'))
                            <a href="{{ route('officer.applications.completed') }}"
                               class="btn btn-sm btn-outline-secondary">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Search hint --}}
                @if(request('search'))
                    <p class="small text-muted mb-2">
                        Showing results for: <strong>"{{ request('search') }}"</strong>
                    </p>
                @endif

                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Applicant</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Decision Date</th>
                        <th>View</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($apps as $app)
                        <tr>
                            <td>{{ $app->reference }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->course->course_name ?? $app->course->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $app->status === 'approved' ? 'success' : 'danger' }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>

                            {{-- View details in modal (same modal as registrar) --}}
                            <td>
                                <button class="btn btn-sm btn-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewApplicationModal"
                                        onclick="loadApplication({{ $app->id }})">
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No completed applications found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {{-- Totals + pagination --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted">
                        @php
                            $first         = $apps->firstItem() ?? 0;
                            $last          = $apps->lastItem() ?? 0;
                            $pageCount     = $apps->count();
                            $filteredTotal = $apps->total();
                        @endphp

                        Showing
                        <strong>{{ $first }}</strong> to
                        <strong>{{ $last }}</strong>
                        of
                        <strong>{{ $filteredTotal }}</strong>
                        matching records.

                        &nbsp;This page:
                        <strong>{{ $pageCount }}</strong>.

                        @isset($totalAll)
                            <br>
                            <span>
                                Total completed applications you reviewed:
                                <strong>{{ $totalAll }}</strong>.
                            </span>
                        @endisset
                    </div>

                    <div class="pagination-container">
                        {{ $apps->onEachSide(1)->links() }}
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Reuse the same modal + JS used by registrar --}}
    @include('admin.registrar.applications.modal')

@endsection

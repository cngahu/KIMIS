@extends('admin.registrar.applications.layout')

@section('registrar-content')

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Title + Search Bar --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Applications Awaiting Assignment</h5>

                <form method="GET" class="d-flex gap-2">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control form-control-sm"
                           placeholder="Search reference, applicant, course...">

                    <button class="btn btn-sm btn-primary" type="submit">Search</button>

                    @if(request('search'))
                        <a href="{{ route('registrar.awaiting') }}"
                           class="btn btn-sm btn-outline-secondary">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Search Result Indicator --}}
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
                    <th>Submitted</th>
                    <th>View</th>
                    <th>Assign</th>
                </tr>
                </thead>

                <tbody>
                @forelse($apps as $app)
                    <tr>
                        <td>{{ $app->reference }}</td>
                        <td>{{ $app->full_name }}</td>
                        <td>{{ $app->course->course_name }}</td>
                        <td>{{ $app->created_at->format('d M Y') }}</td>

                        <td>
                            <button class="btn btn-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewApplicationModal"
                                    onclick="loadApplication({{ $app->id }})">
                                View
                            </button>
                        </td>

                        <td>
                            <form action="{{ route('registrar.assign', $app->id) }}" method="POST">
                                @csrf
                                <div class="d-flex">
                                    <select name="reviewer_id" class="form-select form-select-sm" required>
                                        <option value="">Select Officer</option>
                                        @foreach($officers as $off)
                                            <option value="{{ $off->id }}">
                                                {{ $off->surname }} {{ $off->firstname }} {{ $off->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary btn-sm ms-2">Assign</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No applications awaiting assignment.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- Pagination + Results Count --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap mt-2">
                <div class="small text-muted">
                    @php
                        $first = $apps->firstItem() ?? 0;
                        $last = $apps->lastItem() ?? 0;
                        $total = $apps->total();
                        $pageCount = $apps->count();
                    @endphp

                    Showing <strong>{{ $first }}</strong> to <strong>{{ $last }}</strong>
                    of <strong>{{ $total }}</strong> records
                    — This page: <strong>{{ $pageCount }}</strong>
                </div>

                <div>
                    {{ $apps->onEachSide(1)->links() }}
                </div>
            </div>

        </div>
    </div>

    @include('admin.registrar.applications.modal')

@endsection

@extends('admin.admin_dashboard')

@section('admin')
    <style>
        .icon-brown {
            color: #6B3A0E !important;
        }
    </style>

    <div class="container">

        {{-- Header + filters + create button --}}
        {{-- Header Row --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="mb-0">Trainings</h1>

            <a href="{{ route('trainings.create') }}" class="btn btn-primary btn-sm">
                Add Training
            </a>
        </div>

        {{-- Filters & search --}}
        <form action="{{ route('all.trainings') }}" method="GET" class="w-100 mb-3">
            <div class="row g-2">

                {{-- Search --}}
                <div class="col-md-3">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-sm"
                        placeholder="Search by course or code..."
                        value="{{ request('search') }}"
                    >
                </div>

                {{-- Course Filter --}}
                <div class="col-md-2">
                    <select name="course_id" class="form-select form-select-sm">
                        <option value="">All Courses</option>
                        @foreach($courses as $courseItem)
                            <option value="{{ $courseItem->id }}"
                                {{ (int) request('course_id') === $courseItem->id ? 'selected' : '' }}>
                                {{ $courseItem->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- College Filter --}}
                <div class="col-md-2">
                    <select name="college_id" class="form-select form-select-sm">
                        <option value="">All Colleges</option>
                        @foreach($colleges as $collegeItem)
                            <option value="{{ $collegeItem->id }}"
                                {{ (int) request('college_id') === $collegeItem->id ? 'selected' : '' }}>
                                {{ $collegeItem->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $optStatus)
                            <option value="{{ $optStatus }}" {{ request('status') === $optStatus ? 'selected' : '' }}>
                                {{ $optStatus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-md-3 d-flex gap-2">

                    <button class="btn btn-sm text-white px-3 flex-fill"
                            style="background-color: #6B3A0E;"
                            type="submit">
                        Filter
                    </button>

                    @if(request('search') || request('status') || request('course_id') || request('college_id'))
                        <a href="{{ route('all.trainings') }}"
                           class="btn btn-sm btn-outline-secondary px-3 flex-fill">
                            Reset
                        </a>
                    @endif

                </div>

            </div>
        </form>



        {{-- Flash success --}}
        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        @if($trainings->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 60px" class="text-center">#</th>
                        <th>Course</th>
                        <th>College</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
{{--                        <th class="text-end">Cost (KSh)</th>--}}
                        <th style="width: 190px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($trainings as $training)
                        <tr>
                            {{-- Serial number --}}
                            <td class="text-center">
                                {{ $trainings->firstItem() + $loop->index }}
                            </td>

                            {{-- Course & college --}}
                            <td>{{ optional($training->course)->course_name ?? '-' }}</td>
                            <td>{{ optional($training->college)->name ?? '-' }}</td>

                            {{-- Start date --}}
                            <td>
                                @if($training->start_date)
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- End date --}}
                            <td>
                                @if($training->end_date)
                                    {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Status with badge --}}
                            <td>
                                @if($training->status)
                                    @php
                                        $statusClass = match($training->status) {
                                            'Active'    => 'badge bg-success',
                                            'Pending'   => 'badge bg-warning text-dark',
                                            'Completed' => 'badge bg-primary',
                                            'Cancelled' => 'badge bg-danger',
                                            default     => 'badge bg-secondary',
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ $training->status }}</span>
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Cost --}}


                            {{-- Actions --}}
                            <td class="text-center">
                                {{-- View always allowed --}}
                                <a href="{{ route('trainings.show', $training) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="View Training">
                                    <i class="fa-solid fa-eye icon-brown"></i>
                                </a>

                                @php
                                    $isHod    = auth()->user()->hasRole('hod');
                                    $isDraft  = $training->status === \App\Models\Training::STATUS_DRAFT;
                                @endphp

                                {{-- Edit: allowed for:
                                     - HOD only if Draft
                                     - Superadmin (if you want) --}}
                                @if($isHod && $isDraft || auth()->user()->hasRole('superadmin'))
                                    <a href="{{ route('trainings.edit', $training) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit Training">
                                        <i class="fa-solid fa-pen-to-square icon-brown"></i>
                                    </a>
                                @else
                                    {{-- disabled edit button --}}
                                    <button class="btn btn-sm btn-outline-secondary" type="button" disabled
                                            title="Cannot edit once submitted for approval">
                                        <i class="fa-solid fa-lock"></i>
                                    </button>
                                @endif

                                {{-- HOD: Send for approval button, only when Draft --}}
                                @if($isHod && $isDraft)
                                    <form action="{{ route('trainings.submit', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Send to Registrar for approval">
                                            <i class="fa-solid fa-paper-plane"></i> Submit
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete maybe only when Draft; adjust as you like --}}
                                @if($isDraft || auth()->user()->hasRole('superadmin'))
                                    <form action="{{ route('trainings.delete', $training) }}"
                                          method="POST"
                                          class="d-inline js-confirm-form"
                                          data-confirm-title="Delete this training?"
                                          data-confirm-text="This will permanently delete this training record."
                                          data-confirm-icon="warning"
                                          data-confirm-button="Yes, delete it"
                                          data-cancel-button="No, keep it">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete Training">
                                            <i class="fa-solid fa-trash icon-brown"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination summary + links --}}
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="text-muted small">
                    Showing
                    <strong>{{ $trainings->firstItem() }}</strong>
                    to
                    <strong>{{ $trainings->lastItem() }}</strong>
                    of
                    <strong>{{ $trainings->total() }}</strong>
                    trainings
                    @if(request('search'))
                        for "<strong>{{ request('search') }}</strong>"
                    @endif
                </div>
                <div>
                    {{ $trainings->links() }}
                </div>
            </div>
        @else
            <div class="alert alert-info">
                @if(request('search') || request('status') || request('course_id') || request('college_id'))
                    No trainings found for the current filters.
                    <a href="{{ route('all.trainings') }}">Clear filters</a>
                @else
                    No trainings found.
                @endif
            </div>
        @endif
    </div>
@endsection

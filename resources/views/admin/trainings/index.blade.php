@extends('admin.admin_dashboard')

@section('admin')
    <style>
        .icon-brown {
            color: #6B3A0E !important;
        }
    </style>

    @php
        $authUser    = auth()->user();
        $isHod       = $authUser->hasRole('hod');
        $isSuper     = $authUser->hasRole('superadmin');
        $isRegistrar = $authUser->hasAnyRole(['campus_registrar', 'kihbt_registrar']);
    @endphp

    <div class="container">

        {{-- Header + create button --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h1 class="mb-0">Trainings</h1>

            {{-- 👇 Only HOD can add trainings --}}
            @if($isHod)
                <a href="{{ route('trainings.create') }}" class="btn btn-primary btn-sm">
                    Add Training
                </a>
            @endif
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
                <div class="col-md-3">
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

                {{-- Campus Filter (SUPERADMIN ONLY) --}}
                @if($isSuper)
                    <div class="col-md-3">
                        <select name="college_id" class="form-select form-select-sm">
                            <option value="">All Campuses</option>
                            @foreach($colleges as $collegeItem)
                                <option value="{{ $collegeItem->id }}"
                                    {{ (int) request('college_id') === $collegeItem->id ? 'selected' : '' }}>
                                    {{ $collegeItem->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

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

                {{-- Filter button --}}
                <div class="col-md-1 d-flex gap-2">
                    <button class="btn btn-sm text-white px-3 flex-fill"
                            style="background-color: #6B3A0E;"
                            type="submit">
                        Filter
                    </button>
                </div>
            </div>

            {{-- Reset link (only shows if any filter is active) --}}
            @if(
                request('search') ||
                request('status') ||
                request('course_id') ||
                ($isSuper && request('college_id'))
            )
                <div class="mt-2">
                    <a href="{{ route('all.trainings') }}"
                       class="btn btn-sm btn-outline-secondary px-3">
                        Reset
                    </a>
                </div>
            @endif
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
                        <th class="text-end">Cost (KSh)</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
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

                            {{-- Cost --}}
                            <td class="text-end">
                                {{ $training->formatted_cost }}
                            </td>

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
                                @php
                                    $status = $training->status;

                                    $badgeClass = match ($status) {
                                        \App\Models\Training::STATUS_DRAFT                 => 'badge bg-secondary',
                                        \App\Models\Training::STATUS_PENDING_REGISTRAR     => 'badge bg-warning text-dark',
                                        \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ => 'badge bg-info text-dark',
                                        \App\Models\Training::STATUS_HQ_REVIEWED           => 'badge bg-primary',
                                        \App\Models\Training::STATUS_APPROVED              => 'badge bg-success',
                                        \App\Models\Training::STATUS_REJECTED              => 'badge bg-danger',
                                        default                                            => 'badge bg-secondary',
                                    };
                                @endphp

                                <span class="{{ $badgeClass }}">
                                    {{ $status }}
                                </span>

                                {{-- Rejection tooltip --}}
                                @if($training->status === \App\Models\Training::STATUS_REJECTED && $training->rejection_comment)
                                    <span
                                        class="ms-1 text-warning"
                                        style="cursor: pointer;"
                                        data-bs-toggle="tooltip"
                                        data-bs-html="true"
                                        title="
                                            <strong>Returned with comments</strong><br>
                                            Stage: {{ ucfirst(str_replace('_',' ', $training->rejection_stage)) }}<br>
                                            {{ $training->rejection_comment }}<br>
                                            @if($training->rejected_at)
                                                <small class='text-muted'>On {{ $training->rejected_at->format('d M Y H:i') }}</small>
                                            @endif
                                        "
                                    >
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                @php
                                    $user       = Auth::user();
                                    $isHod      = $user->hasRole('hod');
                                    $isCampus   = $user->hasRole('campus_registrar');
                                    $isKihbt    = $user->hasRole('kihbt_registrar');
                                    $isDirector = $user->hasRole('director');
                                    $isSuper    = $user->hasRole('superadmin');
                                @endphp

                                {{-- View: everyone who can see the list can view --}}
                                <a href="{{ route('trainings.show', $training) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="View Training">
                                    <i class="fa-solid fa-eye icon-brown"></i>
                                </a>

                                {{-- ✅ ONLY HOD can Edit/Delete Draft or Rejected (no more superadmin) --}}
                                @if($isHod && $training->isEditableByHod())
                                    <a href="{{ route('trainings.edit', $training) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit Training">
                                        <i class="fa-solid fa-pen-to-square icon-brown"></i>
                                    </a>

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

                                {{-- ✅ ONLY HOD can Send for approval --}}
                                @if($isHod && $training->isEditableByHod())
                                    <form action="{{ route('trainings.send_for_approval', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Send to Registrar for Approval">
                                            <i class="fa-solid fa-paper-plane icon-brown"></i> Submit
                                        </button>
                                    </form>
                                @endif

                                {{-- Campus Registrar: Approve/Reject when Pending Registrar (still allowed) --}}
                                @if(($isCampus || $isSuper) && $training->status === \App\Models\Training::STATUS_PENDING_REGISTRAR)
                                    <form action="{{ route('trainings.registrar_approve', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-success"
                                                title="Approve and send to HQ">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('trainings.registrar_reject', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Reject training">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- KIHBT Registrar (HQ): HQ Review --}}
                                @if(($isKihbt || $isSuper) && $training->status === \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ)
                                    <form action="{{ route('trainings.hq_review', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-primary"
                                                title="Mark as HQ Reviewed">
                                            <i class="fa-solid fa-search"></i> HQ Review
                                        </button>
                                    </form>
                                @endif

                                {{-- Director: Final Approve/Reject --}}
                                @if(($isDirector || $isSuper) && $training->status === \App\Models\Training::STATUS_HQ_REVIEWED)
                                    <form action="{{ route('trainings.director_approve', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-success"
                                                title="Final Approve">
                                            <i class="fa-solid fa-check-double"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('trainings.director_reject', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Reject">
                                            <i class="fa-solid fa-times-circle"></i>
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
                @if(request('search') || request('status') || request('course_id') || ($isSuper && request('college_id')))
                    No trainings found for the current filters.
                    <a href="{{ route('all.trainings') }}">Clear filters</a>
                @else
                    No trainings found.
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });
        </script>
    @endpush

@endsection

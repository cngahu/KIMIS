@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">

        {{-- Page header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h1 class="h4 mb-1">Training Details</h1>
                <p class="text-muted mb-0">
                    View full details and approval status for this scheduled training.
                </p>
            </div>
            <div class="d-flex gap-2">

                {{-- Back button (always) --}}
                <a href="{{ route('all.trainings') }}" class="btn btn-light border">
                    Back to Trainings
                </a>

                @php
                    $user = Auth::user();
                    $isHod        = $user->hasRole('hod');
                    $isSuperAdmin = $user->hasRole('superadmin');
                    $isCampusReg  = $user->hasRole('campus_registrar');
                    $isHqReg      = $user->hasRole('kihbt_registrar');
                    $isDirector   = $user->hasRole('director');

                    // Fallback if helper doesn't exist
                    $hodCanEdit = method_exists($training, 'isEditableByHod')
                        ? $training->isEditableByHod()
                        : in_array($training->status, [
                            \App\Models\Training::STATUS_DRAFT,
                            \App\Models\Training::STATUS_REJECTED,
                        ]);
                @endphp

                {{-- HOD / Superadmin: Edit + Delete when allowed --}}
                @if(($isHod && $hodCanEdit) || $isSuperAdmin)
                    <a href="{{ route('trainings.edit', $training) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>

                    <form action="{{ route('trainings.delete', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this training?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                @endif

                {{-- HOD / Superadmin: Send for approval (Draft or Rejected) --}}
                @if(($isHod || $isSuperAdmin) && $hodCanEdit)
                    <form action="{{ route('trainings.send_for_approval', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Send this training to the Registrar for approval?');">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Send for Approval
                        </button>
                    </form>
                @endif

                {{-- Campus Registrar: Approve / Reject (Pending Registrar Approval) --}}
                @if(($isCampusReg || $isSuperAdmin)
                    && $training->status === \App\Models\Training::STATUS_PENDING_REGISTRAR)
                    <form action="{{ route('trainings.registrar_approve', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Approve this training and send to HQ for review?');">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Approve (to HQ)
                        </button>
                    </form>

                    <form action="{{ route('trainings.registrar_reject', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Reject this training and return to HOD?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-times me-1"></i> Reject
                        </button>
                    </form>
                @endif

                {{-- HQ Registrar: Mark HQ Reviewed --}}
                @if(($isHqReg || $isSuperAdmin)
                    && $training->status === \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ)
                    <form action="{{ route('trainings.hq_review', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Mark this training as HQ Reviewed?');">
                        @csrf
                        <button type="submit" class="btn btn-info text-white">
                            <i class="fas fa-search me-1"></i> Mark HQ Reviewed
                        </button>
                    </form>
                @endif

                {{-- Director: Final Approve / Reject (HQ Reviewed) --}}
                @if(($isDirector || $isSuperAdmin)
                    && $training->status === \App\Models\Training::STATUS_HQ_REVIEWED)
                    <form action="{{ route('trainings.director_approve', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Finally approve this training?');">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-double me-1"></i> Final Approve
                        </button>
                    </form>

                    <form action="{{ route('trainings.director_reject', $training) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Reject this training?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-ban me-1"></i> Reject
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Main card --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                {{-- Title + status --}}
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <h3 class="card-title mb-1">
                            {{ optional($training->course)->course_name ?? 'Unnamed Course' }}
                        </h3>
                        <div class="text-muted small">
                            Course Code:
                            <code>{{ optional($training->course)->course_code ?? 'N/A' }}</code>
                        </div>
                    </div>
                    <div class="text-end">
                        @php
                            $status = $training->status;

                            $badgeClass = 'bg-secondary';
                            if ($status === \App\Models\Training::STATUS_DRAFT) {
                                $badgeClass = 'bg-secondary';
                            } elseif ($status === \App\Models\Training::STATUS_PENDING_REGISTRAR) {
                                $badgeClass = 'bg-warning text-dark';
                            } elseif ($status === \App\Models\Training::STATUS_REGISTRAR_APPROVED_HQ) {
                                $badgeClass = 'bg-info text-dark';
                            } elseif ($status === \App\Models\Training::STATUS_HQ_REVIEWED) {
                                $badgeClass = 'bg-primary';
                            } elseif ($status === \App\Models\Training::STATUS_APPROVED) {
                                $badgeClass = 'bg-success';
                            } elseif ($status === \App\Models\Training::STATUS_REJECTED) {
                                $badgeClass = 'bg-danger';
                            }
                        @endphp

                        <span class="badge {{ $badgeClass }} px-3 py-2">
                            {{ $status ?? 'N/A' }}
                        </span>

                        <div class="small text-muted mt-1">
                            Training ID: #{{ $training->id }}
                        </div>
                    </div>
                </div>

                {{-- 🔶 Rejection info (when returned with comments) --}}
                @if($training->status === \App\Models\Training::STATUS_REJECTED && $training->rejection_comment)
                    <div class="alert alert-warning mt-2">
                        <strong>
                            Returned with comments
                            @if($training->rejection_stage)
                                ({{ ucfirst(str_replace('_', ' ', $training->rejection_stage)) }})
                            @endif
                            :
                        </strong>
                        <br>
                        {{ $training->rejection_comment }}
                        <br>
                        @if($training->rejected_at)
                            <small class="text-muted">
                                On {{ $training->rejected_at->format('d M Y H:i') }}
                            </small>
                        @endif
                    </div>
                @endif

                <hr>

                {{-- Details --}}
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Course:</strong><br>
                            {{ optional($training->course)->course_name ?? '-' }}
                        </p>

                        <p class="mb-1">
                            <strong>College / Campus:</strong><br>
                            {{ optional($training->college)->name ?? '-' }}
                        </p>


                        <p class="mb-1">
                            <strong>Cost:</strong><br>
                            {{ $training->formatted_cost }}
                        </p>
{{--                        <p class="mb-1">--}}
{{--                            <strong>Cost:</strong><br>--}}
{{--                            KSh {{ number_format($training->cost, 2) }}--}}
{{--                        </p>--}}
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Start Date:</strong><br>
                            @if($training->start_date)
                                {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </p>

                        <p class="mb-1">
                            <strong>End Date:</strong><br>
                            @if($training->end_date)
                                {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </p>

                        <p class="mb-1">
                            <strong>Created By:</strong><br>
                            {{ optional($training->user)->name ?? '-' }}
                        </p>
                    </div>
                </div>

                <hr>

                {{-- Meta --}}
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Created At:</strong><br>
                            @if($training->created_at)
                                {{ $training->created_at->format('d M Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Last Updated:</strong><br>
                            @if($training->updated_at)
                                {{ $training->updated_at->format('d M Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

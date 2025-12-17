@extends('admin.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <h5 class="mb-3">
            Fee Structure –
            <span class="text-primary">{{ $course->course_name }}</span>
        </h5>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th width="20%">Stage</th>
                    <th width="15%">Billable</th>
                    <th width="15%">Current Fee</th>
                    <th width="30%">Fee History</th>
                    <th width="20%">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($stages as $stage)
                    @php
                        $currentFee = $stage->fees->firstWhere('effective_to', null);
                    @endphp

                    <tr>
                        <td>
                            <strong>{{ $stage->code }}</strong><br>
                            <small class="text-muted">{{ $stage->name }}</small>
                        </td>

                        <td>
                            @if($currentFee?->is_billable)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>

                        <td>
                            @if($currentFee)
                                <strong class="text-primary">
                                    {{ number_format($currentFee->amount, 2) }}
                                </strong>
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>

                        <td>
                            @foreach($stage->fees as $fee)
                                <div class="small">
                                    {{ number_format($fee->amount, 2) }}
                                    <span class="text-muted">
                                    ({{ $fee->effective_from->format('M Y') }}
                                    –
                                    {{ $fee->effective_to?->format('M Y') ?? 'Present' }})
                                </span>
                                </div>
                            @endforeach
                        </td>

                        <td>
                            <form method="POST"
                                  action="{{ route('course_fees.store', $course) }}"
                                  class="row g-1">
                                @csrf

                                <input type="hidden"
                                       name="course_stage_id"
                                       value="{{ $stage->id }}">

                                <div class="col-md-4">
                                    <input type="number"
                                           step="0.01"
                                           name="amount"
                                           class="form-control form-control-sm"
                                           placeholder="Amount"
                                           required>
                                </div>

                                <div class="col-md-3">
                                    <select name="is_billable"
                                            class="form-select form-select-sm">
                                        <option value="1">Billable</option>
                                        <option value="0">Non-Billable</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="date"
                                           name="effective_from"
                                           class="form-control form-control-sm"
                                           required>
                                </div>

                                <div class="col-md-2 d-grid">
                                    <button class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

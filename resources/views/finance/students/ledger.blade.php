{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}
{{--    <div class="page-content">--}}

{{--        @if(!$studentId)--}}
{{--            <div class="alert alert-warning">--}}
{{--                This learner has not yet activated their account.--}}
{{--                Ledger entries shown are provisional and/or legacy.--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="alert {{ $balance <= 0 ? 'alert-success' : 'alert-danger' }}">--}}
{{--            Current Balance: <strong>{{ number_format($balance, 2) }}</strong>--}}
{{--        </div>--}}
{{--            <a href="{{ route('finance.fee-statement.preview', [--}}
{{--    'student_id' => $studentId,--}}
{{--    'masterdata_id' => $masterdataId--}}
{{--]) }}"--}}
{{--               class="btn btn-outline-primary mb-3">--}}
{{--                View Fee Statement--}}
{{--            </a>--}}

{{--        <div class="card mb-4">--}}
{{--            <div class="card-body table-responsive">--}}
{{--                <table class="table table-striped mb-0">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>Date</th>--}}
{{--                        <th>Description</th>--}}
{{--                        <th class="text-end">Debit</th>--}}
{{--                        <th class="text-end">Credit</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach($ledger as $row)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $row->created_at->format('Y-m-d') }}</td>--}}
{{--                            <td>{{ $row->description }}</td>--}}
{{--                            <td class="text-end">--}}
{{--                                {{ $row->entry_type === 'debit' ? number_format($row->amount, 2) : '' }}--}}
{{--                            </td>--}}
{{--                            <td class="text-end">--}}
{{--                                {{ $row->entry_type === 'credit' ? number_format($row->amount, 2) : '' }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <hr>--}}

{{--        <h6 class="mb-3">Post Manual Adjustment</h6>--}}

{{--        --}}{{-- Manual Debit --}}
{{--        <form method="POST" action="{{ route('finance.ledger.debit') }}" class="mb-3">--}}
{{--            @csrf--}}
{{--            <input type="hidden" name="student_id" value="{{ $studentId }}">--}}
{{--            <input type="hidden" name="masterdata_id" value="{{ $masterdataId }}">--}}
{{--            <input type="hidden" name="category" value="manual_charge">--}}

{{--            <div class="row">--}}
{{--                <div class="col-md-3">--}}
{{--                    <input type="number" step="0.01" name="amount"--}}
{{--                           class="form-control" placeholder="Debit amount" required>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <input type="text" name="description"--}}
{{--                           class="form-control" placeholder="Description" required>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <button class="btn btn-danger w-100">Post Debit</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--        --}}{{-- Manual Credit --}}
{{--        <form method="POST" action="{{ route('finance.ledger.credit') }}">--}}
{{--            @csrf--}}
{{--            <input type="hidden" name="student_id" value="{{ $studentId }}">--}}
{{--            <input type="hidden" name="masterdata_id" value="{{ $masterdataId }}">--}}
{{--            <input type="hidden" name="category" value="manual_payment">--}}

{{--            <div class="row">--}}
{{--                <div class="col-md-3">--}}
{{--                    <input type="number" step="0.01" name="amount"--}}
{{--                           class="form-control" placeholder="Credit amount" required>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <input type="text" name="description"--}}
{{--                           class="form-control" placeholder="Description" required>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <button class="btn btn-success w-100">Post Credit</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--    </div>--}}
{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        {{-- ACCOUNT HEADER --}}
        <h5 class="mb-3">
            Ledger Account:
            <span class="badge bg-secondary">
            {{ class_basename($ownerType) }}
        </span>
            — {{ $accountLabel }}
        </h5>

        @if($isProvisional)
            <div class="alert alert-warning">
                This ledger is provisional or legacy.
            </div>
        @endif

        <div class="alert {{ $balance <= 0 ? 'alert-success' : 'alert-danger' }}">
            Current Balance:
            <strong>KES {{ number_format($balance, 2) }}</strong>
        </div>

        {{-- OPTIONAL: Fee Statement only for students --}}
        @if($ownerType === \App\Models\Student::class || $ownerType === \App\Models\Masterdata::class)
            <a href="{{ route('finance.fee-statement.preview', [
            'student_id' => $studentId,
            'masterdata_id' => $masterdataId
        ]) }}"
               class="btn btn-outline-primary mb-3">
                View Fee Statement
            </a>
        @endif

        {{-- LEDGER TABLE --}}
        <div class="card mb-4">
            <div class="card-body table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th class="text-end">Debit</th>
                        <th class="text-end">Credit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ledger as $row)
                        <tr>
                            <td>{{ $row->created_at->format('Y-m-d') }}</td>
                            <td>{{ $row->description }}</td>
                            <td class="text-end">
                                {{ $row->entry_type === 'debit' ? number_format($row->amount, 2) : '' }}
                            </td>
                            <td class="text-end">
                                {{ $row->entry_type === 'credit' ? number_format($row->amount, 2) : '' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MANUAL ADJUSTMENTS --}}
        <hr>
        <h6 class="mb-3">Post Manual Adjustment</h6>

        {{-- Manual Debit --}}
        <form method="POST" action="{{ route('finance.ledger.debit') }}" class="mb-3">
            @csrf
            <input type="hidden" name="ledger_owner_type" value="{{ $ownerType }}">
            <input type="hidden" name="ledger_owner_id" value="{{ $ownerId }}">
            <input type="hidden" name="category" value="manual_charge">

            <div class="row">
                <div class="col-md-3">
                    <input type="number" step="0.01" name="amount"
                           class="form-control" placeholder="Debit amount" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="description"
                           class="form-control" placeholder="Description" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger w-100">Post Debit</button>
                </div>
            </div>
        </form>

        {{-- Manual Credit --}}
        <form method="POST" action="{{ route('finance.ledger.credit') }}">
            @csrf
            <input type="hidden" name="ledger_owner_type" value="{{ $ownerType }}">
            <input type="hidden" name="ledger_owner_id" value="{{ $ownerId }}">
            <input type="hidden" name="category" value="manual_payment">

            <div class="row">
                <div class="col-md-3">
                    <input type="number" step="0.01" name="amount"
                           class="form-control" placeholder="Credit amount" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="description"
                           class="form-control" placeholder="Description" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success w-100">Post Credit</button>
                </div>
            </div>
        </form>

    </div>
@endsection

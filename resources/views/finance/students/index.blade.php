{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}
{{--    <div class="page-content">--}}

{{--        <h5 class="mb-3">Student Finance</h5>--}}

{{--        <form method="GET">--}}
{{--            <input type="text" name="q" class="form-control mb-3"--}}
{{--                   placeholder="Search by admission number">--}}
{{--        </form>--}}

{{--        <div class="card">--}}
{{--            <div class="card-body">--}}
{{--                <table class="table table-bordered" >--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>Admission No</th>--}}
{{--                        <th>Action</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach($subjects as $item)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $item->admission_no }}</td>--}}
{{--                            <td>--}}
{{--                                @if($item->student_id)--}}
{{--                                    <a href="{{ route('finance.students.ledger', $item->student_id) }}"--}}
{{--                                       class="btn btn-sm btn-primary">--}}
{{--                                        View Ledger--}}
{{--                                    </a>--}}
{{--                                @else--}}
{{--                                    <span class="badge bg-warning">Not Activated</span>--}}
{{--                                @endif--}}
{{--                                <a href="{{ route('finance.ledger.view', [--}}
{{--    'student_id' => $item->student_id,--}}
{{--    'masterdata_id' => $item->masterdata_id--}}
{{--]) }}"--}}
{{--                                   class="btn btn-sm btn-primary">--}}
{{--                                    View Ledger--}}
{{--                                </a>--}}

{{--                                @if(!$item->student_id)--}}
{{--                                    <span class="badge bg-warning ms-2">Not Activated</span>--}}
{{--                                @endif--}}

{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}

{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <h5 class="mb-3">Finance Ledger Accounts</h5>

        <form method="GET">
            <input type="text" name="q" class="form-control mb-3"
                   placeholder="Search by admission no / reference">
        </form>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Account Ref</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $acc)
                        <tr>
                            <td>{{ $acc->account_reference }}</td>
                            <td>
                            <span class="badge bg-info">
                                {{ $acc->account_type }}
                            </span>
                            </td>
                            <td>
                                @if($acc->ledger_owner_type && $acc->ledger_owner_id)
                                    <a href="{{ route('finance.ledger.view.owner', [
        'type' => urlencode($acc->ledger_owner_type),
        'id'   => $acc->ledger_owner_id
    ]) }}"
                                       class="btn btn-sm btn-primary">
                                        View Ledger
                                    </a>
                                @else
                                    <span class="badge bg-danger">Invalid Ledger</span>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

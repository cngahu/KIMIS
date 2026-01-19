@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <h5>Invoice Reconciliation</h5>

        <div class="alert alert-info">
            This process synchronizes invoices and payments into the student ledger.
            <br>
            It is safe to run multiple times and will not duplicate entries.
        </div>

        <form method="POST" action="{{ route('finance.reconciliation.run') }}"
              onsubmit="return confirm('Are you sure you want to run reconciliation?');">
            @csrf
            <button class="btn btn-primary">
                Run Reconciliation
            </button>
        </form>

        @if(session('summary'))
            <hr>
            <h6>Last Run Summary</h6>
            <table class="table table-bordered w-50">
                @foreach(session('summary') as $key => $value)
                    <tr>
                        <th>{{ ucwords(str_replace('_',' ', $key)) }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

    </div>
@endsection

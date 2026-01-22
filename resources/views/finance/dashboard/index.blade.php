@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <h4 class="fw-bold mb-3">Finance Dashboard</h4>

        {{-- FILTER --}}
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-3">
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        {{-- SUMMARY --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Total Debits</small>
                    <h5 class="fw-bold text-danger">KES {{ number_format($totalDebits, 2) }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Total Credits</small>
                    <h5 class="fw-bold text-success">KES {{ number_format($totalCredits, 2) }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Outstanding</small>
                    <h5 class="fw-bold {{ $outstanding > 0 ? 'text-warning' : 'text-success' }}">
                        KES {{ number_format($outstanding, 2) }}
                    </h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Today’s Collections</small>
                    <h5 class="fw-bold text-success">KES {{ number_format($todayCredits, 2) }}</h5>
                </div>
            </div>
        </div>

        {{-- CATEGORY BREAKDOWN --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Category Breakdown</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th class="text-end">Debits</th>
                        <th class="text-end">Credits</th>
                        <th class="text-end">Net</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categoryBreakdown as $row)
                        <tr>
                            <td>{{ ucfirst(str_replace('_',' ', $row->category)) }}</td>
                            <td class="text-end">{{ number_format($row->debits, 2) }}</td>
                            <td class="text-end">{{ number_format($row->credits, 2) }}</td>
                            <td class="text-end fw-bold">
                                {{ number_format($row->debits - $row->credits, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DAILY SNAPSHOT --}}
        <div class="card">
            <div class="card-header fw-bold">Daily Activity (Last 14 Days)</div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-end">Debits</th>
                        <th class="text-end">Credits</th>
                        <th class="text-end">Net</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($daily as $d)
                        <tr>
                            <td>{{ $d->day }}</td>
                            <td class="text-end">{{ number_format($d->debits, 2) }}</td>
                            <td class="text-end">{{ number_format($d->credits, 2) }}</td>
                            <td class="text-end fw-bold">
                                {{ number_format($d->debits - $d->credits, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

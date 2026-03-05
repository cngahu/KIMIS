{{-- resources/views/student/fees/statement.blade.php --}}
@extends('admin.admin_dashboard')

@section('title', 'Full Fee Statement')

@section('admin')

<style>
    :root {
        --primary: #3b2818;
        --primary-light: #5a3d2b;
        --primary-dark: #2a1a0f;
        --accent: #f9a90f;
        --success: #099139;
        --danger: #b3261e;
        --secondary: #858585;
        --border-light: #e8e8e8;
        --border-primary: rgba(59,40,24,0.2);
        --bg-card: #ffffff;
        --bg-primary: rgba(59,40,24,0.05);
        --bg-accent: rgba(249,169,15,0.1);
        --bg-gradient: linear-gradient(135deg, #fffefc, #ffffff);
        --shadow-md: 0 6px 18px rgba(59,40,24,0.08);
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-sm: 8px;
    }

    .page-content {
        max-width: 1100px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    /* ── Header ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--primary);
        flex-wrap: wrap;
    }

    .page-header h4 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 0.2rem;
    }

    .page-header p {
        margin: 0;
        font-size: 0.88rem;
        color: var(--secondary);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* ── Student Info Card ── */
    .info-card {
        background: var(--bg-gradient);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-md);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item .i-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--secondary);
        font-weight: 500;
    }

    .info-item .i-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--primary);
    }

    /* ── Balance Summary ── */
    .balance-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .balance-box {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-md);
        padding: 1rem 1.25rem;
        text-align: center;
    }

    .balance-box .b-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--secondary);
        font-weight: 500;
        margin-bottom: 0.3rem;
    }

    .balance-box .b-amount {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--primary);
    }

    .balance-box.outstanding .b-amount { color: var(--danger); }
    .balance-box.paid .b-amount        { color: var(--success); }
    .balance-box.balance-due .b-amount { color: var(--danger); }
    .balance-box.balance-credit .b-amount { color: var(--success); }

    /* ── Statement Table ── */
    .statement-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .statement-card-header {
        padding: 1rem 1.5rem;
        background: var(--bg-primary);
        border-bottom: 2px solid var(--border-primary);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .statement-card-header h6 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .statement-card-header .date-badge {
        font-size: 0.8rem;
        color: var(--secondary);
    }

    table.stmt-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.92rem;
    }

    table.stmt-table thead tr {
        background: var(--bg-primary);
    }

    table.stmt-table thead th {
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--primary);
        border-bottom: 1px solid var(--border-primary);
        white-space: nowrap;
    }

    table.stmt-table tbody td {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
        color: #333;
    }

    table.stmt-table tbody tr:hover {
        background: var(--bg-accent);
    }

    table.stmt-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.stmt-table .mono {
        font-family: 'SF Mono', 'Monaco', 'Courier New', monospace;
        font-weight: 500;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .type-badge.debit {
        background: rgba(179,38,30,0.1);
        color: var(--danger);
    }

    .type-badge.credit {
        background: rgba(9,145,57,0.1);
        color: var(--success);
    }

    .running-balance.positive { color: var(--success); font-weight: 700; }
    .running-balance.negative { color: var(--danger);  font-weight: 700; }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--secondary);
    }

    .empty-state i {
        font-size: 2.5rem;
        color: #ddd;
        display: block;
        margin-bottom: 0.75rem;
    }

    /* ── Totals Row ── */
    .totals-row td {
        background: var(--bg-primary);
        font-weight: 700;
        border-top: 2px solid var(--border-primary) !important;
    }

    /* ── Buttons ── */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.6rem 1.2rem;
        border-radius: var(--radius-md);
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.15s;
    }

    .btn-action.primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
    }

    .btn-action.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59,40,24,0.25);
        color: #fff;
    }

    .btn-action.outline {
        border: 2px solid var(--primary);
        color: var(--primary);
        background: transparent;
    }

    .btn-action.outline:hover {
        background: var(--primary);
        color: #fff;
    }

    @media (max-width: 768px) {
        .page-content { padding: 1rem 0.75rem; }
        .page-header { flex-direction: column; }
        .header-actions { width: 100%; }
        .btn-action { flex: 1; justify-content: center; }
        table.stmt-table { font-size: 0.82rem; }
        table.stmt-table thead th,
        table.stmt-table tbody td { padding: 0.6rem 0.75rem; }
    }
</style>

<div class="page-content">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('student.student_dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('student.fees.index') }}">Fees</a>
            </li>
            <li class="breadcrumb-item active">Full Statement</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h4><i class="fas fa-file-invoice-dollar me-2"></i>Full Fee Statement</h4>
            <p>Complete transaction history as at {{ $statement_date->format('d F Y, H:i') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('student.fees.download') }}" class="btn-action primary">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <a href="{{ route('student.fees.index') }}" class="btn-action outline">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Student Info --}}
    <div class="info-card">
        <div class="info-item">
            <div class="i-label">Student Name</div>
            <div class="i-value">{{ auth()->user()->firstname }} {{ auth()->user()->surname }}</div>
        </div>
        <div class="info-item">
            <div class="i-label">Admission No.</div>
            <div class="i-value">{{ $student->student_number ?? auth()->user()->username }}</div>
        </div>
        <div class="info-item">
            <div class="i-label">Course</div>
            <div class="i-value">{{ $student->course->course_name ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="i-label">Campus</div>
            <div class="i-value">{{ $student->campus->name ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="i-label">Statement Date</div>
            <div class="i-value">{{ $statement_date->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Balance Summary --}}
    @php
        $totalDebit  = $ledger->where('entry_type', 'debit')->sum('amount');
        $totalCredit = $ledger->where('entry_type', 'credit')->sum('amount');
    @endphp

    <div class="balance-summary">
        <div class="balance-box outstanding">
            <div class="b-label">Total Charged</div>
            <div class="b-amount">KES {{ number_format($totalDebit, 2) }}</div>
        </div>
        <div class="balance-box paid">
            <div class="b-label">Total Paid</div>
            <div class="b-amount">KES {{ number_format($totalCredit, 2) }}</div>
        </div>
        <div class="balance-box {{ $balance > 0 ? 'balance-due' : 'balance-credit' }}">
            <div class="b-label">{{ $balance > 0 ? 'Amount Due' : 'Credit Balance' }}</div>
            <div class="b-amount">KES {{ number_format(abs($balance), 2) }}</div>
        </div>
    </div>

    {{-- Ledger Table --}}
    <div class="statement-card">
        <div class="statement-card-header">
            <h6><i class="fas fa-list-alt me-2"></i>Transaction Ledger</h6>
            <span class="date-badge">{{ $ledger->count() }} transaction(s)</span>
        </div>

        <div class="table-responsive">
            <table class="stmt-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th class="text-end">Debit (KES)</th>
                        <th class="text-end">Credit (KES)</th>
                        <th class="text-end">Running Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ledger as $i => $row)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td>{{ $row->created_at->format('d M Y') }}</td>
                            <td>{{ $row->description ?? '—' }}</td>
                            <td>
                                @if($row->entry_type === 'debit')
                                    <span class="type-badge debit">
                                        <i class="fas fa-arrow-up"></i> Debit
                                    </span>
                                @else
                                    <span class="type-badge credit">
                                        <i class="fas fa-arrow-down"></i> Credit
                                    </span>
                                @endif
                            </td>
                            <td class="text-end mono">
                                @if($row->entry_type === 'debit')
                                    <span class="text-danger">{{ number_format($row->amount, 2) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end mono">
                                @if($row->entry_type === 'credit')
                                    <span class="text-success">{{ number_format($row->amount, 2) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end mono">
                                <span class="running-balance {{ $row->running_balance > 0 ? 'negative' : 'positive' }}">
                                    {{ number_format($row->running_balance, 2) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-receipt"></i>
                                    <p class="mb-1">No transactions found.</p>
                                    <small>Your fee statement will appear here once transactions are recorded.</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Totals Row --}}
                    @if($ledger->count() > 0)
                        <tr class="totals-row">
                            <td colspan="4" class="text-end">TOTALS</td>
                            <td class="text-end mono text-danger">{{ number_format($totalDebit, 2) }}</td>
                            <td class="text-end mono text-success">{{ number_format($totalCredit, 2) }}</td>
                            <td class="text-end mono {{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($balance, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer note --}}
    <p style="font-size:0.78rem;color:#aaa;text-align:center;margin-top:1rem;">
        <i class="fas fa-info-circle"></i>
        This statement is generated electronically and is valid without a signature.
        For queries, contact the finance office.
    </p>

</div>

@endsection
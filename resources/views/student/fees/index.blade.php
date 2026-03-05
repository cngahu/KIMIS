@extends('admin.admin_dashboard')

@section('title', 'Student Fee Statement')

@section('admin')

    <style>
        :root {
            --primary: #3b2818;
            --primary-light: #5a3d2b;
            --primary-dark: #2a1a0f;
            --accent: #f9a90f;
            --accent-hover: #d18b00;
            --secondary: #858585;
            --success: #099139;
            --warning: #f9a90f;
            --danger: #b3261e;
            --bg-card: #ffffff;
            --bg-soft: #f5f6f5;
            --bg-gradient: linear-gradient(135deg, #fffefc, #ffffff);
            --bg-accent: rgba(249, 169, 15, 0.1);
            --bg-primary: rgba(59, 40, 24, 0.05);
            --border-light: #e8e8e8;
            --border-primary: rgba(59, 40, 24, 0.2);
            --shadow-sm: 0 2px 8px rgba(59, 40, 24, 0.06);
            --shadow-md: 0 6px 18px rgba(59, 40, 24, 0.08);
            --text-primary: #26211d;
            --text-secondary: #858585;
            --text-on-primary: #ffffff;
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition-fast: 0.15s ease;
        }

        .page-content {
            padding: calc(var(--header-height, 60px) + var(--spacing-lg)) var(--spacing-lg) var(--spacing-lg);
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
            padding: var(--spacing-md) 0;
            border-bottom: 1px solid var(--primary);
        }

        .page-header h4 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
            color: var(--primary);
        }

        .page-header .text-muted {
            font-size: 0.95rem;
            color: var(--secondary) !important;
        }

        .balance-card {
            background: var(--bg-gradient);
            border-radius: var(--radius-xl);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-md);
            margin-bottom: var(--spacing-xl);
            border: 4px solid var(--accent);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--spacing-lg);
        }

        .balance-card .balance-info { flex: 1; }

        .balance-card .balance-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--secondary);
            font-weight: 500;
            margin-bottom: var(--spacing-xs);
        }

        .balance-card .balance-amount {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: var(--primary);
        }

        .balance-card .balance-amount.positive { color: var(--success); }
        .balance-card .balance-amount.negative { color: var(--danger); }

        .balance-card .balance-actions {
            display: flex;
            gap: var(--spacing-sm);
        }

        .statement-table {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
        }

        .statement-table .table {
            margin-bottom: 0;
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-primary);
        }

        .statement-table thead {
            background: var(--bg-primary);
            border-bottom: 2px solid var(--border-primary);
        }

        .statement-table thead th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--primary);
            padding: var(--spacing-md) var(--spacing-lg);
            border: none;
        }

        .statement-table tbody td {
            padding: var(--spacing-md) var(--spacing-lg);
            border-bottom: 1px solid var(--border-light);
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .statement-table tbody tr:hover { background: var(--bg-accent); }
        .statement-table tbody tr:last-child td { border-bottom: none; }

        .statement-table .text-end {
            font-family: 'SF Mono', 'Monaco', 'Courier New', monospace;
            font-weight: 500;
        }

        .btn {
            border-radius: var(--radius-md);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--text-on-primary) !important;
            box-shadow: 0 2px 4px rgba(59, 40, 24, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-on-primary) !important;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary) !important;
            background: transparent;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: var(--text-on-primary) !important;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: var(--spacing-xl) var(--spacing-lg);
            color: var(--secondary);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--border-light);
            margin-bottom: var(--spacing-md);
            display: block;
        }

        @media (max-width: 991px) {
            .page-content { padding: var(--spacing-md); }
            .page-header { flex-direction: column; align-items: flex-start; }
            .balance-card { flex-direction: column; align-items: flex-start; }
            .balance-card .balance-actions { justify-content: center; width: 100%; flex-direction: column; }
        }

        @media (max-width: 767px) {
            .page-content { padding: var(--spacing-sm); }
            .balance-card .balance-amount { font-size: 1.5rem; }
            .statement-table { display: block; overflow-x: auto; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>

    <div class="page-content">

        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <h4 class="fw-bold mb-1">Fee Statement</h4>
                <p class="text-muted mb-0">View your transaction history and download official statements</p>
            </div>
            <a href="{{ route('student.fees.download') }}" class="btn btn-primary">
                <i class="fas fa-download"></i>
                Download PDF
            </a>
        </div>

        {{-- BALANCE CARD --}}
        <div class="balance-card">
            <div class="balance-info">
                <div class="balance-label">Outstanding Balance</div>
                <h3 class="balance-amount {{ $balance <= 0 ? 'positive' : 'negative' }}">
                    KES {{ number_format($balance, 2) }}
                </h3>
            </div>
            <div class="balance-actions">
                @if($balance > 0)
                    {{-- ✅ Simple GET link to the initiate payment page --}}
                    <a href="{{ route('student.payments.initiate') }}" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i>
                        Make Payment
                    </a>
                @endif
                <a href="{{ route('student.fees.statement') }}" class="btn btn-outline-primary">
                    <i class="fas fa-file-alt"></i>
                    View Full Statement
                </a>
            </div>
        </div>

        {{-- LEDGER TABLE --}}
        <div class="statement-table">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th class="text-end">Debit</th>
                            <th class="text-end">Credit</th>
                            <th class="text-end">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledger as $row)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $row->created_at->format('d M Y') }}</span>
                                </td>
                                <td>{{ $row->description }}</td>
                                <td class="text-end">
                                    @if($row->entry_type === 'debit')
                                        <span class="text-danger fw-bold">-{{ number_format($row->amount, 2) }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($row->entry_type === 'credit')
                                        <span class="text-success fw-bold">+{{ number_format($row->amount, 2) }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">
                                    {{ number_format($row->running_balance, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-receipt"></i>
                                        <p class="mb-0">No transactions found.</p>
                                        <small class="text-muted">Your fee statement will appear here once you have transactions.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
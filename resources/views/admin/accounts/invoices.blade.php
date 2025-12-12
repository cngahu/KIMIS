@extends('admin.admin_dashboard')

@section('admin')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-top: 20px;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            padding: 8px 14px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .pagination .page-link:hover {
            background: #f1f1f1;
        }

        .pagination .active .page-link {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        .pagination .disabled .page-link {
            color: #aaa;
            pointer-events: none;
            background: #fff;
        }

    </style>

    <div class="page-content">

        <h4 class="fw-bold mb-3">All Invoices</h4>

        <div class="card p-3">

            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>Invoice No</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Paid At</th>
                </tr>
                </thead>

                <tbody>

                @foreach($invoices as $inv)
                    <tr>
                        <td>{{ $inv->invoice_number }}</td>

                        @php
                            // admission invoice
                            $adm = $inv->admission;

                            // application invoice
                            $app = $inv->application;
                        @endphp

                        <td>
                            @if($adm)
                                {{ $adm->user->surname }} {{ $adm->user->firstname }}
                            @elseif($app && $app->full_name)
                                {{ $app->full_name }}
                            @else
                                <em>N/A</em>
                            @endif
                        </td>


                        <td>{{ optional($inv->application?->course)->course_name ?? '--' }}</td>

                        <td>KES {{ number_format($inv->amount,2) }}</td>

                        <td>
                            <span class="badge
                                @if($inv->status === 'paid') bg-success
                                @elseif($inv->status === 'pending') bg-warning
                                @else bg-danger
                                @endif">
                                {{ ucfirst($inv->status) }}
                            </span>
                        </td>

                        <td>
                            {{ optional($inv->paid_at)->format('d M Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @endforeach

                </tbody>

            </table>

            <div class="mt-3">
                {{ $invoices->links() }}
            </div>

        </div>

    </div>

@endsection

<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #003366; color: white; }
    </style>
</head>
<body>

<div class="title">
    <h3>Daily Collections Report</h3>
    <div>Generated: {{ $generatedAt }}</div>
</div>

<table>
    <thead>
    <tr>
        <th>Invoice #</th>
        <th>Category</th>
        <th>Payer</th>
        <th>Amount</th>
        <th>Paid</th>
        <th>Channel</th>
        <th>Ecitizen Ref</th>
        <th>Gateway Ref</th>
        <th>Paid At</th>
    </tr>
    </thead>

    <tbody>
    @foreach($invoices as $inv)
        <tr>
            <td>{{ $inv->invoice_number }}</td>
            <td>{{ ucfirst($inv->category) }}</td>
            <td>{{ optional($inv->billable)->full_name ?? optional($inv->billable)->employer_name ?? 'N/A' }}</td>
            <td>{{ number_format($inv->amount, 2) }}</td>
            <td>{{ number_format($inv->amount_paid, 2) }}</td>
            <td>{{ $inv->payment_channel }}</td>
            <td>{{ $inv->ecitizen_invoice_number }}</td>
            <td>{{ $inv->gateway_reference }}</td>
            <td>{{ optional($inv->paid_at)->format('d M Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

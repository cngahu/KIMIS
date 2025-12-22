<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align:center; margin-bottom:20px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ccc; padding:8px; }
        th { background:#f3f3f3; }
        .right { text-align:right; }
        .paid {
            color: green;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>KIHBT</h2>
    <p><strong>OFFICIAL RECEIPT</strong></p>
</div>

<p>
    <strong>Receipt No:</strong> {{ $invoice->invoice_number }}<br>
    <strong>Date Paid:</strong> {{ optional($invoice->paid_at)->format('d M Y') }}<br>
</p>

<table>
    <thead>
    <tr>
        <th>Description</th>
        <th class="right">Amount (KES)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->items as $item)
        <tr>
            <td>{{ $item->item_name }}</td>
            <td class="right">{{ number_format($item->total_amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Total Paid</th>
        <th class="right">{{ number_format($invoice->amount, 2) }}</th>
    </tr>
    </tfoot>
</table>

<div class="paid">
    ✔ PAID IN FULL
</div>

</body>
</html>

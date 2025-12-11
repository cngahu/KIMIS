{{-- resources/views/public/payments/invoice-pdf.blade.php --}}
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align:center; margin-bottom:20px; }
        .title { font-size:20px; font-weight:bold; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        table, th, td { border:1px solid black; }
        th { background:#f0f0f0; }
        .section-title { font-weight:bold; margin-top:15px; }
    </style>
</head>

<body>

<div class="header">
    <img src="{{ public_path('images/kihbt-logo.png') }}" height="80">
    <p class="title">Short Course Invoice</p>
    <p>Invoice No: <strong>{{ $invoice->invoice_number }}</strong></p>
</div>

<p class="section-title">Bill To</p>
<p>
    {{ $payer['name'] }} <br>
    {{ $payer['address'] }} <br>
    {{ $payer['town'] }}, {{ $payer['county'] }} <br>
    Phone: {{ $payer['phone'] }} | Email: {{ $payer['email'] }}
</p>

<p class="section-title">Invoice Summary</p>
<p><strong>Total Amount:</strong> KSh {{ number_format($invoice->amount, 2) }}</p>

<p class="section-title">Participants</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Full Name</th>
        <th>ID No</th>
        <th>Phone</th>
    </tr>
    </thead>

    <tbody>
    @foreach($participants as $index => $p)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $p->full_name }}</td>
            <td>{{ $p->id_no }}</td>
            <td>{{ $p->phone }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

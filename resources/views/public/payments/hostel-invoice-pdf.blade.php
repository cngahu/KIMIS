<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header img {
            height: 80px;
            margin-bottom: 8px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 13px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: left;
            padding: 6px;
        }

        td {
            padding: 6px;
        }

        .no-border {
            border: none;
        }

        .amount {
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            margin-top: 35px;
            font-size: 11px;
            text-align: center;
            color: #444;
        }
    </style>
</head>

<body>

{{-- HEADER --}}
<div class="header">
    <img src="{{ public_path('images/kihbt-logo.png') }}" alt="KIHBT">
    <div class="title">Hostel Accommodation Invoice</div>
    <div class="subtitle">
        Invoice No: <strong>{{ $invoice->invoice_number }}</strong><br>
        Invoice Date: {{ $invoice->created_at->format('d M Y') }}
    </div>
</div>

{{-- BILL TO --}}
<div class="section-title">Bill To</div>
<table>
    <tr>
        <td class="no-border">
            <strong>{{ $payer['name'] }}</strong><br>
            ID / Passport: {{ $booking->id_number }}<br>
            Phone: {{ $payer['phone'] }}<br>
            Email: {{ $payer['email'] }}
        </td>
    </tr>
</table>

{{-- BOOKING DETAILS --}}
<div class="section-title">Hostel Booking Details</div>
<table>
    <tr>
        <th width="35%">Booking Reference</th>
        <td>{{ $booking->reference }}</td>
    </tr>
    <tr>
        <th>Course</th>
        <td>{{ optional($booking->course)->course_name }}</td>
    </tr>
    <tr>
        <th>Campus</th>
        <td>{{ optional($booking->college)->name }}</td>
    </tr>
    <tr>
        <th>Boarding Type</th>
        <td>{{ ucfirst($booking->boarding_type) }} Board</td>
    </tr>
</table>

{{-- INVOICE SUMMARY --}}
<div class="section-title">Invoice Summary</div>
<table>
    <tr>
        <th>Description</th>
        <th width="20%">Amount (KES)</th>
    </tr>
    <tr>
        <td>Hostel Accommodation Fee</td>
        <td class="amount">
            {{ number_format($invoice->amount, 2) }}
        </td>
    </tr>
</table>

{{-- NOTES --}}
<div class="section-title">Notes</div>
<p>
    This invoice is issued for hostel accommodation at the Kenya Institute of
    Highways and Building Technology (KIHBT).
    Hostel allocation is subject to full payment of the invoiced amount.
</p>

{{-- FOOTER --}}
<div class="footer">
    © {{ date('Y') }} Kenya Institute of Highways and Building Technology (KIHBT).<br>
    This is a system-generated invoice and does not require a signature.
</div>

</body>
</html>

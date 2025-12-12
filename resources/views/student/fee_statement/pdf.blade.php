<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 90px; margin-bottom: 8px; }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #0a3d62;
        }
        .subtitle {
            font-size: 14px;
            font-weight: bold;
            margin-top: 6px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 18px;
            margin-bottom: 6px;
            color: #0a3d62;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        th {
            background: #0a3d62;
            color: #fff;
            padding: 6px;
            font-size: 12px;
            border: 1px solid #555;
        }
        td {
            padding: 6px;
            border: 1px solid #aaa;
            font-size: 12px;
        }

        .totals-row td {
            font-weight: bold;
            background: #f0f0f0;
        }

        .text-right { text-align: right; }
        .text-success { color: green; }
        .text-danger { color: red; }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 25px;
            color: #777;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">
    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
    <div class="subtitle">Student Fee Statement</div>
    <small>Generated on: {{ now()->format('d M Y H:i') }}</small>
</div>

<!-- STUDENT INFO -->
<div class="section-title">Student Information</div>

<table>
    <tr>
        <td width="30%"><strong>Student Name</strong></td>
        <td>{{ $admission->application->full_name }}</td>
    </tr>
    <tr>
        <td><strong>Admission Number</strong></td>
        <td>{{ $admission->admission_no ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Course</strong></td>
        <td>{{ $admission->application->course->course_name }}</td>
    </tr>
</table>

<!-- SUMMARY -->
<div class="section-title">Fee Summary</div>

<table>
    <tr>
        <td width="40%"><strong>Total Fee Required</strong></td>
        <td>KSh {{ number_format($requiredFee, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Total Paid</strong></td>
        <td class="text-success">KSh {{ number_format($paidTotal, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Balance</strong></td>
        <td class="{{ $balance > 0 ? 'text-danger' : 'text-success' }}">
            KSh {{ number_format($balance, 2) }}
        </td>
    </tr>
</table>

<!-- PAYMENT HISTORY -->
<div class="section-title">Payment History</div>

<table>
    <thead>
    <tr>
        <th>Invoice No.</th>
        <th>Amount</th>
        <th>Channel</th>
        <th>Date Paid</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $p)
        <tr>
            <td>{{ $p->invoice->invoice_number }}</td>
            <td class="text-right">KSh {{ number_format($p->amount, 2) }}</td>
            <td>{{ ucfirst($p->invoice->payment_channel ?? 'Unknown') }}</td>
            <td>{{ optional($p->invoice->paid_at)->format('d M Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>

    <tfoot>
    <tr class="totals-row">
        <td class="text-right">TOTAL PAID</td>
        <td class="text-right">KSh {{ number_format($paidTotal, 2) }}</td>
        <td colspan="2"></td>
    </tr>
    </tfoot>
</table>

<!-- FOOTER -->
<div class="footer">
    This statement is system-generated and does not require a signature.
</div>

</body>
</html>

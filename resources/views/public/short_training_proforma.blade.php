<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KIHBT Proforma Invoice</title>

    <style>
        @page {
            margin: 30px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 90px;
        }

        .institution-details {
            text-align: center;
        }

        .institution-details h2 {
            margin: 0;
            font-size: 18px;
        }

        .institution-details p {
            margin: 2px 0;
            font-size: 11px;
        }

        .title {
            text-align: center;
            margin: 25px 0 15px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 6px 8px;
            border: 1px solid #000;
            font-size: 11px;
        }

        .info-table td.label {
            width: 25%;
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .ledger-table th,
        .ledger-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        .ledger-table th {
            background-color: #e6e6e6;
            text-align: center;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .summary-box {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #000;
            font-size: 12px;
        }

        .summary-box strong {
            font-size: 13px;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            left: 40px;
            right: 40px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .stamp {
            margin-top: 40px;
            width: 100%;
        }

        .stamp td {
            width: 50%;
            vertical-align: top;
            font-size: 11px;
        }

        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 70%;
        }
    </style>
</head>

<body>

{{-- ================= HEADER ================= --}}
<div class="header">
    <table class="header-table">
        <tr>
            <td width="20%">
                <img src="{{ public_path('adminbackend/assets/images/logokihbt.png') }}"
                     class="logo">
            </td>

            <td width="60%" class="institution-details">
                <h2>KENYA INSTITUTE OF HIGHWAY & BUILDING TECHNOLOGY</h2>
                <p>P.O. Box 57511 – 00200, Nairobi</p>
                <p>Website: www.kihbt.ac.ke</p>
            </td>

            <td width="20%" style="text-align:right;">
                <p><strong>Date:</strong> {{ now()->format('d M Y') }}</p>
            </td>
        </tr>
    </table>
</div>

{{-- ================= TITLE ================= --}}
<div class="title">
    PROFORMA INVOICE
</div>

{{-- ================= APPLICATION / BILLING INFO ================= --}}
<table class="info-table">
    <tr>
        <td class="label">Application Reference</td>
        <td>{{ $application->reference }}</td>

        <td class="label">Invoice Type</td>
        <td>Proforma</td>
    </tr>

    <tr>
        <td class="label">Training</td>
        <td colspan="3">
            {{ optional($application->training)->name }}
        </td>
    </tr>

    <tr>
        <td class="label">Total Participants</td>
        <td>{{ $application->total_participants }}</td>

        <td class="label">Financier</td>
        <td>{{ ucfirst($application->financier) }}</td>
    </tr>

    <tr>
        <td class="label">Bill To</td>
        <td colspan="3">
            @if($application->financier === 'employer')
                <strong>{{ $application->employer_name }}</strong><br>
                Attn: {{ $application->employer_contact_person }}<br>
                {{ $application->employer_phone }} |
                {{ $application->employer_email }}
            @else
                <strong>{{ optional($application->participants->first())->full_name }}</strong><br>
                {{ optional($application->participants->first())->phone }} |
                {{ optional($application->participants->first())->email }}
            @endif
        </td>
    </tr>
</table>

{{-- ================= LEDGER TABLE ================= --}}
<table class="ledger-table">
    <thead>
    <tr>
        <th width="12%">Date</th>
        <th width="44%">Description</th>
        <th width="14%">Debit (KES)</th>
        <th width="14%">Credit (KES)</th>
        <th width="16%">Balance (KES)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ledger as $row)
        <tr>
            <td>{{ $row->created_at->format('d M Y') }}</td>
            <td>{{ $row->description }}</td>
            <td class="text-right">
                {{ $row->entry_type === 'debit' ? number_format($row->amount,2) : '' }}
            </td>
            <td class="text-right">
                {{ $row->entry_type === 'credit' ? number_format($row->amount,2) : '' }}
            </td>
            <td class="text-right">
                {{ number_format($row->running_balance,2) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- ================= SUMMARY ================= --}}
<div class="summary-box">
    <strong>Outstanding Amount:</strong>
    {{ number_format($balance, 2) }} KES
    <br><br>
    <em>
        This is a proforma invoice generated prior to payment.
        Payment confirmation will trigger issuance of an official receipt.
    </em>
</div>

{{-- ================= SIGNATURE ================= --}}
<table class="stamp">
    <tr>
        <td>
            <strong>Prepared By:</strong>
            <div class="signature-line"></div>
            Accounts Office
        </td>
        <td style="text-align:right;">
            <strong>Official Stamp:</strong>
            <div class="signature-line"></div>
        </td>
    </tr>
</table>

{{-- ================= FOOTER ================= --}}
<div class="footer">
    This is a system-generated proforma invoice from the KIHBT Short Courses Finance System.
    It is not a tax invoice and does not confirm payment.
</div>

</body>
</html>

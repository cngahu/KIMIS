<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KIHBT – Nominal Roll</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            width: 100%;
            margin-bottom: 10px;
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

        .institution {
            text-align: center;
        }

        .institution h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .institution p {
            margin: 2px 0;
            font-size: 11px;
        }

        .contact {
            font-size: 10px;
            margin-top: 4px;
        }

        .title {
            text-align: center;
            margin: 15px 0 10px 0;
        }

        .title h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .meta {
            width: 100%;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .meta td {
            padding: 3px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

{{-- ===== HEADER ===== --}}
<div class="header">
    <table class="header-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('images/kihbt-logo.png') }}" class="logo">
            </td>
            <td width="70%" class="institution">
                <h2>KENYA INSTITUTE OF HIGHWAYS AND BUILDING TECHNOLOGY</h2>
                <p>P.O. Box 57511 – 00200, Nairobi, Kenya</p>
                <div class="contact">
                    Tel: +254 20 2729200 / 2729270 &nbsp; | &nbsp;
                    Email: info@kihbt.ac.ke &nbsp; | &nbsp;
                    Web: www.kihbt.ac.ke
                </div>
            </td>
            <td width="15%"></td>
        </tr>
    </table>
</div>

<hr>

{{-- ===== DOCUMENT TITLE ===== --}}
<div class="title">
    <h3>STUDENT LIST – {{ strtoupper($participants->first()->course_name ?? '') }}</h3>
</div>

<table class="meta">
    <tr>
        <td width="50%">
            <strong>Course:</strong>
            {{ $participants->first()->course_name ?? '' }}
        </td>
        <td width="50%">
            <strong>Intake:</strong>
            {{ $participants->first()->intake_year ?? '' }} /
            {{ $participants->first()->intake_month ?? '' }}
        </td>
    </tr>
</table>

{{-- ===== PARTICIPANTS TABLE ===== --}}
<table class="data">
    <thead>
    <tr>
        <th width="5%" class="text-center">#</th>
        <th width="30%">Full Name</th>
        <th width="15%">Admission No.</th>
        <th width="15%">Phone</th>
        <th width="20%">Email</th>
        <th width="15%">Remarks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($participants as $index => $p)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $p->full_name }}</td>
            <td>{{ $p->admissionNo }}</td>
            <td>{{ $p->phone }}</td>
            <td>{{ $p->email }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- ===== FOOTER ===== --}}
<div class="footer">
    <p>
        Generated on {{ now()->format('d M Y, H:i') }} |
        KIMS
    </p>
</div>

</body>
</html>

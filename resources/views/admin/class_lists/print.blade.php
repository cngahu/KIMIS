<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KIHBT – Student Class List</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
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
        }

        hr {
            margin: 10px 0;
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
        }

        .meta td {
            font-size: 11px;
            padding: 3px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data th {
            background: #f2f2f2;
            font-weight: bold;
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

{{-- HEADER --}}
<table class="header-table">
    <tr>
        <td width="15%">
            <img src="{{ public_path('images/kihbt-logo.png') }}" class="logo">
        </td>
        <td width="70%" class="institution">
            <h2>KENYA INSTITUTE OF HIGHWAYS AND BUILDING TECHNOLOGY</h2>
            <p>P.O. Box 57511 – 00200, Nairobi, Kenya</p>
            <div class="contact">
                Tel: +254 20 2729200 / 2729270 |
                Email: info@kihbt.ac.ke |
                Web: www.kihbt.ac.ke
            </div>
        </td>
        <td width="15%"></td>
    </tr>
</table>

<hr>

{{-- TITLE --}}
<div class="title">
    <h3>STUDENT NOMINAL ROLL</h3>
</div>

<table class="meta">
    <tr>
        <td width="50%">
            <strong>Course:</strong> {{ $course->course_name }}
            ({{ $course->course_code }})
        </td>
        <td width="50%">
            <strong>Cohort:</strong>
            {{ $cohort->intake_month }} {{ $cohort->intake_year }}
        </td>
    </tr>
</table>

{{-- STUDENT TABLE --}}
<table class="data">
    <thead>
    <tr>
        <th width="5%" class="text-center">#</th>
        <th width="35%">Full Name</th>
        <th width="20%">Admission No</th>
        <th width="20%">Phone</th>
        <th width="20%">Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $index => $student)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $student->full_name }}</td>
            <td>{{ $student->admission_no }}</td>
            <td>{{ $student->phone }}</td>
            <td>{{ $student->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    Generated on {{ now()->format('d M Y, H:i') }} | KIHBT MIS
</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 70px;
            margin-bottom: 5px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            margin-bottom: 2px;
        }

        .subtitle {
            font-size: 14px;
            color: #444;
            margin-bottom: 5px;
        }

        .generated {
            font-size: 11px;
            color: #555;
            margin-bottom: 10px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #777;
            padding: 6px 5px;
        }

        th {
            background: #003366;
            color: white;
            font-size: 12px;
            text-align: left;
        }

        tr:nth-child(even) {
            background: #f5f5f5;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .success {
            color: #0a7c0a;
            font-weight: bold;
        }

        .danger {
            color: #b30000;
            font-weight: bold;
        }

    </style>
</head>

<body>

<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">
    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
    <div class="subtitle">Short Course Revenue Report</div>
</div>

<div class="generated">
    Generated on: {{ now()->format('d M Y H:i') }}
</div>

<table>
    <thead>
    <tr>
        <th>Course</th>
        <th>Schedule</th>
        <th class="text-center">Participants</th>
        <th class="text-right">Expected Revenue</th>
        <th class="text-right">Paid</th>
        <th class="text-right">Pending</th>
        <th class="text-center">Paid %</th>
    </tr>
    </thead>

    <tbody>
    @foreach($summary as $row)
        <tr>
            <td>{{ $row['course'] }}</td>
            <td>{{ $row['start_date'] }} → {{ $row['end_date'] }}</td>

            <td class="text-center">
                {{ $row['participants'] }}
            </td>

            <td class="text-right">
                KSh {{ number_format($row['expected'], 2) }}
            </td>

            <td class="text-right success">
                KSh {{ number_format($row['paid'], 2) }}
            </td>

            <td class="text-right danger">
                KSh {{ number_format($row['pending'], 2) }}
            </td>

            <td class="text-center">
                {{ $row['payment_rate'] }}%
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

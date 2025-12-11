<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 70px;
            margin-bottom: 5px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            margin-bottom: 5px;
        }

        .sub-title {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .generated {
            font-size: 11px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #666;
        }

        th {
            background: #003366;
            color: #fff;
            padding: 6px;
            font-size: 12px;
        }

        td {
            padding: 5px;
            font-size: 11px;
        }

    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">
    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
    <div class="sub-title">Short Course – Participants Master Report</div>
    <div class="generated">Generated on: {{ now()->format('d M Y H:i') }}</div>
</div>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Participant</th>
        <th>ID No</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Training Schedule</th>
        <th>Course</th>
        <th>Financier</th>
        <th>Employer</th>
        <th>Payment Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach($participants as $index => $p)
        <tr>
            <td>{{ $index + 1 }}</td>

            <td>{{ $p->full_name }}</td>
            <td>{{ $p->id_no }}</td>
            <td>{{ $p->phone }}</td>
            <td>{{ $p->email ?? '-' }}</td>

            <td>
                {{ $p->application->training->start_date }}
                →
                {{ $p->application->training->end_date }}
            </td>

            <td>{{ $p->application->training->course->course_name }}</td>

            <td>{{ ucfirst($p->application->financier) }}</td>

            <td>{{ $p->application->employer_name ?? '-' }}</td>

            <td>
                @if(optional($p->application->invoice)->status === 'paid')
                    PAID
                @else
                    PENDING
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

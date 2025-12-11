<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #333; }
        th { background: #003366; color: white; padding:6px; }
        td { padding: 5px; }
        .title { text-align:center; font-size:18px; font-weight:bold; }
    </style>
</head>
<body>

<div class="title">Short Course Training Schedule Summary</div>
<small>Generated on: {{ now()->format('d M Y H:i') }}</small>

<table>
    <thead>
    <tr>
        <th>Course</th>
        <th>Schedule</th>
        <th>Applications</th>
        <th>Participants</th>
        <th>Self</th>
        <th>Employer</th>
        <th>Expected Revenue</th>
        <th>Paid</th>
        <th>Pending</th>
    </tr>
    </thead>

    <tbody>
    @foreach($summary as $row)
        <tr>
            <td>{{ $row['course_name'] }}</td>
            <td>{{ $row['start_date'] }} → {{ $row['end_date'] }}</td>
            <td>{{ $row['total_applications'] }}</td>
            <td>{{ $row['total_participants'] }}</td>
            <td>{{ $row['self_sponsored'] }}</td>
            <td>{{ $row['employer_sponsored'] }}</td>
            <td>KSh {{ number_format($row['expected_revenue'], 2) }}</td>
            <td>KSh {{ number_format($row['paid_revenue'], 2) }}</td>
            <td>KSh {{ number_format($row['pending_revenue'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

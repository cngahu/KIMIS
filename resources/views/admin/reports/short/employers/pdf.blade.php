<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; }
        th { background: #003366; color: #fff; }
        h3 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<h3>Short Course — Employer Sponsorship Report</h3>
<p>Generated: {{ now()->format('d M Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>Employer</th>
        <th>Contact</th>
        <th>Phone</th>
        <th>Applications</th>
        <th>Participants</th>
        <th>Expected Revenue</th>
        <th>Paid</th>
        <th>Pending</th>
    </tr>
    </thead>

    <tbody>
    @foreach($employers as $e)
        <tr>
            <td>{{ $e['employer_name'] }}</td>
            <td>{{ $e['contact_person'] }}</td>
            <td>{{ $e['phone'] }}</td>
            <td>{{ $e['applications'] }}</td>
            <td>{{ $e['participants'] }}</td>

            <td>{{ number_format($e['expected_revenue'], 2) }}</td>
            <td>{{ number_format($e['paid_revenue'], 2) }}</td>
            <td>{{ number_format($e['pending_revenue'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

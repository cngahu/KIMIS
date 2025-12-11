<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #333; }
        th { background: #003366; color: white; padding: 6px; }
        td { padding: 5px; }
        .title { text-align:center; font-size:18px; font-weight:bold; }
    </style>
</head>
<body>

<div class="title">Short Course Applications Report</div>
<small>Generated on: {{ now()->format('d M Y H:i') }}</small>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Training</th>
        <th>Financier</th>
        <th>Participants</th>
        <th>Total Amount</th>
        <th>Payment Status</th>
        <th>Date</th>
    </tr>
    </thead>

    <tbody>
    @foreach($data as $app)
        <tr>
            <td>{{ $app->id }}</td>
            <td>{{ optional($app->training->course)->course_name }}</td>
            <td>{{ ucfirst($app->financier) }}</td>
            <td>{{ $app->total_participants }}</td>
            <td>KSh {{ number_format($app->metadata['total_amount'] ?? 0, 2) }}</td>
            <td>{{ ucfirst($app->payment_status) }}</td>
            <td>{{ $app->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

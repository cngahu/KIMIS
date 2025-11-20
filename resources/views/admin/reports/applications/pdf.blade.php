<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 80px; }
        .title { font-size: 18px; font-weight: bold; color: #003366; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #666; }
        th { background: #003366; color: white; padding: 6px; }
        td { padding: 5px; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">
    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
    <h4>All Applications Report</h4>
    <small>Generated on: {{ now()->format('d M Y H:i') }}</small>
</div>

<table>
    <thead>
    <tr>
        <th>Ref</th>
        <th>Name</th>
        <th>Course</th>
        <th>Status</th>
        <th>Submitted</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $app)
        <tr>
            <td>{{ $app->reference }}</td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->course->course_name }}</td>
            <td>{{ ucfirst($app->status) }}</td>
            <td>{{ $app->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

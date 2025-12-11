<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        h3 { text-align: center; color: #003366; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #666; padding: 6px; }
        th { background: #003366; color:white; }
    </style>
</head>

<body>

<h3>Rejected Applications Report</h3>
<small>Generated on: {{ now()->format('d M Y H:i') }}</small>

<table>
    <thead>
    <tr>
        <th>Ref</th>
        <th>Applicant</th>
        <th>Course</th>
        <th>Reviewer</th>
        <th>Reason</th>
        <th>Date</th>
    </tr>
    </thead>

    <tbody>
    @foreach($applications as $app)
        <tr>
            <td>{{ $app->reference }}</td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->course->course_name }}</td>
            <td>{{ optional($app->reviewer)->name }}</td>
            <td>{{ $app->reviewer_comments }}</td>
            <td>{{ $app->updated_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

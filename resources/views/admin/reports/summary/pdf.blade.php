<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        h2, h3, h4 { color: #003366; text-align: center; margin: 5px 0; }
        .section-title { background: #003366; color: #fff; padding: 6px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background: #003366; color: white; }
    </style>
</head>

<body>

<!-- HEADER -->
<h2>KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</h2>
<h4>Applications Summary Report</h4>
<p style="text-align:center;">Generated on: {{ now()->format('d M Y H:i') }}</p>

<!-- STATUS SUMMARY -->
<div class="section-title">Application Status Summary</div>

<table>
    <thead>
    <tr>
        <th>Status</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Total Applications</td>
        <td>{{ $applications->count() }}</td>
    </tr>
    <tr>
        <td>Pending Payment</td>
        <td>{{ $statusCounts['pending_payment'] ?? 0 }}</td>
    </tr>
    <tr>
        <td>Submitted</td>
        <td>{{ $statusCounts['submitted'] ?? 0 }}</td>
    </tr>
    <tr>
        <td>Under Review</td>
        <td>{{ $statusCounts['under_review'] ?? 0 }}</td>
    </tr>
    <tr>
        <td>Approved</td>
        <td>{{ $statusCounts['approved'] ?? 0 }}</td>
    </tr>
    <tr>
        <td>Rejected</td>
        <td>{{ $statusCounts['rejected'] ?? 0 }}</td>
    </tr>
    </tbody>
</table>


<!-- FINANCIER SUMMARY -->
<div class="section-title">Financier Breakdown</div>

<table>
    <thead>
    <tr>
        <th>Financier</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($financiers as $type => $count)
        <tr>
            <td>{{ ucfirst($type) }}</td>
            <td>{{ $count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<!-- COURSE SUMMARY -->
<div class="section-title">Course Distribution</div>

<table>
    <thead>
    <tr>
        <th>Course</th>
        <th>Total Applicants</th>
    </tr>
    </thead>
    <tbody>
    @foreach($courseStats as $row)
        <tr>
            <td>{{ optional($row->course)->course_name }}</td>
            <td>{{ $row->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<!-- COUNTY SUMMARY -->
<div class="section-title">Home County Distribution</div>

<table>
    <thead>
    <tr>
        <th>County</th>
        <th>Total Applicants</th>
    </tr>
    </thead>
    <tbody>
    @foreach($homeCountyStats as $row)
        <tr>
            <td>{{ optional($row->homeCounty)->name }}</td>
            <td>{{ $row->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<!-- AGE GROUP SUMMARY -->
<div class="section-title">Age Group Distribution</div>

<table>
    <thead>
    <tr>
        <th>Age Range</th>
        <th>Total Applicants</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ageGroups as $range => $count)
        <tr>
            <td>{{ $range }}</td>
            <td>{{ $count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

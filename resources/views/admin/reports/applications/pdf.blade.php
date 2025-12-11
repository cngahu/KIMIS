{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <style>--}}
{{--        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }--}}
{{--        .header { text-align: center; margin-bottom: 20px; }--}}
{{--        .logo { width: 80px; }--}}
{{--        .title { font-size: 18px; font-weight: bold; color: #003366; }--}}
{{--        table { width: 100%; border-collapse: collapse; margin-top: 10px; }--}}
{{--        table, th, td { border: 1px solid #666; }--}}
{{--        th { background: #003366; color: white; padding: 6px; }--}}
{{--        td { padding: 5px; }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="header">--}}
{{--    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">--}}
{{--    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>--}}
{{--    <h4>All Applications Report</h4>--}}
{{--    <small>Generated on: {{ now()->format('d M Y H:i') }}</small>--}}
{{--</div>--}}

{{--<table>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <th>Ref</th>--}}
{{--        <th>Name</th>--}}
{{--        <th>Course</th>--}}
{{--        <th>Status</th>--}}
{{--        <th>Submitted</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @foreach($data as $app)--}}
{{--        <tr>--}}
{{--            <td>{{ $app->reference }}</td>--}}
{{--            <td>{{ $app->full_name }}</td>--}}
{{--            <td>{{ $app->course->course_name }}</td>--}}
{{--            <td>{{ ucfirst($app->status) }}</td>--}}
{{--            <td>{{ $app->created_at->format('d M Y') }}</td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--</body>--}}
{{--</html>--}}
    <!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 70px;
            margin-bottom: 5px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            color: #003366;
        }

        .subtitle {
            font-size: 13px;
            margin-top: -5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #555;
            padding: 5px 4px;
        }

        th {
            background: #003366;
            color: white;
            font-size: 11px;
        }

        td {
            font-size: 10.5px;
        }

        .small {
            font-size: 9px;
            color: #444;
        }

    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">
    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
    <div class="subtitle">All Long Course Applications Report</div>
    <small>Generated on: {{ now()->format('d M Y, H:i') }}</small>
</div>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Reference</th>
        <th>Applicant Name</th>
        <th>ID No</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Course</th>
        <th>Financier</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Home County</th>
        <th>Current County</th>
        <th>Subcounty</th>
        <th>Submitted On</th>
    </tr>
    </thead>

    <tbody>
    @foreach($data as $i => $app)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $app->reference }}</td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->id_number }}</td>
            <td>{{ $app->phone }}</td>
            <td>{{ $app->email }}</td>
            <td>{{ optional($app->course)->course_name }}</td>
            <td>{{ ucfirst($app->financier) }}</td>
            <td>{{ ucfirst($app->status) }}</td>
            <td>{{ ucfirst($app->payment_status) }}</td>
            <td>{{ optional($app->homeCounty)->name }}</td>
            <td>{{ optional($app->currentCounty)->name }}</td>
            <td>{{ optional($app->currentSubcounty)->name }}</td>
            <td>{{ $app->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p class="small">
    Total Records: {{ count($data) }}
</p>

</body>
</html>

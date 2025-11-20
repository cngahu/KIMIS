<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #eee; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" height="70"><br>
    <h3>FEE STRUCTURE – {{ $application->course->course_name }}</h3>
</div>

<p>Date: {{ now()->format('d M Y') }}</p>

<table>
    <thead>
    <tr>
        <th>Item</th>
        <th>Cost (KES)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Tuition Fees</td>
        <td>{{ number_format(25000) }}</td>
    </tr>
    <tr>
        <td>Registration Fee</td>
        <td>{{ number_format(1500) }}</td>
    </tr>
    <tr>
        <td>Student ID</td>
        <td>{{ number_format(500) }}</td>
    </tr>
    <tr>
        <td>Library & Activity Fee</td>
        <td>{{ number_format(2000) }}</td>
    </tr>
    <tr>
        <th>Total Payable</th>
        <th>{{ number_format(29000) }}</th>
    </tr>
    </tbody>
</table>

<p style="margin-top: 20px;">
    Please ensure all fees are paid before reporting. Payments should be made through the official KIHBT payment channels.
</p>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fee Statement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align:center; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { border:1px solid #ccc; padding:6px; }
        th { background:#f3f3f3; }
        .right { text-align:right; }
    </style>
</head>
<body>

<h2>KIHBT – Fee Statement</h2>

<p>
    <strong>Student:</strong> {{ $student->student_number }}<br>
    <strong>Name:</strong> {{ $student->user->firstname }}<br>
    <strong>Date Generated:</strong> {{ now()->format('d M Y') }}
</p>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th class="right">Debit</th>
        <th class="right">Credit</th>
        <th class="right">Balance</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            <td>{{ optional($row['date'])->format('d M Y') }}</td>
            <td>{{ $row['description'] }}</td>
            <td class="right">
                {{ $row['debit'] ? number_format($row['debit'], 2) : '' }}
            </td>
            <td class="right">
                {{ $row['credit'] ? number_format($row['credit'], 2) : '' }}
            </td>
            <td class="right">{{ number_format($row['balance'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p style="margin-top:20px;">
    <strong>Outstanding Balance:</strong>
    KES {{ number_format($outstanding_balance, 2) }}
</p>

</body>
</html>

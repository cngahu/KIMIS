<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 4px; }
        th { background: #003366; color: white; }
        h3 { text-align: center; margin-bottom: 10px; }
        .small { font-size: 10px; }
    </style>
</head>
<body>

<h3>Short Course — Participants Master Report</h3>
<p class="small">Generated: {{ now()->format('d M Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>ID</th>
        <th>Phone</th>
        <th>Email</th>

        <th>Course</th>
        <th>Schedule</th>
        <th>Financier</th>

        <th>Payment</th>
        <th>Invoice</th>
        <th>Amount</th>

        <th>Home County</th>
        <th>Current County</th>
        <th>Subcounty</th>

        <th>Postal Address</th>
    </tr>
    </thead>

    <tbody>
    @foreach($participants as $i => $p)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $p->full_name }}</td>
            <td>{{ $p->id_no }}</td>
            <td>{{ $p->phone }}</td>
            <td>{{ $p->email }}</td>

            <td>{{ $p->application?->training?->course?->course_name }}</td>
            <td>
                {{ $p->application?->training?->start_date }}
                →
                {{ $p->application?->training?->end_date }}
            </td>

            <td>{{ ucfirst($p->financier) }}</td>

            <td>{{ strtoupper($p->payment_status) }}</td>
            <td>{{ $p->invoice_number ?? '-' }}</td>
            <td>{{ number_format($p->payment_amount, 2) }}</td>

            <td>{{ $p->homeCounty?->name }}</td>
            <td>{{ $p->currentCounty?->name }}</td>
            <td>{{ $p->currentSubcounty?->name }}</td>

            <td>{{ $p->postal_address }} ({{ $p->postalCode?->code }})</td>
        </tr>
    @endforeach
    </tbody>

</table>

</body>
</html>

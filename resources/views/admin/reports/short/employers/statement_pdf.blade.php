<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 90px;
            margin-bottom: 8px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #0a3d62;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 8px;
            color: #0a3d62;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background: #0a3d62;
            color: #fff;
            padding: 6px;
            font-size: 12px;
            border: 1px solid #555;
        }

        td {
            padding: 6px;
            border: 1px solid #aaa;
            font-size: 12px;
        }

        .totals-row td {
            font-weight: bold;
            background: #f0f0f0;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-success { color: green; font-weight: bold; }
        .text-danger { color: red; font-weight: bold; }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 30px;
            color: #777;
        }

    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" class="logo">
    <div class="title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
    <div class="subtitle">Employer Training Account Statement</div>
    <div>
        <small>Generated on: {{ now()->format('d M Y H:i') }}</small>
    </div>
</div>

<!-- EMPLOYER DETAILS -->
<div class="section-title">Employer Information</div>

<table>
    <tr>
        <td width="30%"><strong>Employer Name:</strong></td>
        <td>{{ $statement['employer_name'] }}</td>
    </tr>
    <tr>
        <td><strong>Contact Person:</strong></td>
        <td>{{ $statement['contact_person'] }}</td>
    </tr>
    <tr>
        <td><strong>Email:</strong></td>
        <td>{{ $statement['email'] }}</td>
    </tr>
    <tr>
        <td><strong>Phone:</strong></td>
        <td>{{ $statement['phone'] }}</td>
    </tr>
    <tr>
        <td><strong>Postal Address:</strong></td>
        <td>{{ $statement['address'] }}, {{ $statement['town'] }}, {{ $statement['county'] }}</td>
    </tr>
</table>


<!-- TRAININGS SUMMARY -->
<div class="section-title">Training & Payment Summary</div>

<table>
    <thead>
    <tr>
        <th>Training</th>
        <th>Schedule</th>
        <th>Participants</th>
        <th>Invoice No.</th>
        <th>Amount</th>
        <th>Paid</th>
        <th>Balance</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach($statement['trainings'] as $row)
        <tr>
            <td>{{ $row['course_name'] }}</td>

            <td>
                {{ $row['start_date'] }} → {{ $row['end_date'] }}
            </td>

            <td class="text-center">{{ $row['participants_count'] }}</td>

            <td class="text-center">
                {{ $row['invoice_number'] ?? '-' }}
            </td>

            <td class="text-right">
                KSh {{ number_format($row['amount'], 2) }}
            </td>

            <td class="text-right text-success">
                KSh {{ number_format($row['paid'], 2) }}
            </td>

            <td class="text-right text-danger">
                KSh {{ number_format($row['balance'], 2) }}
            </td>

            <td class="text-center">
                {{ ucfirst($row['status']) }}
            </td>
        </tr>

        <!-- Participant List -->
        <tr>
            <td colspan="8">
                <strong>Participants:</strong><br>

                <table style="width: 95%; margin: 8px auto;">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID No</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($row['participants'] as $p)
                        <tr>
                            <td>{{ $p->full_name }}</td>
                            <td>{{ $p->id_no }}</td>
                            <td>{{ $p->phone }}</td>
                            <td>{{ $p->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </td>
        </tr>
    @endforeach
    </tbody>

    <tfoot>
    <tr class="totals-row">
        <td colspan="4" class="text-right">TOTALS</td>

        <td class="text-right">
            KSh {{ number_format($statement['totals']['expected'], 2) }}
        </td>

        <td class="text-right text-success">
            KSh {{ number_format($statement['totals']['paid'], 2) }}
        </td>

        <td class="text-right text-danger">
            KSh {{ number_format($statement['totals']['pending'], 2) }}
        </td>

        <td></td>
    </tr>
    </tfoot>

</table>


<!-- FOOTER -->
<div class="footer">
    This statement is system-generated and does not require a signature.
    <br>For assistance, contact KIHBT Accounts Office.
</div>

</body>
</html>

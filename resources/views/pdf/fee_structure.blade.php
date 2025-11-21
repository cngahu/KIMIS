<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            line-height: 1.4;
            color: #000;
            margin: 25px 35px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            color: #0033A1; /* Deep blue like PDF */
        }

        .coat {
            text-align: center;
            margin-bottom: 5px;
        }

        .coat img {
            height: 75px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            background: #f5f5f5;
        }

        td {
            padding: 4px 6px;
            font-size: 12px;
            text-align: center;
        }

        .left {
            text-align: left;
        }

        a {
            color: #0033A1;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="coat">
    <img src="{{ public_path('upload/admin_images/coat.png') }}" alt="Coat of Arms">
</div>

<div class="title">
    REPUBLIC OF KENYA<br><br>
    KENYA INSTITUTE OF HIGHWAYS AND BUILDING TECHNOLOGY<br>
    2024 FRESHERS’ INTAKE FEES STRUCTURE<br>
    TERMLY DISTRIBUTION<br>
    YEAR 1
</div>

<table>
    <thead>
    <tr>
        <th>S/N</th>
        <th>CLASS</th>
        <th>TERM 1</th>
        <th>TERM 2</th>
        <th>TERM 3</th>
        <th>TOTAL</th>
    </tr>
    </thead>

    <tbody>

    @php
        $rows = [
            ['DLS', 30210, 25210, 5000, 60420],
            ['DHE', 30210, 25210, 5000, 60420],
            ['DQS', 30210, 25210, 5000, 60420],
            ['DCE', 32210, 27210, 5000, 64420],
            ['ARCH',32210, 27210, 5000, 64420],
            ['BLD', 32210, 27210, 5000, 64420],
            ['DEP', 32210, 27210, 5000, 64420],
            ['MEA', 32210, 27210, 5000, 64420],
            ['MEC', 32210, 27210, 5000, 64420],
            ['MEI', 32210, 27210, 5000, 64420],
            ['ICT', 32210, 27210, 5000, 64420],
            ['MVMC',31710, 26710, 5000, 63420],
            ['BLDC',31710, 26710, 5000, 63420],
            ['ELIC',31710, 26710, 5000, 63420],
            ['PLMC',29710, 24710, 5000, 59420],
            ['CCRC',29710, 24710, 5000, 59420],
            ['HBCE',39650, 29000, 0,     68650],
            ['CPM', 28420, 22500, 'ATTACHMENT', 50920],
            ['PPF', 28420, 22500, 'ATTACHMENT', 50920],
            ['RAC', 28420, 22500, 'ATTACHMENT', 50920],
        ];
    @endphp

    @foreach($rows as $index => $row)
        <tr>
            <td><a href="#">{{ $index+1 }}</a></td>
            <td class="left">{{ $row[0] }}</td>
            <td>{{ is_numeric($row[1]) ? number_format($row[1]) : $row[1] }}</td>
            <td>{{ is_numeric($row[2]) ? number_format($row[2]) : $row[2] }}</td>
            <td>{{ is_numeric($row[3]) ? number_format($row[3]) : $row[3] }}</td>
            <td>{{ number_format($row[4]) }}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>

{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <title>Academic Timeline – Global</title>--}}

{{--    <style>--}}
{{--        body {--}}
{{--            font-family: DejaVu Sans;--}}
{{--            font-size: 10px;--}}
{{--        }--}}

{{--        h3 {--}}
{{--            margin-bottom: 5px;--}}
{{--        }--}}

{{--        table {--}}
{{--            width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--        }--}}

{{--        th, td {--}}
{{--            border: 1px solid #999;--}}
{{--            padding: 5px;--}}
{{--            text-align: center;--}}
{{--            white-space: nowrap;--}}
{{--        }--}}

{{--        th {--}}
{{--            background-color: #2c3e50;--}}
{{--            color: #ffffff;--}}
{{--        }--}}

{{--        .academic {--}}
{{--            background-color: #d9ecff;--}}
{{--        }--}}

{{--        .vacation {--}}
{{--            background-color: #eeeeee;--}}
{{--        }--}}

{{--        .attachment {--}}
{{--            background-color: #ffe5cc;--}}
{{--        }--}}

{{--        .internship {--}}
{{--            background-color: #eadcff;--}}
{{--        }--}}

{{--        .empty {--}}
{{--            color: #999999;--}}
{{--        }--}}

{{--        .campus-title {--}}
{{--            margin-top: 20px;--}}
{{--            margin-bottom: 5px;--}}
{{--            font-weight: bold;--}}
{{--            font-size: 13px;--}}
{{--        }--}}

{{--        .no-timeline {--}}
{{--            color: #c0392b;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}

{{--<body>--}}

{{--<h3>Academic Progression – All Campuses</h3>--}}
{{--<p>Generated on: {{ now()->format('d M Y') }}</p>--}}

{{--@foreach($matrix['groups'] as $campus => $rows)--}}

{{--    <div class="campus-title">{{ $campus }}</div>--}}

{{--    <table>--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Course / Intake</th>--}}
{{--            @foreach($matrix['columns'] as $col)--}}
{{--                <th>--}}
{{--                    {{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}--}}
{{--                </th>--}}
{{--            @endforeach--}}
{{--        </tr>--}}
{{--        </thead>--}}

{{--        <tbody>--}}
{{--        @foreach($rows as $row)--}}
{{--            <tr>--}}
{{--                <th style="text-align:left;">--}}
{{--                    {{ $row['label'] }}--}}

{{--                    @if(!$row['has_timeline'])--}}
{{--                        <span class="no-timeline">--}}
{{--                            (Timeline not provided)--}}
{{--                        </span>--}}
{{--                    @endif--}}
{{--                </th>--}}

{{--                @foreach($matrix['columns'] as $col)--}}
{{--                    @php--}}
{{--                        $cell = $row['cells'][$col] ?? null;--}}
{{--                    @endphp--}}

{{--                    <td class="{{ $cell['type'] ?? 'empty' }}">--}}
{{--                        {{ $cell['code'] ?? '' }}--}}
{{--                    </td>--}}
{{--                @endforeach--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--@endforeach--}}

{{--</body>--}}
{{--</html>--}}
{{--    <!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <title>Academic Timeline – Global</title>--}}

{{--    <style>--}}
{{--        body {--}}
{{--            font-family: DejaVu Sans;--}}
{{--            font-size: 10px;--}}
{{--        }--}}

{{--        h3 {--}}
{{--            margin-bottom: 5px;--}}
{{--        }--}}

{{--        table {--}}
{{--            width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--        }--}}

{{--        th, td {--}}
{{--            border: 1px solid #999;--}}
{{--            padding: 5px;--}}
{{--            text-align: center;--}}
{{--            white-space: nowrap;--}}
{{--        }--}}

{{--        th {--}}
{{--            background-color: #2c3e50;--}}
{{--            color: #ffffff;--}}
{{--        }--}}

{{--        .academic {--}}
{{--            background-color: #d9ecff;--}}
{{--        }--}}

{{--        .vacation {--}}
{{--            background-color: #eeeeee;--}}
{{--        }--}}

{{--        .attachment {--}}
{{--            background-color: #ffe5cc;--}}
{{--        }--}}

{{--        .internship {--}}
{{--            background-color: #eadcff;--}}
{{--        }--}}

{{--        .empty {--}}
{{--            color: #999999;--}}
{{--        }--}}

{{--        .campus-title {--}}
{{--            margin-top: 20px;--}}
{{--            margin-bottom: 5px;--}}
{{--            font-weight: bold;--}}
{{--            font-size: 13px;--}}
{{--        }--}}

{{--        .no-timeline {--}}
{{--            color: #c0392b;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}

{{--<body>--}}

{{--<h3>Academic Progression – All Campuses</h3>--}}
{{--<p>Generated on: {{ now()->format('d M Y') }}</p>--}}

{{--@foreach($matrix['groups'] as $campus => $intakes)--}}

{{--    <div class="campus-title">{{ $campus }}</div>--}}

{{--    @foreach($intakes as $intake => $rows)--}}

{{--        <table>--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Course Code</th>--}}
{{--                @foreach($matrix['columns'] as $col)--}}
{{--                    <th>--}}
{{--                        {{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}--}}
{{--                    </th>--}}
{{--                @endforeach--}}
{{--            </tr>--}}
{{--            </thead>--}}

{{--            <tbody>--}}
{{--            @foreach($rows as $row)--}}
{{--                <tr>--}}
{{--                    <th style="text-align:left;">--}}
{{--                        {{ $row['code'] ?? $row['label'] }}--}}

{{--                        @if(!$row['has_timeline'])--}}
{{--                            <span class="no-timeline">--}}
{{--                                (Timeline not provided)--}}
{{--                            </span>--}}
{{--                        @endif--}}
{{--                    </th>--}}

{{--                    @foreach($matrix['columns'] as $col)--}}
{{--                        @php--}}
{{--                            $cell = $row['cells'][$col] ?? null;--}}
{{--                        @endphp--}}

{{--                        <td class="{{ $cell['type'] ?? 'empty' }}">--}}
{{--                            {{ $cell['code'] ?? '' }}--}}
{{--                        </td>--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}

{{--    @endforeach--}}

{{--@endforeach--}}

{{--</body>--}}
{{--</html>--}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Academic Timeline – Global</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 10px;
        }

        h3 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 5px;
            text-align: center;
            white-space: nowrap;
        }

        th {
            background-color: #2c3e50;
            color: #ffffff;
        }

        .academic {
            background-color: #d9ecff;
        }

        .vacation {
            background-color: #eeeeee;
        }

        .attachment {
            background-color: #ffe5cc;
        }

        .internship {
            background-color: #eadcff;
        }

        .empty {
            color: #999999;
        }

        .campus-title {
            margin-top: 20px;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 13px;
        }

        .intake-title {
            margin: 8px 0 4px;
            font-weight: bold;
            font-size: 11px;
        }

        .no-timeline {
            color: #c0392b;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h3>Academic Progression – All Campuses</h3>
<p>Generated on: {{ now()->format('d M Y') }}</p>

@foreach($matrix['groups'] as $campus => $intakes)

    <div class="campus-title">{{ $campus }}</div>

    @foreach($intakes as $intake => $rows)

        {{-- Intake clearly identified once --}}
        <div class="intake-title">
            Intake: {{ \Carbon\Carbon::createFromFormat('Y-m', $intake)->format('F Y') }}
        </div>

        <table>
            <thead>
            <tr>
                <th>Course Code</th>
                @foreach($matrix['columns'] as $col)
                    <th>
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}
                    </th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @foreach($rows as $row)
                <tr>
                    <th style="text-align:left;">
                        {{ $row['code'] ?? $row['label'] }}

                        @if(!$row['has_timeline'])
                            <span class="no-timeline">
                                (Timeline not provided)
                            </span>
                        @endif
                    </th>

                    @foreach($matrix['columns'] as $col)
                        @php
                            $cell = $row['cells'][$col] ?? null;
                        @endphp

                        <td class="{{ $cell['type'] ?? 'empty' }}">
                            {{ $cell['code'] ?? '' }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

    @endforeach

@endforeach

</body>
</html>

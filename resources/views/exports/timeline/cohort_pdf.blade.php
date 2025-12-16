<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px; text-align: center; }
        th { background: #2c3e50; color: #fff; }

        .academic { background: #d9ecff; }
        .vacation { background: #eeeeee; }
        .attachment { background: #ffe5cc; }
        .internship { background: #eadcff; }
        .empty { color: #999; }
    </style>
</head>
<body>

<h3>{{ $cohort->course->course_name }} – Academic Timeline</h3>
<p>
    Intake:
    {{ \Carbon\Carbon::create($cohort->intake_year, $cohort->intake_month)->format('M Y') }}
</p>


{{--<a href="{{ route('timeline.cohort.excel', $cohort) }}" class="btn btn-success btn-sm">--}}
{{--    <i class="fas fa-file-excel"></i> Excel--}}
{{--</a>--}}

@if(!$matrix['has_timeline'])
    <p style="color:red;">Timeline not provided.</p>
@else
    <table>
        <thead>
        <tr>
            <th>Course / Intake</th>
            @foreach($matrix['columns'] as $col)
                <th>{{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}</th>
            @endforeach
        </tr>
        </thead>

        <tbody>
        @foreach($matrix['rows'] as $row)
            <tr>
                <th>{{ $row['label'] }}</th>
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
@endif

</body>
</html>

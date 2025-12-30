@extends('admin.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <h5 class="mb-3">Academic Progression – All Campuses</h5>
        <a href="{{ route('timeline.global.pdf') }}" class="btn btn-danger">
            Download PDF
        </a>

{{--        <a href="{{ route('timeline.global.excel') }}" class="btn btn-success">--}}
{{--            Download Excel--}}
{{--        </a>--}}

{{--        @foreach($matrix['groups'] as $campus => $rows)--}}

{{--            <h6 class="mt-4">{{ $campus }}</h6>--}}

{{--            <div class="table-responsive mb-4">--}}
{{--                <table class="table table-bordered text-center">--}}
{{--                    <thead class="table-dark">--}}
{{--                    <tr>--}}
{{--                        <th>Course / Intake</th>--}}
{{--                        @foreach($matrix['columns'] as $col)--}}
{{--                            <th>{{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}</th>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
{{--                    </thead>--}}

{{--                    <tbody>--}}
{{--                    @foreach($rows as $row)--}}
{{--                        <tr>--}}
{{--                            <th class="text-start">--}}
{{--                                {{ $row['label'] }}--}}
{{--                                @if(!$row['has_timeline'])--}}
{{--                                    <span class="badge bg-danger ms-2">Timeline not provided</span>--}}
{{--                                @endif--}}
{{--                            </th>--}}

{{--                            @foreach($matrix['columns'] as $col)--}}
{{--                                <td>--}}
{{--                                    {{ $row['cells'][$col]['code'] ?? '' }}--}}
{{--                                </td>--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--        @endforeach--}}
        @foreach($matrix['groups'] as $campus => $intakes)

            <h5 class="mt-4">{{ $campus }}</h5>

            @foreach($intakes as $intake => $rows)

                <h6 class="mt-3 text-primary">
                    Intake: {{ \Carbon\Carbon::createFromFormat('Y-m', $intake)->format('M Y') }}
                </h6>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>Course</th>
                            @foreach($matrix['columns'] as $col)
                                <th>{{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}</th>
                            @endforeach
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <th class="text-start">
                                    {{ $row['label'] }}
                                    @if(!$row['has_timeline'])
                                        <span class="badge bg-danger ms-2">
                                    Timeline not provided
                                </span>
                                    @endif
                                </th>

                                @foreach($matrix['columns'] as $col)
                                    <td>
                                        {{ $row['cells'][$col]['code'] ?? '' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @endforeach

        @endforeach

    </div>
@endsection

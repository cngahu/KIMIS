{{--@extends('admin.registrar.applications.layout')--}}

{{--@section('registrar-content')--}}

{{--    <div class="card shadow-sm">--}}
{{--        <div class="card-body">--}}

{{--            <h5 class="mb-3">Assigned Applications (Under Review)</h5>--}}

{{--            <table class="table table-striped">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>Reference</th>--}}
{{--                    <th>Applicant</th>--}}
{{--                    <th>Course</th>--}}
{{--                    <th>Reviewer</th>--}}
{{--                    <th>Assigned On</th>--}}
{{--                    <th>View</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}

{{--                <tbody>--}}
{{--                @foreach($apps as $app)--}}
{{--                    <tr>--}}
{{--                        <td>{{ $app->reference }}</td>--}}
{{--                        <td>{{ $app->full_name }}</td>--}}
{{--                        <td>{{ $app->course->course_name }}</td>--}}
{{--                        <td>{{ $app->reviewer->surname }} {{ $app->reviewer->firstname }}</td>--}}
{{--                        <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>--}}

{{--                        <td>--}}
{{--                            <button class="btn btn-secondary btn-sm"--}}
{{--                                    data-bs-toggle="modal"--}}
{{--                                    data-bs-target="#viewApplicationModal"--}}
{{--                                    onclick="loadApplication({{ $app->id }})">--}}
{{--                                View--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}

{{--            {{ $apps->links() }}--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    @include('admin.registrar.applications.modal')--}}

{{--@endsection--}}
@extends('admin.registrar.applications.layout')

@section('registrar-content')

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Assigned Applications (Under Review)</h5>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Applicant</th>
                    <th>Course</th>
                    <th>Reviewer</th>
                    <th>Assigned On</th>
                    <th>View</th>
                </tr>
                </thead>

                <tbody>
                @foreach($apps as $app)
                    <tr>
                        <td>{{ $app->reference }}</td>
                        <td>{{ $app->full_name }}</td>
                        <td>{{ $app->course->course_name }}</td>
                        <td>{{ $app->reviewer->surname }} {{ $app->reviewer->firstname }}</td>
                        <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>

                        <td>
                            <button class="btn btn-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewApplicationModal"
                                    onclick="loadApplication({{ $app->id }})">
                                View
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $apps->links() }}

        </div>
    </div>

    @include('admin.registrar.applications.modal')

@endsection

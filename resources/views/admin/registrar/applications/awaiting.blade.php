@extends('admin.registrar.applications.layout')

@section('registrar-content')

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Applications Awaiting Assignment</h5>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Applicant</th>
                    <th>Course</th>
                    <th>Submitted</th>
                    <th>View</th>
                    <th>Assign</th>
                </tr>
                </thead>

                <tbody>
                @foreach($apps as $app)
                    <tr>
                        <td>{{ $app->reference }}</td>
                        <td>{{ $app->full_name }}</td>
                        <td>{{ $app->course->course_name }}</td>
                        <td>{{ $app->created_at->format('d M Y') }}</td>

                        <td>
                            <button class="btn btn-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewApplicationModal"
                                    onclick="loadApplication({{ $app->id }})">
                                View
                            </button>
                        </td>

                        <td>
                            <form action="{{ route('registrar.assign', $app->id) }}" method="POST">
                                @csrf
                                <div class="d-flex">
                                    <select name="reviewer_id" class="form-select form-select-sm" required>
                                        <option value="">Select Officer</option>
                                        @foreach($officers as $off)
                                            <option value="{{ $off->id }}">
                                                {{ $off->surname }} {{ $off->firstname }} {{ $off->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary btn-sm ms-2">Assign</button>
                                </div>
                            </form>
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

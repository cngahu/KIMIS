@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Received Applications</h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>Applicant</th>
                        <th>Course</th>
                        <th>Date Submitted</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Reviewer</th>
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
                                <span class="badge bg-info">{{ ucfirst($app->status) }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewApplicationModal"
                                        onclick="loadApplication({{ $app->id }})">
                                    View
                                </button>
                            </td>

                            <td>
                                {{ $app->reviewer ? $app->reviewer->name : 'Unassigned' }}
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

                <div class="mt-3">
                    {{ $apps->links() }}
                </div>

            </div>
        </div>
        <div class="modal fade" id="viewApplicationModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header" style="background:#003366; color:white;">
                        <h5 class="modal-title">Application Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="viewApplicationBody">
                        <!-- AJAX-loaded content goes here -->
                    </div>

                </div>
            </div>
        </div>

    </div>
    <script>
        function loadApplication(id) {
            $('#viewApplicationBody').html('<p class="text-center p-4">Loading...</p>');

            $.get('/admin/registrar/applications/' + id, function (html) {
                $('#viewApplicationBody').html(html);
            });
        }
    </script>

@endsection

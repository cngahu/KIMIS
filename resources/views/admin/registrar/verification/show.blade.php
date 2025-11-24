@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-3">Verify Student Documents</h4>

        {{-- BASIC BIO DETAILS --}}
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">Applicant Details</div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $application->full_name }}</p>
                <p><strong>ID No:</strong> {{ $application->id_number }}</p>
                <p><strong>Course:</strong> {{ $application->course->course_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $application->date_of_birth }}</p>
            </div>
        </div>

        {{-- ADMISSION PROFILE --}}
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Admission Profile</div>
            <div class="card-body">
                <p><strong>Parent Name:</strong> {{ $admission->details->parent_name }}</p>
                <p><strong>Next of Kin:</strong> {{ $admission->details->next_of_kin }}</p>
                <p><strong>Address:</strong> {{ $admission->details->address }}</p>
            </div>
        </div>

        {{-- DOCUMENT CHECKLIST --}}
        {{-- DOCUMENT CHECKLIST --}}
        <div class="card mb-3">
            <div class="card-header bg-warning fw-bold">Document Checklist</div>

            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Required Document</th>
                        <th>Uploaded File</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($requirements as $req)
                        @php
                            // Find uploaded file for this requirement
                            $uploaded = $documents->firstWhere('document_type_id', $req->id);
                        @endphp

                        <tr>
                            <td>
                                <strong>{{ $req->name }}</strong><br>
                                <small class="text-muted">{{ $req->description }}</small>
                            </td>

                            <td>
                                @if($uploaded)
                                    <a href="{{ asset('storage/'.$uploaded->file_path) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-secondary">
                                        View File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Missing</span>
                                @endif
                            </td>

                            <td>
                                @if($uploaded)
                                    <span class="badge bg-success">Uploaded</span>
                                @else
                                    <span class="badge bg-danger">Not Uploaded</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>

        {{-- FINAL ACTIONS --}}
        <div class="card p-3">
            <div class="d-flex gap-3">

                <form action="{{ route('registrar.verification.approve', $admission->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">Approve Documents</button>
                </form>

                <form action="{{ route('registrar.verification.reject', $admission->id) }}" method="POST">
                    @csrf
                    <input type="text" name="reason" class="form-control mb-2"
                           placeholder="Reason for rejection" required>
                    <button class="btn btn-danger">Reject</button>
                </form>

            </div>
        </div>

    </div>

@endsection

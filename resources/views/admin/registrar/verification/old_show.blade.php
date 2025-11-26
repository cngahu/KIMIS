@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .section-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 2px solid #dedede;
        }
        .profile-row label {
            font-weight: 600;
            color: #555;
        }
        .profile-row p {
            margin-bottom: 6px;
            font-size: .95rem;
        }
    </style>

    @php
        // Detect passport photo
        $passportReq = $requirements->firstWhere('name', 'Passport Photo');
        $passportPhoto = $passportReq
           ? $documents->firstWhere('document_type_id', $passportReq->id)
           : null;
    @endphp

    <div class="page-content">

        <h4 class="fw-bold mb-3">Student Admission Verification</h4>

        {{-- HEADER WITH PASSPORT PHOTO --}}
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center">

                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ $application->full_name }}</h5>
                    <p class="mb-0 text-muted">
                        Application Ref:
                        <strong>{{ $application->reference }}</strong> |
                        Course:
                        <strong>{{ $application->course->course_name }}</strong>
                    </p>
                </div>

                {{-- Passport Photo --}}
                <div style="width:110px; height:110px; margin-left:20px;">
                    @if($passportPhoto)
                        <img src="{{ asset('storage/' . $passportPhoto->file_path) }}"
                             class="rounded-circle border"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center"
                             style="width:100%; height:100%; font-size:12px; color:#888;">
                            No Photo
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- TABS --}}
        <ul class="nav nav-tabs mb-3" id="verifyTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#applicationData">
                    Application Data
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#admissionDetails">
                    Admission Form
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#uploadedDocs">
                    Uploaded Documents
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- TAB 1: APPLICATION DATA --}}
            <div class="tab-pane fade show active" id="applicationData">

                <div class="card mb-3">
                    <div class="card-body">

                        <h6 class="section-title">Applicant Personal Information</h6>

                        <div class="row profile-row">
                            <div class="col-md-4">
                                <label>Full Name</label>
                                <p>{{ $application->full_name }}</p>

                                <label>ID Number</label>
                                <p>{{ $application->id_number }}</p>

                                <label>Gender</label>
                                <p>{{ $application->gender }}</p>
                            </div>

                            <div class="col-md-4">
                                <label>Email</label>
                                <p>{{ $application->email }}</p>

                                <label>Phone</label>
                                <p>{{ $application->phone }}</p>

                                <label>Date of Birth</label>
                                <p>{{ $application->date_of_birth }}</p>
                            </div>

                            <div class="col-md-4">
                                <label>Home County</label>
                                <p>{{ optional($application->homeCounty)->name }}</p>

                                <label>Current County</label>
                                <p>{{ optional($application->currentCounty)->name }}</p>

                                <label>Current Subcounty</label>
                                <p>{{ optional($application->currentSubcounty)->name }}</p>
                            </div>
                        </div>

                        <h6 class="section-title mt-4">Address</h6>

                        <div class="row profile-row">
                            <div class="col-md-4">
                                <label>Postal Address</label>
                                <p>{{ $application->postal_address }}</p>
                            </div>
                            <div class="col-md-4">
                                <label>Town</label>
                                <p>{{ $application->town }}</p>
                            </div>
                            <div class="col-md-4">
                                <label>Postal Code</label>
                                <p>{{ optional($application->postalCode)->code }}</p>
                            </div>
                        </div>

                        <h6 class="section-title mt-4">KCSE Information</h6>

                        <div class="row profile-row">
                            <div class="col-md-4">
                                <label>Mean Grade</label>
                                <p>{{ $application->kcse_mean_grade }}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- TAB 2: ADMISSION FORM --}}
            <div class="tab-pane fade" id="admissionDetails">

                <div class="card mb-3">
                    <div class="card-body">

                        @if(!$admission->details)
                            <div class="alert alert-warning">Student has not yet filled admission form.</div>
                        @else

                            {{-- Parent --}}
                            <h6 class="section-title">Parent / Guardian Information</h6>

                            <div class="row profile-row">
                                <div class="col-md-4"><label>Name</label><p>{{ $admission->details->parent_name }}</p></div>
                                <div class="col-md-4"><label>Phone</label><p>{{ $admission->details->parent_phone }}</p></div>
                                <div class="col-md-4"><label>Email</label><p>{{ $admission->details->parent_email }}</p></div>
                            </div>

                            <div class="row profile-row">
                                <div class="col-md-4"><label>ID Number</label><p>{{ $admission->details->parent_id_number }}</p></div>
                                <div class="col-md-4"><label>Relationship</label><p>{{ $admission->details->parent_relationship }}</p></div>
                                <div class="col-md-4"><label>Occupation</label><p>{{ $admission->details->parent_occupation }}</p></div>
                            </div>

                            {{-- NOK --}}
                            <h6 class="section-title mt-4">Next of Kin</h6>

                            <div class="row profile-row">
                                <div class="col-md-4"><label>Name</label><p>{{ $admission->details->nok_name }}</p></div>
                                <div class="col-md-4"><label>Phone</label><p>{{ $admission->details->nok_phone }}</p></div>
                                <div class="col-md-4"><label>Relationship</label><p>{{ $admission->details->nok_relationship }}</p></div>
                            </div>

                            {{-- Emergency --}}
                            <h6 class="section-title mt-4">Emergency Contact</h6>

                            <div class="row profile-row">
                                <div class="col-md-4"><label>Name</label><p>{{ $admission->details->emergency_name }}</p></div>
                                <div class="col-md-4"><label>Phone</label><p>{{ $admission->details->emergency_phone }}</p></div>
                            </div>

                            {{-- Medical --}}
                            <h6 class="section-title mt-4">Medical Information</h6>

                            <div class="row profile-row">
                                <div class="col-md-4"><label>Disability</label><p>{{ $admission->details->disability_status }}</p></div>
                                <div class="col-md-4"><label>Chronic Illness</label><p>{{ $admission->details->chronic_illness }}</p></div>
                                <div class="col-md-4"><label>Allergies</label><p>{{ $admission->details->allergies }}</p></div>
                            </div>

                        @endif

                    </div>
                </div>

            </div>

            {{-- TAB 3: DOCUMENT VERIFICATION --}}
            <div class="tab-pane fade" id="uploadedDocs">

                <form action="{{ route('registrar.verify.documents', $admission->id) }}" method="POST">
                    @csrf

                    <div class="card">
                        <div class="card-body">

                            <h6 class="section-title">Uploaded Documents</h6>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>File</th>
                                    <th>Verify</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($requirements as $req)
                                    @php
                                        $uploaded = $documents->firstWhere('document_type_id', $req->id);
                                    @endphp

                                    <div class="d-flex justify-content-between align-items-start border rounded p-3 mb-3">

                                        {{-- Requirement info --}}
                                        <div style="width: 30%">
                                            <strong>{{ $req->name }}</strong><br>
                                            <small class="text-muted">{{ $req->description }}</small>
                                        </div>

                                        {{-- File + Status --}}
                                        <div style="width: 30%">
                                            @if($uploaded)

                                                {{-- MODAL TRIGGER --}}
                                                <button class="btn btn-sm btn-outline-primary mb-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#docModal{{ $uploaded->id }}">
                                                    View File
                                                </button>

                                                {{-- STATUS BADGE --}}
                                                <br>
                                                <span class="badge
                    @if($uploaded->verified_status=='approved') bg-success
                    @elseif($uploaded->verified_status=='pending_fix') bg-warning text-dark
                    @elseif($uploaded->verified_status=='rejected') bg-danger
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($uploaded->verified_status) }}
                </span>

                                                {{-- MODAL --}}
                                                <div class="modal fade" id="docModal{{ $uploaded->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $req->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <iframe src="{{ asset('storage/'.$uploaded->file_path) }}"
                                                                        width="100%"
                                                                        height="600px"
                                                                        style="border: none;">
                                                                </iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <span class="badge bg-danger">Missing</span>
                                            @endif
                                        </div>

                                        {{-- Verification Panel --}}
                                        <div style="width: 35%">
                                            @if($uploaded)
                                                <form method="POST" action="{{ route('admin.verify.document', $admission->id) }}">
                                                    @csrf

                                                    <input type="hidden" name="doc_id" value="{{ $uploaded->id }}">

                                                    {{-- Action Select --}}
                                                    <select name="action" class="form-select form-select-sm mb-1" required>
                                                        <option value="approved"
                                                            {{ $uploaded->verified_status=='approved' ? 'selected' : '' }}>
                                                            Approve
                                                        </option>

                                                        <option value="pending_fix"
                                                            {{ $uploaded->verified_status=='pending_fix' ? 'selected' : '' }}>
                                                            Approve with Fix Needed
                                                        </option>

                                                        <option value="rejected"
                                                            {{ $uploaded->verified_status=='rejected' ? 'selected' : '' }}>
                                                            Reject
                                                        </option>
                                                    </select>

                                                    {{-- Comment --}}
                                                    <input
                                                        name="comment"
                                                        class="form-control form-control-sm mb-1"
                                                        placeholder="Comment (optional)"
                                                        value="{{ $uploaded->comment ?? '' }}"
                                                    >

                                                    <button class="btn btn-sm btn-primary">Save</button>
                                                </form>
                                            @else
                                                <span class="text-muted">No actions available</span>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach

                                {{--                                @foreach($requirements as $req)--}}
                                {{--                                    @php--}}
                                {{--                                        $uploaded = $documents->firstWhere('document_type_id', $req->id);--}}
                                {{--                                    @endphp--}}

                                {{--                                    <tr>--}}
                                {{--                                        <td>--}}
                                {{--                                            <strong>{{ $req->name }}</strong><br>--}}
                                {{--                                            <small class="text-muted">{{ $req->description }}</small>--}}
                                {{--                                        </td>--}}

                                {{--                                        <td>--}}
                                {{--                                            @if($uploaded)--}}
                                {{--                                                <button class="btn btn-sm btn-primary"--}}
                                {{--                                                        data-bs-toggle="modal"--}}
                                {{--                                                        data-bs-target="#docModal{{ $uploaded->id }}">--}}
                                {{--                                                    View--}}
                                {{--                                                </button>--}}

                                {{--                                                --}}{{-- MODAL --}}
                                {{--                                                <div class="modal fade" id="docModal{{ $uploaded->id }}" tabindex="-1">--}}
                                {{--                                                    <div class="modal-dialog modal-xl">--}}
                                {{--                                                        <div class="modal-content">--}}
                                {{--                                                            <div class="modal-header">--}}
                                {{--                                                                <h5 class="modal-title">{{ $req->name }}</h5>--}}
                                {{--                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <div class="modal-body">--}}
                                {{--                                                                <iframe src="{{ asset('storage/'.$uploaded->file_path) }}"--}}
                                {{--                                                                        width="100%"--}}
                                {{--                                                                        height="600px"></iframe>--}}
                                {{--                                                            </div>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                            @else--}}
                                {{--                                                <span class="badge bg-danger">Missing</span>--}}
                                {{--                                            @endif--}}
                                {{--                                        </td>--}}

                                {{--                                        <td>--}}
                                {{--                                            @if($uploaded)--}}
                                {{--                                                <div class="d-flex align-items-center gap-2">--}}

                                {{--                                                    --}}{{-- APPROVE --}}
                                {{--                                                    <label class="me-2">--}}
                                {{--                                                        <input type="radio"--}}
                                {{--                                                               name="verify[{{ $uploaded->id }}]"--}}
                                {{--                                                               value="1"--}}
                                {{--                                                            {{ $uploaded->verified ? 'checked' : '' }}>--}}
                                {{--                                                        ✔ Verified--}}
                                {{--                                                    </label>--}}

                                {{--                                                    --}}{{-- REJECT --}}
                                {{--                                                    <label class="me-2">--}}
                                {{--                                                        <input type="radio"--}}
                                {{--                                                               name="verify[{{ $uploaded->id }}]"--}}
                                {{--                                                               value="0"--}}
                                {{--                                                            {{ !$uploaded->verified ? 'checked' : '' }}>--}}
                                {{--                                                        ✘ Reject--}}
                                {{--                                                    </label>--}}

                                {{--                                                    --}}{{-- COMMENT --}}
                                {{--                                                    <input type="text"--}}
                                {{--                                                           name="comments[{{ $uploaded->id }}]"--}}
                                {{--                                                           class="form-control form-control-sm"--}}
                                {{--                                                           placeholder="Comment"--}}
                                {{--                                                           style="max-width:200px;"--}}
                                {{--                                                           value="{{ $uploaded->comment ?? '' }}">--}}
                                {{--                                                </div>--}}
                                {{--                                            @else--}}
                                {{--                                                <span class="badge bg-danger">Not Uploaded</span>--}}
                                {{--                                            @endif--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}

                                {{--                                @endforeach--}}
                                </tbody>

                            </table>

                            <div class="mt-3 text-end">
                                <button class="btn btn-primary">Save Verification</button>
                            </div>

                        </div>
                    </div>

                </form>
                <form method="POST" action="{{ route('admin.verify.finalize', $admission->id) }}">
                    @csrf
                    <button class="btn btn-success btn-lg">
                        Finalize Verification
                    </button>
                </form>

            </div>

        </div>

    </div>

@endsection

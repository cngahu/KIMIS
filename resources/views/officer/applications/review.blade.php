@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .section-title {
            font-weight: bold;
            color: #003366;
            border-bottom: 2px solid #F4B400;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .info-label {
            font-weight: bold;
            color: #003366;
        }
        .attachment-box a {
            text-decoration: none;
        }
    </style>

    <div class="page-content">

        <h4 class="mb-3">Application Review</h4>

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- ===== APPLICANT DETAILS ===== -->
                <div class="section-title">Applicant Details</div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <span class="info-label">Full Name: </span>
                        {{ $application->full_name }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">ID Number: </span>
                        {{ $application->id_number }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">Phone: </span>
                        {{ $application->phone }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">Email: </span>
                        {{ $application->email }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <span class="info-label">Date of Birth: </span>
                        {{ $application->date_of_birth }}
                    </div>
                </div>


                <!-- ===== LOCATION DETAILS ===== -->
                <div class="section-title">Address & Location</div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <span class="info-label">Home County: </span>
                        {{ optional($application->homeCounty)->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Current County: </span>
                        {{ optional($application->currentCounty)->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Subcounty: </span>
                        {{ optional($application->currentSubcounty)->name }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Postal Address: </span>
                        {{ $application->postal_address }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Postal Code: </span>
                        {{ optional($application->postalCode)->code }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Town: </span>
                        {{ $application->town }}
                    </div>
                </div>


                <!-- ===== COURSE DETAILS ===== -->

                <div class="section-title">Course Applied For</div>

                <div class="mb-3">
                    <span class="info-label">Primary Course: </span>
                    {{ $application->course->course_name ?? $application->course->name }}
                </div>

                {{-- Alternative Courses from metadata --}}

                {{-- Alternative Courses (from metadata) --}}
                @php
                    // metadata is cast to array on the model
                    $meta = $application->metadata ?? [];

                    // IDs can be stored in metadata, and/or in the DB columns
                    $alt1Id = $meta['alt_course_1_id'] ?? $application->alt_course_1_id ?? null;
                    $alt2Id = $meta['alt_course_2_id'] ?? $application->alt_course_2_id ?? null;

                    $altCourseIds = collect([$alt1Id, $alt2Id])
                        ->filter()  // remove nulls
                        ->unique()
                        ->values();

                    $altCourses = collect();
                    if ($altCourseIds->isNotEmpty()) {
                        $altCourses = \App\Models\Course::with('college')
                            ->whereIn('id', $altCourseIds)
                            ->get()
                            ->keyBy('id');
                    }
                @endphp

                <div class="section-title">Alternative Courses (for consideration)</div>

                @if($altCourses->isNotEmpty())
                    <ul class="mb-3">
                        @foreach($altCourseIds as $index => $cid)
                            @php $alt = $altCourses->get($cid); @endphp
                            @if($alt)
                                <li class="mb-1">
                                    <strong>Option {{ $index + 2 }}:</strong>
                                    {{ $alt->course_name ?? $alt->name }}

                                    @if($alt->course_code)
                                        <span class="text-muted"> ({{ $alt->course_code }})</span>
                                    @endif

                                    @if(optional($alt->college)->name)
                                        <br>
                                        <small class="text-muted">
                                            College: {{ $alt->college->name }}
                                        </small>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-3"><em>No alternative courses selected.</em></p>
                @endif



                <!-- ===== PAYMENT DETAILS ===== -->
                <div class="section-title">Payment Information</div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <span class="info-label">Invoice Number: </span>
                        {{ $application->invoice->invoice_number ?? 'N/A' }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Amount Paid: </span>
                        KES {{ number_format($application->invoice->amount ?? 0) }}
                    </div>

                    <div class="col-md-4 mb-2">
                        <span class="info-label">Payment Status: </span>
                        <span class="badge bg-success">{{ ucfirst($application->payment_status) }}</span>
                    </div>
                </div>


                <!-- ===== ATTACHMENTS ===== -->
                <div class="section-title">Attachments</div>

                <div class="row">
                    @if($application->kcse_certificate_path)
                        <div class="col-md-6 mb-2">
                            <span class="info-label">KCSE Certificate:</span>
                            <a href="{{ asset('storage/'.$application->kcse_certificate_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary ms-2">
                                View
                            </a>
                        </div>
                    @endif

                    @if($application->school_leaving_certificate_path)
                        <div class="col-md-6 mb-2">
                            <span class="info-label">School Leaving Certificate:</span>
                            <a href="{{ asset('storage/'.$application->school_leaving_certificate_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary ms-2">
                                View
                            </a>
                        </div>
                    @endif

                    @if($application->birth_certificate_path)
                        <div class="col-md-6 mb-2">
                            <span class="info-label">Birth Certificate:</span>
                            <a href="{{ asset('storage/'.$application->birth_certificate_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary ms-2">
                                View
                            </a>
                        </div>
                    @endif

                    @if($application->national_id_path)
                        <div class="col-md-6 mb-2">
                            <span class="info-label">National ID:</span>
                            <a href="{{ asset('storage/'.$application->national_id_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary ms-2">
                                View
                            </a>
                        </div>
                    @endif

                    @if(
                        !$application->kcse_certificate_path &&
                        !$application->school_leaving_certificate_path &&
                        !$application->birth_certificate_path &&
                        !$application->national_id_path
                    )
                        <div class="col-md-12 mb-2">
                            <p class="text-muted"><em>No fixed attachments uploaded.</em></p>
                        </div>
                    @endif
                </div>


                <!-- ===== REQUIREMENT ANSWERS ===== -->
                <div class="section-title">Submitted Requirements</div>

                @forelse($application->answers as $ans)
                    <div class="mb-3">
                        <span class="info-label">{{ $ans->requirement->course_requirement }}:</span>

                        @if($ans->requirement->type === 'upload')
                            <div class="attachment-box mt-1">
                                <a href="{{ asset('storage/'.$ans->value) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    View File
                                </a>
                            </div>
                        @else
                            <p>{{ $ans->value }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-muted"><em>No additional requirements submitted.</em></p>
                @endforelse

                {{-- ===== OFFICER ACTIONS ===== --}}
                <div class="section-title">Officer Decision</div>

                @php
                    // metadata is cast to array
                    $meta = $application->metadata ?? [];

                    // read alt course IDs from metadata OR columns
                    $alt1Id = $meta['alt_course_1_id'] ?? $application->alt_course_1_id ?? null;
                    $alt2Id = $meta['alt_course_2_id'] ?? $application->alt_course_2_id ?? null;

                    $altCourseIds = collect([$alt1Id, $alt2Id])
                        ->filter()
                        ->unique()
                        ->values();

                    $altCourses = collect();
                    if ($altCourseIds->isNotEmpty()) {
                        $altCourses = \App\Models\Course::with('college')
                            ->whereIn('id', $altCourseIds)
                            ->get()
                            ->keyBy('id');
                    }

                    $primaryCourse = $application->course;
                @endphp

                <form action="" method="POST" id="decisionForm">
                    @csrf

                    {{-- Course to admit into --}}
                    <div class="mb-3">
                        <label class="info-label d-block">Course to Admit Applicant To</label>

                        <select name="approved_course_id" class="form-select" required>
                            @if($primaryCourse)
                                <option value="{{ $primaryCourse->id }}" selected>
                                    Primary: {{ $primaryCourse->course_name ?? $primaryCourse->name }}
                                    @if(optional($primaryCourse->college)->name)
                                        ({{ $primaryCourse->college->name }})
                                    @endif
                                </option>
                            @endif

                            @foreach($altCourseIds as $index => $cid)
                                @php $alt = $altCourses->get($cid); @endphp
                                @if($alt)
                                    <option value="{{ $cid }}">
                                        Alternative {{ $index + 1 }}:
                                        {{ $alt->course_name ?? $alt->name }}
                                        @if(optional($alt->college)->name)
                                            ({{ $alt->college->name }})
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        <small class="text-muted">
                            Primary course is selected by default. Change this if you want to admit the applicant
                            into a different (alternative) course.
                        </small>
                    </div>

                    {{-- Comments --}}
                    <div class="mb-3">
                        <label class="info-label">Comments / Notes</label>
                        <textarea name="comments" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="d-flex gap-3 mt-3">

                        <!-- Approve Button -->
                        <button formaction="{{ route('officer.applications.approve', $application->id) }}"
                                class="btn btn-success px-4">
                            Approve Application
                        </button>

                        <!-- Reject Button -->
                        <button formaction="{{ route('officer.applications.reject', $application->id) }}"
                                class="btn btn-danger px-4">
                            Reject Application
                        </button>

                    </div>

                </form>



            </div>
        </div>

    </div>

@endsection

<style>
    .section-title {
        font-weight: bold;
        color: #003366;
        border-bottom: 2px solid #F4B400;
        padding-bottom: 4px;
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 18px;
    }
    .info-row {
        margin-bottom: 10px;
    }
    .info-label {
        font-weight: bold;
    }
    .timeline {
        list-style: none;
        padding-left: 0;
        border-left: 2px solid #003366;
        margin-left: 10px;
    }
    .timeline-item {
        margin-bottom: 15px;
        padding-left: 10px;
        position: relative;
    }
    .timeline-item::before {
        content: '';
        width: 10px;
        height: 10px;
        background: #003366;
        border-radius: 50%;
        position: absolute;
        left: -6px;
        top: 4px;
    }
</style>

<div class="container-fluid">

    <!-- Application Summary -->
    <div class="section-title">Application Summary</div>
    <div class="row">
        <div class="col-md-6 info-row">
            <span class="info-label">Reference:</span> {{ $application->reference }}
        </div>
        <div class="col-md-6 info-row">
            <span class="info-label">Status:</span>
            <span class="badge bg-primary">{{ ucfirst($application->status) }}</span>
        </div>
    </div>

    <!-- Personal Details -->
    <div class="section-title">Applicant Details</div>
    <div class="row">
        <div class="col-md-6 info-row">
            <span class="info-label">Full Name:</span> {{ $application->full_name }}
        </div>
        <div class="col-md-6 info-row">
            <span class="info-label">ID Number:</span> {{ $application->id_number }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Phone:</span> {{ $application->phone }}
        </div>
        <div class="col-md-6 info-row">
            <span class="info-label">Email:</span> {{ $application->email }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Date of Birth:</span> {{ $application->date_of_birth }}
        </div>
    </div>

    <!-- Address -->
    <div class="section-title">Address & Location</div>
    <div class="row">
        <div class="col-md-6 info-row">
            <span class="info-label">Home County:</span> {{ optional($application->homeCounty)->name }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Current County:</span> {{ optional($application->currentCounty)->name }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Subcounty:</span> {{ optional($application->currentSubcounty)->name }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Postal Address:</span> {{ $application->postal_address }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Postal Code:</span> {{ optional($application->postalCode)->code }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Town:</span> {{ $application->town }}
        </div>
    </div>

    {{-- ============================= --}}
    {{-- COURSE / ADMISSION DETAILS   --}}
    {{-- ============================= --}}
    @php
        $meta = $application->metadata ?? [];

        // IDs saved during approval
        $appliedCourseId  = $meta['applied_course_id']  ?? $application->course_id;
        $admittedCourseId = $meta['admitted_course_id'] ?? $application->course_id;

        $appliedCourse  = \App\Models\Course::find($appliedCourseId);
        $admittedCourse = \App\Models\Course::find($admittedCourseId);

        $appliedName  = $appliedCourse
            ? ($appliedCourse->course_name ?? $appliedCourse->name)
            : 'N/A';

        $admittedName = $admittedCourse
            ? ($admittedCourse->course_name ?? $admittedCourse->name)
            : $appliedName;

        // Alternative course IDs (from metadata)
        $alt1Id = $meta['alt_course_1_id'] ?? null;
        $alt2Id = $meta['alt_course_2_id'] ?? null;

        $isAlternative = (int)$admittedCourseId !== (int)$appliedCourseId;

        if (! $isAlternative) {
            $admittedOptionLabel = 'Primary option';
        } elseif ($alt1Id && (int)$admittedCourseId === (int)$alt1Id) {
            $admittedOptionLabel = 'Option 1';
        } elseif ($alt2Id && (int)$admittedCourseId === (int)$alt2Id) {
            $admittedOptionLabel = 'Option 2';
        } else {
            $admittedOptionLabel = 'Alternative option';
        }
    @endphp

    <div class="section-title">Course / Admission</div>
    <div class="row">
        <div class="col-md-6 info-row">
            <span class="info-label">Applied Course:</span>
            {{ $appliedName }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Admitted Course:</span>
            <strong>{{ $admittedName }}</strong>
            <br>
            @if($isAlternative)
                <small class="text-muted">
                    Student applied for
                    <strong>{{ $appliedName }}</strong>,
                    but based on the entry requirements was
                    <strong>recommended and admitted</strong>
                    to this course ({{ $admittedOptionLabel }}).
                </small>
            @else
                <small class="text-muted">
                    Student admitted to the same course they applied for
                    ({{ $admittedOptionLabel }}).
                </small>
            @endif
        </div>
    </div>

    {{-- Alternative Courses list (from controller) --}}
    @if(isset($alternativeCourses) && $alternativeCourses->isNotEmpty())
        <div class="mt-2">
            <span class="info-label d-block mb-1">Alternative Courses (for consideration):</span>

            <ul class="mb-0">
                @foreach($alternativeCourses as $index => $alt)
                    <li>
                        <strong>Option {{ $index + 1 }}:</strong>
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
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-muted"><em>No alternative courses selected.</em></p>
    @endif

    <!-- Payment -->
    <div class="section-title">Payment Information</div>
    <div class="row">
        <div class="col-md-6 info-row">
            <span class="info-label">Invoice Number:</span>
            {{ $application->invoice->invoice_number ?? 'N/A' }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Amount:</span>
            KES {{ number_format($application->invoice->amount ?? 0) }}
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Payment Status:</span>
            <span class="badge bg-success">{{ ucfirst($application->payment_status) }}</span>
        </div>

        <div class="col-md-6 info-row">
            <span class="info-label">Paid At:</span>
            {{ $application->invoice->paid_at ?? 'N/A' }}
        </div>
    </div>

    <!-- Attachments -->
    <div class="section-title">Attachments</div>
    <div class="row">

        @if($application->kcse_certificate_path)
            <div class="col-md-6 info-row">
                <span class="info-label">KCSE Certificate:</span>
                <a href="{{ asset('storage/'.$application->kcse_certificate_path) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary ms-2">
                    View
                </a>
            </div>
        @endif

        @if($application->school_leaving_certificate_path)
            <div class="col-md-6 info-row">
                <span class="info-label">School Leaving Certificate:</span>
                <a href="{{ asset('storage/'.$application->school_leaving_certificate_path) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary ms-2">
                    View
                </a>
            </div>
        @endif

        @if($application->birth_certificate_path)
            <div class="col-md-6 info-row">
                <span class="info-label">Birth Certificate:</span>
                <a href="{{ asset('storage/'.$application->birth_certificate_path) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary ms-2">
                    View
                </a>
            </div>
        @endif

        @if($application->national_id_path)
            <div class="col-md-6 info-row">
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
            <div class="col-md-12">
                <p class="text-muted"><em>No fixed attachments uploaded.</em></p>
            </div>
        @endif

    </div>

    <!-- Requirement Answers -->
    <div class="section-title">Submitted Requirements</div>
    <div class="row">
        @foreach($application->answers as $ans)
            <div class="col-md-12 info-row">
                <span class="info-label">{{ $ans->requirement->course_requirement }}:</span>

                @if($ans->requirement->type === 'upload')
                    <a href="{{ asset('storage/'.$ans->value) }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-primary ms-2">
                        View File
                    </a>
                @else
                    {{ $ans->value }}
                @endif
            </div>
        @endforeach
    </div>

    <div class="section-title">Timeline</div>
    {{-- If you later re-enable logs, they go here --}}
</div>

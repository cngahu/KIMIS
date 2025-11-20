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
</style>
<style>
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

    <!-- Course -->
    <div class="section-title">Course Applied</div>
    <p><strong>{{ $application->course->name }}</strong></p>

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

    <!-- Requirement Answers -->
    <div class="section-title">Submitted Requirements</div>
    <div class="row">

        @foreach($application->answers as $ans)
            <div class="col-md-12 info-row">
                <span class="info-label">{{ $ans->requirement->course_requirement }}:</span>

                @if($ans->requirement->type === 'upload')
                    <a href="{{ asset('storage/'.$ans->value) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                        View File
                    </a>
                @else
                    {{ $ans->value }}
                @endif
            </div>
        @endforeach

    </div>
    <div class="section-title">Timeline</div>

{{--    <ul class="timeline">--}}
{{--        @foreach($application->logs as $log)--}}
{{--            <li class="timeline-item">--}}
{{--                <strong>{{ $log->action }}</strong><br>--}}
{{--                <span>{{ $log->created_at->format('d M Y, h:i A') }}</span><br>--}}
{{--                <small>{{ $log->user->surname ?? '' }} {{ $log->user->firstname ?? '' }}</small>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}

</div>

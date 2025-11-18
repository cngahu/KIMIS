@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <h1>Training Details</h1>

        <div class="card mb-3">
            <div class="card-body">

                <h5 class="card-title mb-3">
                    {{ optional($training->course)->course_name ?? 'N/A' }}
                </h5>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Course:</strong> {{ optional($training->course)->course_name ?? '-' }}</p>
                        <p class="mb-1"><strong>Course Code:</strong> {{ optional($training->course)->course_code ?? '-' }}</p>
                        <p class="mb-1"><strong>College:</strong> {{ optional($training->college)->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Start Date:</strong>
                            {{ $training->start_date ? $training->start_date->format('d M Y') : '-' }}
                        </p>
                        <p class="mb-1"><strong>End Date:</strong>
                            {{ $training->end_date ? $training->end_date->format('d M Y') : '-' }}
                        </p>
                        <p class="mb-1"><strong>Status:</strong> {{ $training->status ?? '-' }}</p>
                    </div>
                </div>

                <p class="mb-1"><strong>Cost:</strong> KSh {{ number_format($training->cost, 2) }}</p>
                <p class="mb-1"><strong>Created By:</strong> {{ optional($training->user)->name ?? '-' }}</p>
                <p class="mb-1">
                    <strong>Created At:</strong>
                    {{ $training->created_at ? $training->created_at->format('d M Y H:i') : '-' }}
                </p>
                <p class="mb-0">
                    <strong>Last Updated:</strong>
                    {{ $training->updated_at ? $training->updated_at->format('d M Y H:i') : '-' }}
                </p>
            </div>
        </div>

        <a href="{{ route('trainings.edit', $training) }}" class="btn btn-warning">
            Edit
        </a>
        <a href="{{ route('all.trainings') }}" class="btn btn-secondary">
            Back
        </a>
    </div>
@endsection

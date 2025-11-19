@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Course Details</h1>
                <p class="text-muted mb-0">
                    View full details of this course.
                </p>
            </div>
            <div>
                <a href="{{ route('all.courses') }}" class="btn btn-light border me-2">
                    Back to Courses
                </a>
                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h3 class="card-title mb-3">{{ $course->course_name }}</h3>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>Category:</strong>
                            <span class="badge
                                @if($course->course_category == 'Diploma') bg-primary
                                @elseif($course->course_category == 'Craft') bg-success
                                @elseif($course->course_category == 'Higher Diploma') bg-warning text-dark
                                @else bg-info text-dark @endif">
                                {{ $course->course_category }}
                            </span>
                        </p>
                        <p><strong>Code:</strong> <code>{{ $course->course_code }}</code></p>
                        <p><strong>Mode:</strong>
                            <span class="badge
                                @if($course->course_mode == 'Long Term') bg-dark
                                @else bg-secondary @endif">
                                {{ $course->course_mode }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Duration:</strong> {{ $course->course_duration }} months</p>
                        <p><strong>Cost:</strong> KSh {{ number_format($course->cost, 2) }}</p>

                        {{-- Requirement Badge + Manage button --}}
                        <p class="mb-1">
                            <strong>Requirement:</strong>
                            @if($course->requirement)
                                <span class="badge bg-success">Yes</span>
                                <a href="{{ route('courses.requirements.create', $course) }}"
                                   class="btn btn-sm btn-outline-primary ms-2">
                                    Manage Requirements
                                </a>
                            @else
                                <span class="badge bg-secondary">No specific requirements</span>
                            @endif
                        </p>

                        @if($course->target_group)
                            <p class="mt-2">
                                <strong>Target Group:</strong><br>
                                {{ $course->target_group }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Requirements List --}}
        @if($course->requirement)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-1">Entry Requirements</h5>
                    <p class="text-muted small mb-0">
                        Below are the stored requirements for this course.
                    </p>
                </div>
                <div class="card-body">
                    @if($course->requirements->count())
                        <ul class="list-group">
                            @foreach($course->requirements as $req)
                                <li class="list-group-item">
                                    {!! nl2br(e($req->course_requirement)) !!}
                                    <div class="small text-muted mt-1">
                                        Added on {{ $req->created_at->format('d M Y H:i') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">
                            No requirements captured yet.
                            <a href="{{ route('courses.requirements.create', $course) }}">
                                Click here to add one.
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection

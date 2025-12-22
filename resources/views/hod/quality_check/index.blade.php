@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="mb-4">
            <h4 class="fw-bold">Quality Check</h4>
            <p class="text-muted mb-0">
                {{ $course->course_name }} — {{ $cohort }}
            </p>
        </div>

        <div class="row g-3">

            {{-- EXPECTED --}}
            <div class="col-md-4">
                <div class="card radius-10 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold">Expected Students</h6>
                        <ul class="list-group list-group-flush">
                            @forelse($data['expected'] as $row)
                                <li class="list-group-item">
                                    <strong>{{ $row['admission_no'] }}</strong><br>
                                    {{ $row['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted">
                                    No expected records.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ACTIVATED --}}
            <div class="col-md-4">
                <div class="card radius-10 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold">Activated</h6>
                        <ul class="list-group list-group-flush">
                            @forelse($data['activated'] as $row)
                                <li class="list-group-item">
                                    <strong>{{ $row['admission_no'] }}</strong><br>
                                    {{ $row['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted">
                                    No activated students.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- REGISTERED --}}
            <div class="col-md-4">
                <div class="card radius-10 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold text-success">Registered</h6>
                        <ul class="list-group list-group-flush">
                            @forelse($data['registered'] as $row)
                                <li class="list-group-item">
                                    <strong>{{ $row['admission_no'] }}</strong><br>
                                    {{ $row['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted">
                                    No confirmed registrations.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

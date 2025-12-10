@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0">Student Biodata</h4>

            @if(Route::has('admin.biodata.import'))
                <a href="{{ route('admin.biodata.import') }}" class="btn btn-success btn-sm">
                    <i class="bx bx-upload"></i> Import Biodata
                </a>
            @endif
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        {{-- Filters --}}
        <div class="card radius-10 mb-3">
            <div class="card-body">
                <form action="{{ route('admin.biodata.index') }}" method="GET" class="row g-2 align-items-end">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label mb-1">Search</label>
                        <input type="text"
                               name="search"
                               class="form-control form-control-sm"
                               placeholder="Name, Student ID, Admission No, Cert No, National ID..."
                               value="{{ request('search') }}">
                    </div>

                    {{-- Department --}}
                    <div class="col-md-3">
                        <label class="form-label mb-1">Department</label>
                        <select name="department_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->departmentid }}"
                                    {{ (string)request('department_id') === (string)$dept->departmentid ? 'selected' : '' }}>
                                    {{ $dept->departmentname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Course --}}
                    <div class="col-md-3">
                        <label class="form-label mb-1">Course</label>
                        <select name="course_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->courseid }}"
                                    {{ (string)request('course_id') === (string)$course->courseid ? 'selected' : '' }}>
                                    {{ $course->coursename }} ({{ $course->coursecode }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit"
                                class="btn btn-sm btn-dark flex-fill">
                            Filter
                        </button>

                        @if(request()->query())
                            <a href="{{ route('admin.biodata.index') }}"
                               class="btn btn-sm btn-outline-secondary flex-fill">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card radius-10">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Admission / Student</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>KCSE Grade</th>
                        <th>Certificate No</th>
                        <th>Phone / ID</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($biodatas as $index => $bio)
                        @php
                            $adm    = $bio->admission;                    // AdmissionRecord (can be null)
                            $course = optional($adm?->course);            // CoursesData (can be null)
                            $dept   = optional($course?->department);     // Department (can be null)
                        @endphp

                        <tr>
                            {{-- # --}}
                            <td>{{ $biodatas->firstItem() + $index }}</td>

                            {{-- Admission / Student IDs --}}
                            <td>
                                <div>
                                    <strong>Adm No:</strong> {{ $bio->admissionno ?? '-' }}
                                </div>
                                <div class="text-muted small">
                                    <strong>Student ID:</strong> {{ $bio->studentid ?? '-' }}
                                </div>
                            </td>

                            {{-- Student Name --}}
                            <td>
                                {{ $bio->studentsname ?? '-' }}<br>
                                @if($bio->emailaddress)
                                    <span class="text-muted small">{{ $bio->emailaddress }}</span>
                                @endif
                            </td>

                            {{-- Course --}}
                            <td>
                                @if($course)
                                    <div>{{ $course->coursename }}</div>
                                    <div class="text-muted small">
                                        {{ $course->coursecode }}
                                        @if($course->courseshortname)
                                            – {{ $course->courseshortname }}
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Department --}}
                            <td>
                                {{ $dept->departmentname ?? '-' }}
                            </td>

                            {{-- KCSE Grade --}}
                            <td>
                                {{ $bio->kcsemeangrade ?? '-' }}
                            </td>

                            {{-- Cert No --}}
                            <td>
                                @if($adm && $adm->certno)
                                    <span class="badge bg-success">{{ $adm->certno }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Phone / ID --}}
                            <td>
                                <div>{{ $bio->mobileno ?? '-' }}</div>
                                <div class="text-muted small">
                                    ID: {{ $bio->nationalidno ?? '-' }}
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">

                                @if(Route::has('admin.biodata.show'))
                                    <a href="{{ route('admin.biodata.show', $bio->id) }}"
                                       class="btn btn-sm btn-outline-primary mb-1">
                                        <i class="bx bx-show"></i>
                                    </a>
                                @endif

                                @if(Route::has('admin.biodata.edit'))
                                    <a href="{{ route('admin.biodata.edit', $bio->id) }}"
                                       class="btn btn-sm btn-outline-warning mb-1">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No biodata records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($biodatas->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="small text-muted">
                            Showing
                            <strong>{{ $biodatas->firstItem() }}</strong>
                            to
                            <strong>{{ $biodatas->lastItem() }}</strong>
                            of
                            <strong>{{ $biodatas->total() }}</strong>
                            students
                        </div>

                        <nav aria-label="Biodata pagination">
                            {{ $biodatas->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

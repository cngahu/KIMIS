@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="page-breadcrumb d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Course Intake Details</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('course_cohorts.index') }}">Course Intakes</a>
                        </li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="25%">Course</th>
                        <td>
                            <strong>{{ $cohort->course->course_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $cohort->course->course_code }}</small>
                        </td>
                    </tr>

                    <tr>
                        <th>College</th>
                        <td>{{ $cohort->course->college->name }}</td>
                    </tr>

                    <tr>
                        <th>Intake</th>
                        <td>
                        <span class="badge bg-info">
                            {{ \Carbon\Carbon::create(
                                $cohort->intake_year,
                                $cohort->intake_month
                            )->format('F Y') }}
                        </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                        <span class="badge bg-{{ $cohort->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($cohort->status) }}
                        </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Created On</th>
                        <td>{{ $cohort->created_at->format('d M Y') }}</td>
                    </tr>
                    </tbody>
                </table>

                {{-- Actions --}}
                <div class="mt-3">
                    <a href="{{ route('course_cohorts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection

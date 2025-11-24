@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold">Welcome, {{ auth()->user()->firstname }}</h4>
        <p class="text-muted mb-3">You are now a fully admitted student.</p>

        <div class="row row-cols-1 row-cols-md-3 g-3">

            {{-- Admission Number --}}
            <div class="col">
                <div class="card radius-10 p-4 shadow-sm" style="background:linear-gradient(135deg,#003366,#009FE3);color:#fff;">
                    <h6 class="fw-bold">Admission Number</h6>
                    <h3 class="fw-bold">{{ $admission->admission_number ?? 'Pending' }}</h3>
                </div>
            </div>

            {{-- Fee Balance --}}
            <div class="col">
                <div class="card radius-10 p-4 shadow-sm">
                    <h6 class="fw-bold">Fee Balance</h6>
                    <h3 class="fw-bold text-danger">KES 0.00</h3>
                    <small class="text-muted">Fully cleared</small>
                </div>
            </div>

            {{-- Course --}}
            <div class="col">
                <div class="card radius-10 p-4 shadow-sm">
                    <h6 class="fw-bold">Course</h6>
                    <h5>{{ optional($admission->application->course)->course_name }}</h5>
                </div>
            </div>

        </div>

        <div class="row mt-4 g-3">
            <div class="col-md-6">
                <div class="card radius-10 p-4 shadow-sm">
                    <h5 class="fw-bold">Quick Actions</h5>
                    <ul class="list-group mt-2">
                        <li class="list-group-item"><a href="#">My Profile</a></li>
                        <li class="list-group-item"><a href="#">Download Fee Statement</a></li>
                        <li class="list-group-item"><a href="#">Unit Registration (Coming Soon)</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card radius-10 p-4 shadow-sm">
                    <h5 class="fw-bold">Notices</h5>
                    <p class="text-muted">No new notices</p>
                </div>
            </div>
        </div>

    </div>

@endsection

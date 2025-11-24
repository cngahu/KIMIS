@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="row justify-content-center mt-5">
            <div class="col-md-7">
                <div class="card radius-10 p-4 shadow-sm">

                    <div class="text-center mb-3">
                        <img src="{{ asset('adminbackend/assets/images/icons/student.png') }}"
                             height="80"
                             class="mb-3 opacity-75"
                             alt="Student Icon">
                        <h4 class="fw-bold">Welcome, {{ auth()->user()->firstname }}</h4>
                        <p class="text-muted">
                            You do not have any active admission or student record linked to your account.
                        </p>
                    </div>

                    <hr>

                    {{-- Helpful Actions --}}
                    <div class="text-center mt-4">

                        <p class="text-muted mb-4">
                            If you recently applied for a course, your admission will appear here once processed.<br>
                            If you think this is an error, please contact the Admissions Office.
                        </p>

                        <a href="{{ url('/') }}" target="_blank" class="btn btn-primary px-4">
                            <i class="bx bx-home-alt"></i> Visit Homepage
                        </a>

                        <a href="{{ url('/courses') }}" target="_blank" class="btn btn-outline-secondary px-4 ms-2">
                            <i class="bx bx-book"></i> View Available Courses
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

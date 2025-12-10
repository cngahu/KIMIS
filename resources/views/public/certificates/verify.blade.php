@extends('layouts.public')

@section('content')


        {{-- Body --}}
        <section class="px-4 pb-4 pt-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    {{-- Card --}}
                    <div class="p-4 text-center shadow-sm border rounded-3" style="background:#fff; border-color:#e5e7eb;">

                        {{-- Icon --}}
                        <div class="mb-3">
                        <span class="d-inline-flex justify-content-center align-items-center"
                              style="width:70px; height:70px; border-radius:50%; background:#09913910; color:#099139; font-size:35px;">
                            <i class="la la-certificate"></i>
                        </span>
                        </div>

                        {{-- Title --}}
                        <h3 class="mb-2 fw-bold" style="color:#3B2818;">
                            Certificate Verification
                        </h3>

                        {{-- Description --}}
                        <p class="text-muted mb-3" style="font-size:14px;">
                            Enter your <strong>Certificate Number</strong> or <strong>National ID Number</strong> to verify
                            the authenticity of your training certificate. No login required.
                        </p>

                        {{-- Form --}}
                        <form action="{{ route('certificates.verify') }}" method="GET" class="mt-3 text-start">

                            @csrf

                            <div class="row g-3 justify-content-center">

                                {{-- Certificate Number --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Certificate Number</label>
                                    <input type="text"
                                           name="certno"
                                           value="{{ request('certno') }}"
                                           class="form-control form-control-sm"
                                           placeholder="Enter certificate number (optional)">
                                </div>

                                {{-- National ID --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">National ID Number</label>
                                    <input type="text"
                                           name="nationalidno"
                                           value="{{ request('nationalidno') }}"
                                           class="form-control form-control-sm"
                                           placeholder="Enter ID number (optional)">
                                </div>

                                <div class="col-12">
                                    <p class="text-muted small mb-1">
                                        You can search using either field, or both for a more precise match.
                                    </p>
                                </div>

                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit"
                                            class="btn d-inline-flex align-items-center gap-2 px-4 py-2 fw-semibold"
                                            style="background:#099139; color:#fff; border-radius:6px;">
                                        <i class="la la-search"></i>
                                        Verify Certificate
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Error message --}}
                        @if($error)
                            <div class="alert alert-danger mt-4 mb-0 small">
                                {{ $error }}
                            </div>
                        @endif

                        {{-- Result --}}
                        @if($result)
                            <div class="mt-4 text-start">
                                <h5 class="fw-bold mb-3" style="color:#3B2818;">Verification Result</h5>

                                <div class="row g-3 small">

                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3">
                                            <div class="fw-semibold text-muted text-uppercase" style="font-size:11px;">
                                                Trainee
                                            </div>
                                            <div style="font-size:14px; color:#26211d;">
                                                {{ $result->studentsname }}
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                ID: {{ $result->nationalidno ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3">
                                            <div class="fw-semibold text-muted text-uppercase" style="font-size:11px;">
                                                Certificate
                                            </div>
                                            <div style="font-size:14px; color:#26211d;">
                                                No: {{ $result->certno ?? 'N/A' }}
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                Class No: {{ $result->classno ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="border rounded-3 p-3">
                                            <div class="fw-semibold text-muted text-uppercase" style="font-size:11px;">
                                                Course
                                            </div>
                                            <div style="font-size:14px; color:#26211d;">
                                                {{ $result->coursename }}
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                Code: {{ $result->coursecode ?? 'N/A' }} |
                                                Department: {{ $result->departmentname ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3">
                                            <div class="fw-semibold text-muted text-uppercase" style="font-size:11px;">
                                                Training Details
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                Class: {{ $result->classname ?? 'N/A' }}<br>
                                                Venue: {{ $result->venue ?? 'N/A' }}<br>
                                                Term: {{ $result->studyterm ?? 'N/A' }} |
                                                Year: {{ $result->studyactualyear ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3">
                                            <div class="fw-semibold text-muted text-uppercase" style="font-size:11px;">
                                                Dates
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                Start: {{ optional($result->startdate)->format('d M Y') ?? 'N/A' }}<br>
                                                End: {{ optional($result->enddate)->format('d M Y') ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="border rounded-3 p-3">
                                            <div class="fw-semibold text-muted text-uppercase" style="font-size:11px;">
                                                Additional Info
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                Company: {{ $result->company ?? 'N/A' }}<br>
                                                County: {{ $result->county ?? 'N/A' }}<br>
                                                Officer: {{ $result->officer ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="alert alert-success mt-3 mb-0 small">
                                    ✅ This certificate record exists in the KIHBT short course database.
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </section>



    </div>

@endsection

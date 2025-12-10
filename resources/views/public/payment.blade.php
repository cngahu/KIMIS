@extends('layouts.public')

@section('content')

    @php
        $meta = $meta ?? [];
        $isShort = $isShort ?? false;
        $appCount = $meta['applicant_count'] ?? null;
        $amountPerApplicant = $meta['amount_per_applicant'] ?? null;
    @endphp

    <div class="container py-4">

        {{-- Title --}}
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h3 class="mb-3">Payment for Application: <strong>{{ $application->reference }}</strong></h3>

                <small class="text-muted">
                    {{ $isShort ? 'Short Course (Group Application)' : 'Standard Application' }}
                </small>

                {{-- Invoice Card --}}
                <div class="card shadow-sm mt-3">
                    <div class="card-body">

                        <h5 class="mb-3">Invoice Details</h5>

                        <p><strong>Invoice Number:</strong> {{ $application->invoice->invoice_number }}</p>
                        <p><strong>Applicant Name:</strong> {{ $application->full_name }}</p>
                        <p><strong>Course:</strong> {{ $application->course->course_name }}</p>

                        @if($isShort && $appCount && $amountPerApplicant)
                            <p><strong>Amount per Applicant:</strong> KES {{ number_format($amountPerApplicant, 2) }}</p>
                            <p><strong>Applicants:</strong> {{ $appCount }}</p>
                            <p><strong>Total:</strong> KES {{ number_format($application->invoice->amount, 2) }}</p>
                        @else
                            <p><strong>Amount:</strong> KES {{ number_format($application->invoice->amount, 2) }}</p>
                        @endif

                        <p>
                            <strong>Status:</strong>
                            @if($application->invoice->status === 'paid')
                                <span class="badge bg-success">PAID</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending Payment</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Short Applicant Table --}}
                @if($isShort && isset($shortApplicants) && $shortApplicants->count())
                    <div class="card shadow-sm mt-3">
                        <div class="card-body">
                            <h5 class="mb-3">Applicant Details</h5>

                            @if($application->financier === 'employer' && !empty($meta['employer_name']))
                                <p><strong>Employer / Institution:</strong> {{ $meta['employer_name'] }}</p>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>ID No</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shortApplicants as $idx => $applicant)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $applicant->full_name }}</td>
                                            <td>{{ $applicant->id_no ?? '-' }}</td>
                                            <td>{{ $applicant->phone ?? '-' }}</td>
                                            <td>{{ $applicant->email ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @endif

                {{-- Pay Now Button --}}
                @if($application->invoice->status !== 'paid' && !empty($pesaflow))


                    <a href="{{ route('applications.pay.now', $application->id) }}"
                       class="btn btn-success btn-lg w-100 mb-3">
                        Pay Now
                    </a>

                @else
                    <div class="alert alert-success text-center mt-4">
                        Payment has already been received.
                    </div>
                @endif



            </div>
        </div>
    </div>


@endsection

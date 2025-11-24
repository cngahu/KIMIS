@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-2">Fee Payment</h4>

        <div class="card p-4 mb-3">
            <p><strong>Course Fee:</strong> KES {{ number_format($courseFee) }}</p>
            <p><strong>Total Paid:</strong> KES {{ number_format($totalPaid) }}</p>
            <p><strong>Balance:</strong> KES {{ number_format($balance) }}</p>
        </div>

        <div class="card p-4 mb-3">
            <h5>Make a Payment</h5>


            <div class="row g-3">

                {{-- FULL PAYMENT --}}
                <div class="col-md-6">
                    <a href="{{ route('student.admission.payment.full') }}" class="card p-4 text-center shadow-sm">
                        <i class="bx bx-credit-card fs-1"></i>
                        <h5>Pay Full Amount</h5>
                    </a>
                </div>

                {{-- PARTIAL PAYMENT --}}
                <div class="col-md-6">
                    <a href="{{ route('student.admission.payment.partial') }}" class="card p-4 text-center shadow-sm">
                        <i class="bx bx-pie-chart fs-1"></i>
                        <h5>Pay Partial Amount</h5>
                    </a>
                </div>

                {{-- SPONSOR --}}
                <div class="col-md-6">
                    <a href="{{ route('student.admission.payment.sponsor') }}" class="card p-4 text-center shadow-sm">
                        <i class="bx bx-group fs-1"></i>
                        <h5>Sponsored/Bursary</h5>
                    </a>
                </div>

                {{-- PAY LATER --}}
                <div class="col-md-6">
                    <a href="{{ route('student.admission.payment.later') }}" class="card p-4 text-center shadow-sm">
                        <i class="bx bx-time-five fs-1"></i>
                        <h5>Request Pay Later</h5>
                    </a>
                </div>

            </div>



            <form action="{{ route('student.admission.payment.create') }}" method="POST">
                @csrf

                <label class="form-label">Amount to Pay (KES)</label>
                <input type="number" class="form-control" name="amount" min="100" max="{{ $balance }}" required>

                <button class="btn btn-primary mt-3">Proceed to Payment</button>
            </form>
        </div>
    </div>

@endsection

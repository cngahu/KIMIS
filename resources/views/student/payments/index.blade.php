@extends('student.student_dashboard')

@section('student')
<div class="page-content">
    <h4>My Payments</h4>
    <ul>
        @forelse($payments as $payment)
            <li>{{ $payment->amount }} - {{ $payment->status }}</li>
        @empty
            <li>No payment records found.</li>
        @endforelse
    </ul>
</div>
@endsection
@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <h4>Request: Pay Later</h4>

        <form method="POST" action="{{ route('student.admission.payment.later.submit') }}">
            @csrf
            <div class="mb-3">
                <label> Explain why you need to pay later *</label>
                <textarea name="explanation" class="form-control" rows="5" required></textarea>
            </div>
            <button class="btn btn-primary">Submit Request</button>
        </form>
    </div>
@endsection

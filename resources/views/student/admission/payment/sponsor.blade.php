@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <h4>Sponsored / Bursary Submission</h4>

        <form method="POST" action="{{ route('student.admission.payment.sponsor.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label> Sponsor Name *</label>
                <input name="sponsor_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label> Sponsor Letter (pdf)</label>
                <input type="file" name="sponsor_letter" class="form-control">
            </div>
            <div class="mb-3">
                <label> Expected Amount (optional)</label>
                <input type="number" name="amount" class="form-control">
            </div>
            <button class="btn btn-primary">Submit Sponsor Info</button>
        </form>
    </div>
@endsection

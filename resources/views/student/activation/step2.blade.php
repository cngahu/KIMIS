@extends('layouts.public')

@section('content')
    <div class="container mt-5" style="max-width:420px;">
        <h4 class="mb-3">Confirm Contact Details</h4>

        <form method="POST" action="{{ route('student.activation.complete') }}">
            @csrf

            <input type="hidden" name="admissionno" value="{{ $student->admissionNo }}">

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input class="form-control" value="{{ $student->full_name }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">
                Activate Account
            </button>
        </form>
    </div>
@endsection

@extends('layouts.public')

@section('content')
    <div class="container mt-5" style="max-width:420px;">
        <h4 class="mb-3">Student Activation</h4>

        <form method="POST" action="{{ route('student.activation.verify') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Admission Number</label>
                <input type="text"
                       name="admissionno"
                       class="form-control"
                       required>
                @error('admissionno')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary w-100">
                Continue
            </button>
        </form>
    </div>
@endsection

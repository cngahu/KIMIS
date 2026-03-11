@extends('layouts.public')

@section('content')
    <div class="container mt-5 mb-5" style="max-width:420px;">
        {{-- Added padding, background, shadow and rounded corners for better visual definition --}}
        <div class="bg-white p-4 p-md-5 rounded shadow-sm">
            <h4 class="mb-4 text-center fw-bold">Student Activation</h4>

            @if(session('activation_error'))
                <div class="alert alert-danger mb-4">
                    An error occurred while activating your account.
                    Please try again later or contact the institution if the problem persists.
                </div>
            @endif

            {{--        <form method="POST" action="{{ route('student.activation.verify') }}">--}}
            {{--            @csrf--}}

            {{--            <div class="mb-3">--}}
            {{--                <label class="form-label">Admission Number</label>--}}
            {{--                <input type="text"--}}
            {{--                       name="admissionno"--}}
            {{--                       class="form-control"--}}
            {{--                       required>--}}
            {{--                @error('admissionno')--}}
            {{--                <small class="text-danger">{{ $message }}</small>--}}
            {{--                @enderror--}}
            {{--            </div>--}}

            {{--            <button class="btn btn-primary w-100">--}}
            {{--                Continue--}}
            {{--            </button>--}}

            {{--            <button type="submit" class="btn btn-primary w-100">--}}
            {{--                Continue--}}
            {{--            </button>--}}

            {{--        </form>--}}

            <form method="POST" action="{{ route('student.activation.verify.new') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">Admission Number</label>
                    <input type="text"
                           name="admissionno"
                           class="form-control py-2"
                           placeholder="Enter your admission number"
                           required>
                    @error('admissionno')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Continue
                </button>
            </form>
        </div>
    </div>
@endsection
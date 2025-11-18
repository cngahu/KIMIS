@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <h1>Create Course</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
            </div>
        @endif

        <form action="{{ route('courses.store') }}" method="POST">
            @include('admin.courses._form', ['buttonText' => 'Create'])
        </form>
    </div>
@endsection

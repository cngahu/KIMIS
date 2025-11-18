@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <h1>Edit Course</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
            </div>
        @endif

        <form action="{{ route('courses.update', $course) }}" method="POST">
            @method('PUT')
            @include('admin.courses._form', ['buttonText' => 'Update'])
        </form>
    </div>
@endsection

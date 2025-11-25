@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <h1>Create Training</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
            </div>
        @endif

        <form action="{{ route('trainings.store') }}" method="POST">
            @include('admin.trainings._form', [
                'buttonText' => 'Create',
                'training'   => $training ?? null,
            ])
        </form>
    </div>
@endsection

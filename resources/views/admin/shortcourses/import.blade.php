@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">
        <h3 class="mb-3">Import Short Course Data</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.shortcourses.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">CSV File</label>
                <input type="file" name="file" class="form-control" required>
                <div class="form-text">Upload the short course CSV (exported from Excel).</div>
            </div>

            <button class="btn btn-primary">Import</button>
        </form>
    </div>
@endsection

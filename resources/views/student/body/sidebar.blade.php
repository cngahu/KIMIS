{{-- resources/views/student/body/sidebar.blade.php --}}
{{-- Student sidebar inherits fully from admin --}}
@extends('admin.admin_dashboard')

@section('title', 'Student Dashboard')

@section('admin')
    {{-- Include admin sidebar --}}
    @include('admin.body.sidebar')
@endsection


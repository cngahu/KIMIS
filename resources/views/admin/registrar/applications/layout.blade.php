@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('registrar.applications.awaiting') ? 'active' : '' }}"
                   href="{{ route('registrar.applications.awaiting') }}">
                    Awaiting Assignment
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('registrar.applications.assigned') ? 'active' : '' }}"
                   href="{{ route('registrar.applications.assigned') }}">
                    Assigned / In Review
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('registrar.applications.completed') ? 'active' : '' }}"
                   href="{{ route('registrar.applications.completed') }}">
                    Completed
                </a>
            </li>
        </ul>

        @yield('registrar-content')

    </div>

@endsection

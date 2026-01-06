<div class="sidebar-wrapper kihbt-sidebar" data-simplebar="true">

    @include('admin.body.sidebar._header')

    <ul class="metismenu" id="menu">

        {{-- Shared menus --}}
        @includeWhen(Auth::user()->can('roles.menu'), 'admin.body.sidebar._roles_permissions')
        @includeWhen(Auth::user()->can('users.menu'), 'admin.body.sidebar._user_setups')
        @include('admin.body.sidebar._reports')

        {{-- Role-based menus --}}
        @includeWhen(Auth::user()->hasRole('superadmin'), 'admin.body.sidebar._superadmin')
        @includeWhen(Auth::user()->hasRole('hod'), 'admin.body.sidebar._hod')
        @includeWhen(Auth::user()->hasRole('campus_registrar'), 'admin.body.sidebar._campus_registrar')
        @includeWhen(Auth::user()->hasRole('kihbt_registrar'), 'admin.body.sidebar._registrar')
        @includeWhen(Auth::user()->hasRole('director'), 'admin.body.sidebar._director')
        @includeWhen(Auth::user()->hasRole('student'), 'admin.body.sidebar._student')
        @includeWhen(Auth::user()->hasRole('accounts'), 'admin.body.partials._accounts')
        @includeWhen(Auth::user()->hasRole('cash_office'), 'admin.body.partials._accounts')
        @includeWhen(Auth::user()->hasRole('superadmin'), 'admin.body.partials._accounts')

    </ul>

</div>

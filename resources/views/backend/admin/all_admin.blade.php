@extends('admin.admin_dashboard')
@section('admin')

<style>
    /* ================= CSS VARIABLES - KIHBT BROWN THEME ================= */
    :root {
        /* Brand Colors */
        --primary: #3b2818;           /* KIHBT Brown */
        --primary-light: #5a3d2b;     /* Lighter Brown */
        --primary-dark: #2a1a0f;      /* Darker Brown */
        --accent: #f9a90f;            /* KIHBT Gold */
        --accent-hover: #d18b00;      /* Darker Gold */
        
        /* Semantic Colors */
        --secondary: #858585;
        --success: #099139;
        --warning: #f9a90f;
        --danger: #b3261e;
        --info: #3b2818;
        
        /* Backgrounds */
        --bg-card: #ffffff;
        --bg-soft: #f5f6f5;
        --bg-gradient: linear-gradient(135deg, #fffefc, #ffffff);
        --bg-accent: rgba(249, 169, 15, 0.1);
        --bg-primary: rgba(59, 40, 24, 0.05);
        
        /* Borders */
        --border-light: #e8e8e8;
        --border-primary: rgba(59, 40, 24, 0.2);
        --border-accent: rgba(249, 169, 15, 0.3);
        
        /* Shadows */
        --shadow-sm: 0 2px 8px rgba(59, 40, 24, 0.06);
        --shadow-md: 0 6px 18px rgba(59, 40, 24, 0.08);
        --shadow-lg: 0 10px 25px rgba(59, 40, 24, 0.1);
        --shadow-hover: 0 12px 32px rgba(59, 40, 24, 0.15);
        
        /* Text */
        --text-primary: #26211d;
        --text-secondary: #858585;
        --text-on-primary: #ffffff;
        --text-on-accent: #000000;
        
        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        
        /* Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        
        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition-normal: 0.25s ease;
    }

    /* ================= PAGE CONTENT ================= */
    .page-content {
        padding: calc(var(--header-height, 60px) + var(--spacing-lg)) var(--spacing-lg) var(--spacing-lg);
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= BREADCRUMB ================= */
    .page-breadcrumb {
        background: var(--bg-gradient);
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--accent);
        margin-bottom: var(--spacing-xl);
    }

    .page-breadcrumb .breadcrumb-title {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
    }

    .page-breadcrumb .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
        transition: color var(--transition-fast);
    }

    .page-breadcrumb .breadcrumb-item a:hover {
        color: var(--accent);
    }

    .page-breadcrumb .breadcrumb-item.active {
        color: var(--secondary);
    }

    .page-breadcrumb .badge {
        font-weight: 600;
        padding: 0.35rem 0.6rem;
        margin-left: var(--spacing-sm);
    }

    /* ================= TABLE CARD ================= */
    .table-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .table-card .card-body {
        padding: var(--spacing-lg);
    }

    /* ================= TABLE STYLING ================= */
    .kihbt-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .kihbt-table thead {
        background: var(--bg-primary);
        border-bottom: 2px solid var(--border-primary);
    }

    .kihbt-table thead th {
        font-weight: 600 !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--primary);
        padding: var(--spacing-md) var(--spacing-lg);
        border: none;
    }

    .kihbt-table tbody td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.9rem;
        vertical-align: middle;
        color: var(--text-primary);
    }

    .kihbt-table tbody tr:hover {
        background: var(--bg-accent);
    }

    .kihbt-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ================= USER AVATAR ================= */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--accent);
        background: var(--bg-soft);
    }

    .user-avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-primary);
        color: var(--text-on-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* ================= ROLE BADGES ================= */
    .role-badge {
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .role-badge.bg-primary { background: var(--primary) !important; color: var(--text-on-primary) !important; }
    .role-badge.bg-success { background: var(--success) !important; color: var(--text-on-primary) !important; }
    .role-badge.bg-warning { background: var(--warning) !important; color: var(--text-on-accent) !important; }
    .role-badge.bg-danger { background: var(--danger) !important; color: var(--text-on-primary) !important; }
    .role-badge.bg-info { background: var(--info) !important; color: var(--text-on-primary) !important; }
    .role-badge.bg-secondary { background: var(--secondary) !important; color: var(--text-on-primary) !important; }

    /* ================= ACTION BUTTONS ================= */
    .action-btn {
        border-radius: var(--radius-sm);
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all var(--transition-fast);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border: none;
        margin: 0 0.2rem;
    }

    .action-btn.btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--text-on-primary);
    }

    .action-btn.btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: var(--text-on-primary);
    }

    .action-btn.btn-danger {
        background: linear-gradient(135deg, var(--danger), #9a2a20);
        color: var(--text-on-primary);
    }

    .action-btn.btn-danger:hover {
        background: linear-gradient(135deg, #9a2a20, var(--danger));
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: var(--text-on-primary);
    }

    /* ================= EMPTY STATE ================= */
    .empty-state {
        text-align: center;
        padding: var(--spacing-xl) var(--spacing-lg);
        color: var(--secondary);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--border-light);
        margin-bottom: var(--spacing-md);
        display: block;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin-bottom: var(--spacing-lg);
    }

    /* ================= ALERTS ================= */
    .alert {
        border-radius: var(--radius-md);
        padding: var(--spacing-md) var(--spacing-lg);
        border: none;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .alert-success {
        background: rgba(9, 145, 57, 0.1);
        color: var(--success);
        border-left: 4px solid var(--success);
    }

    .alert-danger {
        background: rgba(179, 38, 30, 0.1);
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }

    /* ================= BUTTONS ================= */
    .btn {
        border-radius: var(--radius-md);
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all var(--transition-fast);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--text-on-primary);
        box-shadow: 0 2px 4px rgba(59, 40, 24, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--text-on-primary);
    }

    /* ================= DATATABLES OVERRIDES ================= */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--radius-md);
        border: 1px solid var(--border-light);
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(249, 169, 15, 0.15);
        outline: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: var(--radius-sm) !important;
        margin: 0 2px !important;
        border: 1px solid var(--border-light) !important;
        background: var(--bg-card) !important;
        color: var(--primary) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--primary) !important;
        color: var(--text-on-primary) !important;
        border-color: var(--primary) !important;
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 991px) {
        .page-content { padding: var(--spacing-md); }
        .table-card .card-body { padding: var(--spacing-md); }
        .kihbt-table thead th,
        .kihbt-table tbody td { padding: var(--spacing-sm) var(--spacing-md); font-size: 0.85rem; }
        .action-btn { padding: 0.3rem 0.6rem; font-size: 0.8rem; margin: 0.1rem; }
        .user-avatar, .user-avatar-placeholder { width: 36px; height: 36px; font-size: 0.8rem; }
    }

    @media (max-width: 767px) {
        :root { --spacing-lg: 1.25rem; --spacing-xl: 1.5rem; }
        .page-content { padding: var(--spacing-sm); }
        .page-breadcrumb { padding: var(--spacing-sm) var(--spacing-md); }
        .page-breadcrumb .breadcrumb-title { font-size: 1rem; }
        .btn { width: 100%; justify-content: center; }
        .action-btn { width: auto; }
    }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; animation: none !important; }
    }

    .btn:focus, .action-btn:focus, a:focus {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    @media (prefers-contrast: high) {
        .table-card { border: 2px solid var(--primary); }
    }
</style>

<div class="page-content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Admin Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All Admins
                            <span class="badge bg-primary text-white">{{ count($alladminuser) }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>Add Admin
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="table-card">
                    <div class="card-body">

                        {{-- Success / Error Messages --}}
                        @if(session('message'))
                            <div class="alert alert-{{ session('alert-type') === 'success' ? 'success' : 'danger' }} mb-4">
                                <i class="bx bx-{{ session('alert-type') === 'success' ? 'check-circle' : 'error-circle' }} me-2"></i>
                                {{ session('message') }}
                            </div>
                        @endif

                        <table id="basic-datatable" class="kihbt-table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 70px;">Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th class="text-center" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alladminuser as $key => $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $key + 1 }}</td>
                                        <td>
                                            @if(!empty($item->photo))
                                                <img src="{{ asset('upload/admin_images/' . $item->photo) }}" 
                                                     alt="{{ $item->name }}" 
                                                     class="user-avatar">
                                            @else
                                                <div class="user-avatar-placeholder">
                                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="fw-semibold">{{ $item->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $item->email }}" class="text-primary">
                                                {{ $item->email }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($item->phone)
                                                <a href="tel:{{ $item->phone }}" class="text-primary">
                                                    {{ $item->phone }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($item->roles as $role)
                                                <span class="role-badge bg-primary">
                                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @if(Auth::user()->can('user.edit'))
                                                <a href="{{ route('admin.users.edit', $item->id) }}" 
                                                   class="action-btn btn-primary"
                                                   title="Edit admin">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                            @endif
                                            @if(Auth::user()->can('users.delete'))
                                                <a href="{{ route('admin.users.destroy', $item->id) }}" 
                                                   class="action-btn btn-danger js-confirm-form"
                                                   data-confirm-title="Delete Admin"
                                                   data-confirm-text="Are you sure you want to delete this admin? This action cannot be undone."
                                                   data-confirm-icon="warning"
                                                   data-confirm-button="Yes, delete"
                                                   title="Delete admin">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="bx bx-user-x"></i>
                                                <p class="mb-0">No admin users found.</p>
                                                <small class="text-muted">Add your first admin to get started.</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->

{{-- DataTables + SweetAlert Scripts --}}
@push('scripts')
<script>
    // Initialize DataTables with KIHBT styling
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search admins...",
                lengthMenu: "Show _MENU_ admins",
                info: "Showing _START_ to _END_ of _TOTAL_ admins",
                paginate: {
                    previous: "<i class='bx bx-chevron-left'></i>",
                    next: "<i class='bx bx-chevron-right'></i>"
                }
            },
            pageLength: 10,
            order: [[2, 'asc']] // Sort by name by default
        });
    });

    // SweetAlert confirm for delete actions
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-confirm-form').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: this.dataset.confirmTitle || 'Are you sure?',
                    text: this.dataset.confirmText || 'This action cannot be undone.',
                    icon: this.dataset.confirmIcon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b2818',  /* KIHBT Brown */
                    cancelButtonColor: '#d33',
                    confirmButtonText: this.dataset.confirmButton || 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = this.href;
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
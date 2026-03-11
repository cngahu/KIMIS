<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('adminbackend/assets/images/favicon-32x32.png') }}" type="image/png" />

    <link href="{{ asset('adminbackend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminbackend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminbackend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminbackend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminbackend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbackend/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbackend/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminbackend/assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminbackend/assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminbackend/assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="{{ asset('adminbackend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <title>@yield('title', 'Admin Dashboard')</title>

    <style>
        /* ================= KIHBT BRAND VARIABLES ================= */
        :root {
            --kihbt-primary: #3b2818;
            --kihbt-primary-light: #5a3d2b;
            --kihbt-primary-dark: #2a1a0f;
            --kihbt-accent: #f9a90f;
            --kihbt-accent-hover: #d18b00;
            --kihbt-header-height: 60px;
        }

        /* ============================================================
         * DESKTOP ONLY (≥992px):
         * Override app.css fixed/margin layout with flex.
         * Mobile (<992px) is completely untouched — app.css handles it.
         * ============================================================ */
        @media (min-width: 992px) {

            .wrapper {
                display: flex !important;
                flex-direction: row !important;
                align-items: stretch !important;
                min-height: 100vh !important;
                width: 100% !important;
                position: relative !important;
                overflow-x: hidden !important;
            }

            /* Pull sidebar out of fixed positioning into flex flow */
            .sidebar-wrapper {
                position: relative !important;
                top: auto !important;
                bottom: auto !important;
                left: auto !important;
                height: auto !important;
                min-height: 100vh !important;
                flex-shrink: 0 !important;
                z-index: 1040 !important;
                /* ✅ KIHBT: Add subtle border */
                border-right: 1px solid rgba(59, 40, 24, 0.1);
            }

            /* Pull topbar out of fixed positioning into flex flow */
            .topbar {
                position: relative !important;
                top: auto !important;
                left: auto !important;
                right: auto !important;
                width: 100% !important;
            }

            /* Remove margin-left:250px and margin-top:60px offsets */
            .page-wrapper {
                margin-left: 0 !important;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                flex: 1 !important;
                min-width: 0 !important;
                min-height: 0 !important;
                overflow-y: auto !important;
            }

            /* Pull footer out of fixed positioning */
            .page-footer {
                position: relative !important;
                left: auto !important;
                right: auto !important;
                bottom: auto !important;
                width: 100% !important;
                /* ✅ KIHBT: Subtle top border */
                border-top: 1px solid rgba(59, 40, 24, 0.1);
                background: #fff !important;
            }

            /* Main area: header + page-wrapper stacked in a column */
            .main-area {
                flex: 1 1 0% !important;
                min-width: 0 !important;
                display: flex !important;
                flex-direction: column !important;
            }

            /* Header: sticky at top of main-area */
            .kihbt-header {
                width: 100% !important;
                flex-shrink: 0 !important;
                position: sticky !important;
                top: 0 !important;
                z-index: 1030 !important;
                /* ✅ KIHBT: Brand-colored header */
                background: linear-gradient(135deg, var(--kihbt-primary), var(--kihbt-primary-dark)) !important;
                box-shadow: 0 2px 8px rgba(59, 40, 24, 0.15) !important;
            }

            /* ✅ PUSH CONTENT DOWNWARDS - Increased top padding */
            .page-wrapper > .page-content,
            .page-content {
                /* ✅ INCREASED: Added extra spacing to push content down */
                padding: calc(var(--kihbt-header-height) + 2rem) 3rem 2rem !important;
                max-width: 1400px;
                margin: 0 auto;
            }

            /* ✅ KIHBT: Add subtle background to page content */
            .page-content {
                background: linear-gradient(135deg, #fffefc, #ffffff);
            }

            /* ✅ KIHBT: Style breadcrumbs if present */
            .page-breadcrumb {
                background: rgba(249, 169, 15, 0.1) !important;
                border-left: 4px solid var(--kihbt-accent) !important;
                border-radius: 8px !important;
                padding: 0.75rem 1rem !important;
                margin-bottom: 1.5rem !important;
            }

            .page-breadcrumb .breadcrumb-item a {
                color: var(--kihbt-primary) !important;
                text-decoration: none;
            }

            .page-breadcrumb .breadcrumb-item a:hover {
                color: var(--kihbt-accent) !important;
            }

            .page-breadcrumb .breadcrumb-item.active {
                color: #666 !important;
            }
        }

        /* ✅ MOBILE: Also push content down on small screens */
        @media (max-width: 991px) {
            .page-content {
                padding-top: calc(var(--kihbt-header-height, 60px) + 1.5rem) !important;
                padding-bottom: 1.5rem !important;
            }
        }

        /* ✅ KIHBT: Global link styling */
        a {
            color: var(--kihbt-primary);
            transition: color 0.15s ease;
        }
        a:hover {
            color: var(--kihbt-accent);
        }

        /* ✅ KIHBT: Button overrides */
        .btn-primary {
            background: linear-gradient(135deg, var(--kihbt-primary), var(--kihbt-primary-dark)) !important;
            border-color: var(--kihbt-primary) !important;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--kihbt-primary-dark), var(--kihbt-primary)) !important;
            transform: translateY(-1px);
        }

        /* ✅ KIHBT: Card accent border */
        .card {
            border-top: 3px solid var(--kihbt-accent) !important;
        }

        /* ✅ KIHBT: Table header styling */
        .table thead th {
            background: rgba(59, 40, 24, 0.05) !important;
            color: var(--kihbt-primary) !important;
            font-weight: 600 !important;
            border-bottom: 2px solid var(--kihbt-accent) !important;
        }

        /* ✅ KIHBT: Badge styling */
        .badge.bg-success { background: #099139 !important; }
        .badge.bg-warning { background: var(--kihbt-accent) !important; color: #000 !important; }
        .badge.bg-danger { background: #b3261e !important; }
        .badge.bg-secondary { background: #6c757d !important; }
        .badge.bg-info { background: #17a2b8 !important; }

        /* ✅ KIHBT: Alert styling */
        .alert-success {
            background: rgba(9, 145, 57, 0.1) !important;
            border-left: 4px solid #099139 !important;
            color: #099139 !important;
        }
        .alert-warning {
            background: rgba(249, 169, 15, 0.1) !important;
            border-left: 4px solid var(--kihbt-accent) !important;
            color: var(--kihbt-primary) !important;
        }
        .alert-danger {
            background: rgba(179, 38, 30, 0.1) !important;
            border-left: 4px solid #b3261e !important;
            color: #b3261e !important;
        }
    </style>
</head>

<body>

<div class="wrapper">

    {{-- ① Sidebar --}}
    @include('admin.body.sidebar')

    {{-- ② Main area (header + content + footer) --}}
    <div class="main-area">
        @include('admin.body.header')

        <div class="page-wrapper">
            @yield('admin')
        </div>

        @include('admin.body.footer')
    </div>

</div>

<div class="overlay toggle-icon"></div>

<a href="javascript:;" class="back-to-top">
    <i class='bx bxs-up-arrow-alt'></i>
</a>

<!-- Scripts -->
<script src="{{ asset('adminbackend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/jquery-knob/excanvas.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
<script>$(function() { $(".knob").knob(); });</script>

<script src="{{ asset('adminbackend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>$(document).ready(function() { $('#example').DataTable(); });</script>

<script src="{{ asset('adminbackend/assets/js/index.js') }}"></script>
<script src="{{ asset('adminbackend/assets/js/validate.min.js') }}"></script>
<script src="{{ asset('adminbackend/assets/js/app.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Toastr flash --}}
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}";
    switch(type){
        case 'info':    toastr.info("{{ Session::get('message') }}");    break;
        case 'success': toastr.success("{{ Session::get('message') }}"); break;
        case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
        case 'error':   toastr.error("{{ Session::get('message') }}");   break;
    }
    @endif
</script>

{{-- SweetAlert confirm --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-confirm-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title:             form.dataset.confirmTitle  || 'Are you sure?',
                    text:              form.dataset.confirmText   || 'This action cannot be undone.',
                    icon:              form.dataset.confirmIcon   || 'warning',
                    showCancelButton:  true,
                    confirmButtonColor: '#3b2818',  /* ✅ KIHBT Brown */
                    cancelButtonColor:  '#d33',
                    confirmButtonText: form.dataset.confirmButton || 'Yes, proceed',
                    cancelButtonText:  form.dataset.cancelButton  || 'Cancel',
                    reverseButtons:    true,
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });
    });
</script>

</body>
</html>
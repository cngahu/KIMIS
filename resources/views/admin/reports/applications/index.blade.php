@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        @push('styles')
            <style>
                /* Table container */
                #applicationsTable_wrapper {
                    padding: 15px;
                    background: #ffffff;
                    border-radius: 12px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                }

                /* Header styling */
                table.dataTable thead th {
                    background: #003366 !important;
                    color: #fff !important;
                    font-weight: 600;
                    padding: 10px 12px !important;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    border-bottom: 2px solid #002244 !important;
                }

                /* Body rows */
                table.dataTable tbody td {
                    padding: 9px 12px !important;
                    border-color: #e6e6e6 !important;
                }

                /* Zebra striping */
                table.dataTable tbody tr:nth-child(even) {
                    background: #f8f9fa !important;
                }

                /* Hover effect */
                table.dataTable tbody tr:hover {
                    background: #eaf2fc !important;
                    transition: 0.2s;
                }

                /* Rounded table corners */
                table.dataTable {
                    border-radius: 10px !important;
                    overflow: hidden;
                }

                /* DataTable buttons */
                .dt-buttons .btn {
                    margin-right: 6px;
                    border-radius: 6px !important;
                    padding: 6px 12px;
                    font-size: 13px;
                }

                /* Search box styling */
                .dataTables_filter input {
                    border-radius: 6px;
                    border: 1px solid #ccc;
                    padding: 6px 10px;
                    width: 220px !important;
                }

                /* Pagination */
                .dataTables_paginate .paginate_button {
                    padding: 4px 10px !important;
                    margin: 2px;
                    border-radius: 6px !important;
                }

                .dataTables_paginate .paginate_button.current {
                    background: #003366 !important;
                    color: #fff !important;
                    border: none !important;
                }
            </style>
        @endpush


    @push('scripts')
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

            <!-- Export buttons -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        @endpush

        <h4 class="mb-3">All KNEC Applications Report</h4>

{{--        <!-- FILTER FORM -->--}}
{{--        <div class="card shadow-sm mb-4">--}}
{{--            <div class="card-body">--}}

{{--                <form id="filtersForm">--}}

{{--                    <div class="row">--}}

{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">From Date</label>--}}
{{--                            <input type="date" name="from_date" class="form-control">--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">To Date</label>--}}
{{--                            <input type="date" name="to_date" class="form-control">--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">Course</label>--}}
{{--                            <select name="course_id" class="form-select">--}}
{{--                                <option value="">All Courses</option>--}}
{{--                                @foreach($courses as $course)--}}
{{--                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label">Status</label>--}}
{{--                            <select name="status" class="form-select">--}}
{{--                                <option value="">All</option>--}}
{{--                                <option value="submitted">Submitted</option>--}}
{{--                                <option value="under_review">Under Review</option>--}}
{{--                                <option value="approved">Approved</option>--}}
{{--                                <option value="rejected">Rejected</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div class="mt-3 text-end">--}}
{{--                        <button type="button" class="btn btn-primary"--}}
{{--                                onclick="previewReport()">--}}
{{--                            Preview Report--}}
{{--                        </button>--}}
{{--                    </div>--}}

{{--                </form>--}}

{{--            </div>--}}
{{--        </div>--}}
        <div id="report-results">
            Loading...
        </div>
        <!-- PREVIEW MODAL -->
        <div class="modal fade" id="reportPreviewModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header" style="background:#003366; color:white;">
                        <h5 class="modal-title">Report Preview</h5>
                        <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="reportPreviewBody">
                        <!-- AJAX Loading Here -->
                    </div>

                    <div class="modal-footer">
                        <a id="downloadPdfBtn" class="btn btn-success" target="_blank">
                            Download PDF
                        </a>
                    </div>

                </div>
            </div>
        </div>


    </div>


    <script>
        function previewReport() {

            $('#reportPreviewBody').html('<p class="p-4 text-center">Loading...</p>');
            $('#reportPreviewModal').modal('show');

            $.get("{{ route('reports.applications.preview') }}",
                $('#filtersForm').serialize(),
                function(data) {
                    $('#reportPreviewBody').html(data);

                    // Set PDF download link
                    let pdfUrl = "{{ route('reports.applications.pdf') }}";
                    $('#downloadPdfBtn').attr('href', pdfUrl + '?' + $('#filtersForm').serialize());
                }
            );
        }


        document.addEventListener('DOMContentLoaded', function () {
            loadReport();
        });

        function loadReport() {
            let filters = $('#filtersForm').serialize();

            $('#report-results').html("Loading...");

            $.get("{{ route('reports.applications.data') }}", filters, function (html) {
                $('#report-results').html(html);
            });
        }
        let table = null;

        function loadReport() {
            $('#report-results').html('<p class="p-3">Loading...</p>');

            $.get("{{ route('reports.applications.data') }}", $('#filtersForm').serialize(), function(html) {
                $('#report-results').html(html);

                // Destroy existing table instance if exists
                if (table) {
                    table.destroy();
                }

                // Reinitialize DataTable
                table = $('#applicationsTable').DataTable({
                    pageLength: 25,
                    order: [[7, 'desc']], // Sort by date desc
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'excel', className: 'btn btn-success btn-sm', title: 'KNEC Applications Report' },
                        { extend: 'csv', className: 'btn btn-info btn-sm', title: 'KNEC Applications Report' },
                        { extend: 'print', className: 'btn btn-secondary btn-sm', title: 'KNEC Applications Report' }
                    ]
                });
            });
        }

    </script>

@endsection

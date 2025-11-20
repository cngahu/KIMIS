@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="mb-3">All Applications Report</h4>

        <!-- FILTER FORM -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <form id="filtersForm">

                    <div class="row">

                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Course</label>
                            <select name="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="submitted">Submitted</option>
                                <option value="under_review">Under Review</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-primary"
                                onclick="previewReport()">
                            Preview Report
                        </button>
                    </div>

                </form>

            </div>
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
    </script>

@endsection

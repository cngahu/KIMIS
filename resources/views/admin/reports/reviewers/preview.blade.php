<div class="modal fade" id="reportPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header" style="background:#003366; color:white;">
                <h5 class="modal-title">Report Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="reportPreviewBody">
                Loading...
            </div>

            <div class="modal-footer">
                <a id="downloadPdfBtn" class="btn btn-success" target="_blank">
                    Download PDF
                </a>
            </div>

        </div>
    </div>
</div>
<script>
    function previewReport(url, pdfUrl) {
        $('#reportPreviewBody').html('Loading...');
        $('#reportPreviewModal').modal('show');

        $.get(url, $('#filtersForm').serialize(), function(response){
            $('#reportPreviewBody').html(response);
            $('#downloadPdfBtn').attr('href', pdfUrl + '?' + $('#filtersForm').serialize());
        });
    }

</script>

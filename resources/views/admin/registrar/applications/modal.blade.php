<div class="modal fade" id="viewApplicationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header" style="background:#003366; color:white;">
                <h5 class="modal-title">Application Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="viewApplicationBody">
                <!-- AJAX-loaded content goes here -->
                <p class="text-center p-4">Loading...</p>
            </div>

        </div>
    </div>
</div>

<script>
    function loadApplication(id) {
        $('#viewApplicationBody').html('<p class="text-center p-4">Loading...</p>');

        $.get('/admin/registrar/applications/' + id)
            .done(function (html) {
                $('#viewApplicationBody').html(html);
            })
            .fail(function (xhr) {
                $('#viewApplicationBody').html('<pre class="text-danger p-2">' + xhr.responseText + '</pre>');
            });
    }
</script>

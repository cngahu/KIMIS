@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="mb-3">Rejected Applications Report</h4>

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
                                <option value="">All</option>
                                @foreach(\App\Models\Course::all() as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Reviewer</label>
                            <select name="reviewer_id" class="form-select">
                                <option value="">All</option>
                                @foreach($reviewers as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        <div id="report-results">
            <p class="p-3 text-muted">Apply filters to load rejected applications...</p>
        </div>

    </div>

    @push('scripts')
        <script>
            function loadRejected() {
                $('#report-results').html('<p class="p-3">Loading...</p>');

                $.get("{{ route('reports.decisions.rejected.data') }}",
                    $('#filtersForm').serialize(),
                    function(html) {
                        $('#report-results').html(html);
                    }
                );
            }

            $('#filtersForm input, #filtersForm select').on('change', function() {
                loadRejected();
            });
        </script>
    @endpush

@endsection

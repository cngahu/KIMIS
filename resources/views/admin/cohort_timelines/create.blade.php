@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <h6 class="mb-3">
                    Add Stage –
                    {{ $cohort->course->course_name }}
                    ({{ \Carbon\Carbon::create($cohort->intake_year, $cohort->intake_month)->format('M Y') }})
                </h6>

                <form method="POST"
                      action="{{ route('cohort_timelines.store', $cohort) }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stage</label>
                            <select name="course_stage_id"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Stage --</option>
                                @foreach($stages as $stage)
                                    <option value="{{ $stage->id }}">
                                        {{ $stage->code }} – {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

{{--                        <div class="col-md-4 mb-3">--}}
{{--                            <label class="form-label fw-bold">Start Date</label>--}}
{{--                            <input type="date"--}}
{{--                                   name="start_date"--}}
{{--                                   class="form-control"--}}
{{--                                   required>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 mb-3">--}}
{{--                            <label class="form-label fw-bold">End Date</label>--}}
{{--                            <input type="date"--}}
{{--                                   name="end_date"--}}
{{--                                   class="form-control"--}}
{{--                                   required>--}}
{{--                        </div>--}}

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Cycle</label>
                            <select name="cycle_month"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Cycle --</option>
                                <option value="1">January (Jan–Apr)</option>
                                <option value="5">May (May–Aug)</option>
                                <option value="9">September (Sep–Dec)</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Year</label>
                            <input type="number"
                                   name="cycle_year"
                                   class="form-control"
                                   value="{{ now()->year }}"
                                   required>
                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Save Stage
                    </button>

                    <a href="{{ route('cohort_timelines.index', $cohort) }}"
                       class="btn btn-secondary ms-2">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

@endsection

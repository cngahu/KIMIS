@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <h6 class="mb-3">
                    Edit Stage –
                    {{ $cohort->course->course_name }}
                    ({{ \Carbon\Carbon::create($cohort->intake_year, $cohort->intake_month)->format('M Y') }})
                </h6>

                <form method="POST"
                      action="{{ route('cohort_timelines.update', [$cohort, $timeline]) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Stage --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stage</label>
                            <select name="course_stage_id"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Stage --</option>
                                @foreach($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        @selected($stage->id == $timeline->course_stage_id)>
                                        {{ $stage->code }} – {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Cycle --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Cycle</label>
                            <select name="cycle_month"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Cycle --</option>
                                <option value="1" @selected($timeline->start_date->month == 1)>
                                    January (Jan–Apr)
                                </option>
                                <option value="5" @selected($timeline->start_date->month == 5)>
                                    May (May–Aug)
                                </option>
                                <option value="9" @selected($timeline->start_date->month == 9)>
                                    September (Sep–Dec)
                                </option>
                            </select>
                        </div>

                        {{-- Year --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Year</label>
                            <input type="number"
                                   name="cycle_year"
                                   class="form-control"
                                   value="{{ $timeline->start_date->year }}"
                                   required>
                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Update Stage
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

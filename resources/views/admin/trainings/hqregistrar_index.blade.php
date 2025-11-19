@extends('admin.admin_dashboard')

@section('admin')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Trainings Pending Registrar Approval</h1>
            <a href="{{ route('all.trainings') }}" class="btn btn-light border">
                Back to All Trainings
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        @if($trainings->count())
            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Campus</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Cost</th>
                            <th>Created By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trainings as $training)
                            <tr>
                                <td>{{ $loop->iteration + $trainings->firstItem() - 1 }}</td>
                                <td>
                                    <strong>{{ optional($training->course)->course_name ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        {{ optional($training->course)->course_code ?? '-' }}
                                    </small>
                                </td>
                                <td>{{ optional($training->college)->name ?? '-' }}</td>
                                <td>{{ $training->start_date ? $training->start_date->format('d M Y') : '-' }}</td>
                                <td>{{ $training->end_date ? $training->end_date->format('d M Y') : '-' }}</td>
                                <td>KSh {{ number_format($training->cost, 2) }}</td>
                                <td>{{ optional($training->user)->name ?? '-' }}</td>
                                <td class="text-center">

                                    <a href="{{ route('trainings.show', $training) }}"
                                       class="btn btn-sm btn-outline-info mb-1">
                                        View
                                    </a>

                                    <form action="{{ route('trainings.hq_review', $training) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-success mb-1"
                                                onclick="return confirm('Approve this training?');">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('trainings.hqReject', $training) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <textarea name="reason" class="form-control" rows="2" required
                                                  placeholder="Enter rejection comments for HOD..."></textarea>
                                        <button type="submit" class="btn btn-sm btn-danger mt-1">
                                            Reject
                                        </button>
                                    </form>

{{--                                    <form action="{{ route('trainings.registrar_reject', $training) }}"--}}
{{--                                          method="POST"--}}
{{--                                          class="d-inline">--}}
{{--                                        @csrf--}}
{{--                                        <button type="submit"--}}
{{--                                                class="btn btn-sm btn-danger mb-1"--}}
{{--                                                onclick="return confirm('Reject this training?');">--}}
{{--                                            Reject--}}
{{--                                        </button>--}}
{{--                                    </form>--}}

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-0">
                    {{ $trainings->links() }}
                </div>
            </div>
        @else
            <div class="alert alert-info">
                No trainings are currently HQ pending Registrar approval.
            </div>
        @endif
    </div>
@endsection

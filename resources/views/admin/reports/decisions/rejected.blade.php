@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <h4 class="mb-4">Rejected Applications</h4>

        <!-- FILTERS -->
        <form method="GET" class="mb-3">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Reviewer</label>
                    <select name="reviewer_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Reviewers</option>
                        @foreach($reviewers as $rev)
                            <option value="{{ $rev->id }}"
                                {{ request('reviewer_id') == $rev->id ? 'selected' : '' }}>
                                {{ $rev->name }} ({{ $rev->roles->pluck('name')->implode(', ') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('reports.rejected.pdf', request()->query()) }}"
                       class="btn btn-danger">
                        <i class="bx bx-download"></i> Export PDF
                    </a>
                </div>

            </div>
        </form>

        <!-- TABLE -->
        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Reference</th>
                        <th>Applicant</th>
                        <th>Course</th>
                        <th>Reviewer</th>
                        <th>Reason</th>
                        <th>Rejected On</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td>{{ $app->reference }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->course->course_name }}</td>
                            <td>
                                @if($app->reviewer)
                                    {{ $app->reviewer->surname }},
                                    {{ $app->reviewer->firstname }}
                                    {{ $app->reviewer->othername ? ' '.$app->reviewer->othername : '' }}
                                @else
                                    -
                                @endif
                            </td>



                            <td>{{ $app->reviewer_comments }}</td>
                            <td>{{ $app->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No rejected applications found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection

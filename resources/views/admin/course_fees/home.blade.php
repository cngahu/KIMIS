@extends('admin.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <h5 class="mb-3">
            Course Fee Management
            <small class="text-muted">(Long Term Courses)</small>
        </h5>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th width="40%">Course</th>
                            <th width="20%">Code</th>
                            <th width="20%">College</th>
                            <th width="20%" class="text-center">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td>
                                    <strong>{{ $course->course_name }}</strong>
                                </td>

                                <td>
                                    <code>{{ $course->course_code }}</code>
                                </td>

                                <td>
                                    {{ $course->college?->name ?? '—' }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('course_fees.index', $course) }}"
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-money-bill"></i> Fees
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No long-term courses found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection

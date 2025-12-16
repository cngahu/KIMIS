@extends('admin.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <h5 class="mb-3">
            {{ $cohort->course->course_name }}
            <small class="text-muted">
                ({{ \Carbon\Carbon::create(
                $cohort->intake_year,
                $cohort->intake_month
            )->format('M Y') }})
            </small>
        </h5>
        <a href="{{ route('timeline.cohort.pdf', $cohort) }}" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> PDF
        </a>
        @if(!$matrix['has_timeline'])
            <div class="alert alert-warning">
                Timeline not provided for this cohort.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>Course / Intake</th>
                        @foreach($matrix['columns'] as $col)
                            <th>{{ \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y') }}</th>
                        @endforeach
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($matrix['rows'] as $row)
                        <tr>
                            <th class="text-start">{{ $row['label'] }}</th>
                            @foreach($matrix['columns'] as $col)
                                <td>
                                    {{ $row['cells'][$col]['code'] ?? '' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
@endsection

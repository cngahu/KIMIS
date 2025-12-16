@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">
                    <tr>
                        <th width="25%">Code</th>
                        <td><code>{{ $stage->code }}</code></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $stage->name }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ ucfirst($stage->stage_type) }}</td>
                    </tr>
                    <tr>
                        <th>Billable</th>
                        <td>
                            @if($stage->is_billable)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created On</th>
                        <td>{{ $stage->created_at->format('d M Y') }}</td>
                    </tr>
                </table>

                <a href="{{ route('course_stages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>

            </div>
        </div>

    </div>

@endsection

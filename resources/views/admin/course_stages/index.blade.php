@extends('admin.admin_dashboard')

@section('admin')

    <div class="container-fluid">

        <a href="{{ route('course_stages.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus me-1"></i> Add Course Stage
        </a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Billable</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($stages as $stage)
                        <tr>
                            <td>{{ $stages->firstItem() + $loop->index }}</td>
                            <td><code>{{ $stage->code }}</code></td>
                            <td>{{ $stage->name }}</td>
                            <td>
                            <span class="badge bg-info">
                                {{ ucfirst($stage->stage_type) }}
                            </span>
                            </td>
                            <td>
                                @if($stage->is_billable)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('course_stages.show', $stage) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $stages->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>

@endsection

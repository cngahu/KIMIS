@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0 fw-bold">Admission Document Types</h4>
                <small class="text-muted">Manage the master list of admission upload requirements</small>
            </div>

            <div>
                <a href="{{ route('admin.admission.documents.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Add Document Type
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card radius-10">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mandatory</th>
                            <th>Allowed Types</th>
                            <th>Max Size (MB)</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($docs as $doc)
                            <tr>
                                <td>{{ $doc->id }}</td>
                                <td>
                                    <strong>{{ $doc->name }}</strong>
                                    @if($doc->description)
                                        <br><small class="text-muted">{{ Str::limit($doc->description, 100) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($doc->is_mandatory)
                                        <span class="badge bg-danger">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>{{ $doc->file_types }}</td>
                                <td>{{ $doc->max_size }}</td>
                                <td>
                                    @if($doc->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.admission.documents.edit', $doc->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.admission.documents.delete', $doc->id) }}"
                                          method="POST" class="d-inline-block"
                                          onsubmit="return confirm('Delete this document type? This will remove all related references.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No document types defined yet.
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

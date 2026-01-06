@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0">System Error Logs</h4>

            {{-- Optional Clear Logs Button --}}
            <form action="{{ route('admin.logs.errors.clear') }}"
                  method="POST"
                  onsubmit="return confirm('This will permanently clear error logs. Continue?')">
                @csrf
                <button class="btn btn-outline-danger btn-sm">
                    <i class="bx bx-trash"></i> Clear Logs
                </button>
            </form>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success py-2">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger py-2">
                {{ session('error') }}
            </div>
        @endif

        {{-- Info Note --}}
        <div class="alert alert-info py-2 small">
            Showing the most recent system errors. Technical stack traces are intentionally hidden.
        </div>

        {{-- Table --}}
        <div class="card radius-10">
            <div class="card-body table-responsive">

                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date / Time</th>
                        <th>Error Message</th>
                        <th>Environment</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $index => $log)
                        <tr>
                            <td>{{ $logs->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-bold">
                                    {{ $log['time'] }}
                                </span>
                            </td>
                            <td>
                                <span class="text-danger">
                                    {{ $log['message'] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ strtoupper($log['env'] ?? 'N/A') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No error logs found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>

            {{-- Pagination --}}
            @if(method_exists($logs, 'hasPages') && $logs->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="small text-muted">
                            Showing
                            <strong>{{ $logs->firstItem() }}</strong>
                            to
                            <strong>{{ $logs->lastItem() }}</strong>
                            of
                            <strong>{{ $logs->total() }}</strong>
                            records
                        </div>

                        <nav aria-label="Error logs pagination">
                            {{ $logs->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>

    </div>

@endsection

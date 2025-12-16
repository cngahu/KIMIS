@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0">Masterdata (Student Finance / Academic Data)</h4>

            {{-- Upload Button --}}
            <form action="{{ route('masterdata.import') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="d-flex align-items-center gap-2">
                @csrf
                <input type="file"
                       name="file"
                       class="form-control form-control-sm"
                       required>
                <button class="btn btn-success btn-sm">
                    <i class="bx bx-upload"></i> Import Excel / CSV
                </button>
            </form>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success py-2">
                {{ session('success') }}
            </div>
        @endif

        @if(session('failures') && session('failures')->isNotEmpty())
            <div class="alert alert-warning py-2">
                <strong>Some rows were skipped:</strong>
                <ul class="mb-0">
                    @foreach(session('failures') as $failure)
                        <li>
                            Row {{ $failure->row() }} :
                            {{ implode(', ', $failure->errors()) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Danger Zone --}}
        <div class="card radius-10 mb-3 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong class="text-danger">Danger Zone</strong>
                    <div class="small text-muted">
                        This will permanently delete all masterdata records.
                    </div>
                </div>

                <form action="{{ route('masterdata.truncate') }}"
                      method="POST"
                      onsubmit="return confirm('This will delete ALL masterdata. Continue?')">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        <i class="bx bx-trash"></i> Delete All Masterdata
                    </button>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card radius-10">
            <div class="card-body table-responsive">

                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Admission No</th>
                        <th>Student Name</th>
                        <th>Campus</th>
                        <th>Department</th>
                        <th>Course</th>
                        <th>Code</th>
                        <th>Current</th>
                        <th>Intake</th>
                        <th>Balance</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>ID No</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rows as $index => $row)
                        <tr>
                            <td>{{ $rows->firstItem() + $index }}</td>
                            <td>{{ $row->admissionNo }}</td>
                            <td>{{ $row->full_name }}</td>
                            <td>{{ $row->campus ?? '-' }}</td>
                            <td>{{ $row->department ?? '-' }}</td>
                            <td>{{ $row->course_name ?? '-' }}</td>
                            <td>{{ $row->course_code ?? '-' }}</td>
                            <td>{{ $row->current ?? '-' }}</td>
                            <td>{{ $row->intake ?? '-' }}</td>
                            <td>
                                @if($row->balance !== null)
                                    <span class="fw-bold">
                                        {{ number_format($row->balance, 2) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $row->phone ?? '-' }}</td>
                            <td>{{ $row->email ?? '-' }}</td>
                            <td>{{ $row->idno ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center text-muted py-4">
                                No masterdata records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>

            {{-- Pagination --}}
            @if($rows->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="small text-muted">
                            Showing
                            <strong>{{ $rows->firstItem() }}</strong>
                            to
                            <strong>{{ $rows->lastItem() }}</strong>
                            of
                            <strong>{{ $rows->total() }}</strong>
                            records
                        </div>

                        <nav aria-label="Masterdata pagination">
                            {{ $rows->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>

    </div>

@endsection

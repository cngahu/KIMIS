@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0">User Management</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-user-plus"></i> Add User
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        {{-- Filters --}}
        <div class="card radius-10 mb-3">
            <div class="card-body">
                <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-end">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label mb-1">Search</label>
                        <input type="text"
                               name="search"
                               class="form-control form-control-sm"
                               placeholder="Name, email, phone, code..."
                               value="{{ request('search') }}">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label mb-1">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-3">
                        <label class="form-label mb-1">Role</label>
                        <select name="role" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ request('role') === $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit"
                                class="btn btn-sm btn-dark flex-fill">
                            Filter
                        </button>

                        @if(request('search') || request('status') || request('role'))
                            <a href="{{ route('admin.users.index') }}"
                               class="btn btn-sm btn-outline-secondary flex-fill">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card radius-10">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Roles</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                {{ $user->surname }} {{ $user->firstname }} {{ $user->othername }}
                            </td>
                            <td>
                                @if($user->code)
                                    <span class="badge bg-dark">{{ $user->code }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @forelse($user->roles as $role)
                                    <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                @empty
                                    <span class="text-muted">No role</span>
                                @endforelse
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Improved Pagination --}}
            @if($users->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="small text-muted">
                            Showing
                            <strong>{{ $users->firstItem() }}</strong>
                            to
                            <strong>{{ $users->lastItem() }}</strong>
                            of
                            <strong>{{ $users->total() }}</strong>
                            users
                        </div>

                        <nav aria-label="User pagination">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if($users->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bx bx-chevron-left fs-6"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                            <i class="bx bx-chevron-left fs-6"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if($page == $users->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                                            <i class="bx bx-chevron-right fs-6"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bx bx-chevron-right fs-6"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

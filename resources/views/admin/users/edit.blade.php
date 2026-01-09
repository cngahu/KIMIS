@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Edit User</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light border btn-sm">Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                Please correct the errors below.
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card radius-10">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Surname --}}
                        <div class="col-md-6">
                            <label class="form-label">Surname <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="surname"
                                   value="{{ old('surname', $user->surname) }}"
                                   class="form-control @error('surname') is-invalid @enderror"
                                   required>
                            @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Firstname --}}
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="firstname"
                                   value="{{ old('firstname', $user->firstname) }}"
                                   class="form-control @error('firstname') is-invalid @enderror"
                                   required>
                            @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Othername --}}
                        <div class="col-md-6">
                            <label class="form-label">Other Name</label>
                            <input type="text"
                                   name="othername"
                                   value="{{ old('othername', $user->othername) }}"
                                   class="form-control @error('othername') is-invalid @enderror">
                            @error('othername') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- City --}}
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text"
                                   name="city"
                                   value="{{ old('city', $user->city) }}"
                                   class="form-control @error('city') is-invalid @enderror">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text"
                                   name="address"
                                   value="{{ old('address', $user->address) }}"
                                   class="form-control @error('address') is-invalid @enderror">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Role --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                @php $selectedRole = old('role', $userRole); @endphp
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $selectedRole === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Campus --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Campus
                                <span id="campusRequiredMark" class="text-danger" style="display:none">*</span>
                            </label>
                            <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror">
                                <option value="">-- Select Campus --</option>
                                @foreach($campuses as $campus)
                                    @php $selectedCampus = (int) old('campus_id', $user->campus_id); @endphp
                                    <option value="{{ $campus->id }}" {{ $selectedCampus === (int)$campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }} ({{ $campus->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Campus is required for HOD accounts.</small>
                        </div>

                        {{-- Departments (HOD only) --}}
                        <div class="col-12" id="departments_wrapper" style="display:none;">
                            <label class="form-label">
                                Departments (HOD only) <span class="text-danger">*</span>
                            </label>

                            <div id="departments_box"
                                 class="border rounded p-2"
                                 style="max-height: 240px; overflow:auto; background:#fafafa;">
                                <div class="text-muted small">Select campus to load departments…</div>
                            </div>

                            @error('academic_department_ids')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                Tick one or more departments the HOD manages.
                                <strong>All courses under selected departments will be auto-assigned.</strong>
                            </small>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light border">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update User
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        (function () {
            const roleSelect   = document.querySelector('select[name="role"]');
            const campusSelect = document.querySelector('select[name="campus_id"]');

            const campusRequiredMark = document.getElementById('campusRequiredMark');

            const depWrap = document.getElementById('departments_wrapper');
            const depBox  = document.getElementById('departments_box');

            function isHod() {
                return roleSelect.value === 'hod';
            }

            function renderMessage(msg) {
                depBox.innerHTML = `<div class="text-muted small">${msg}</div>`;
            }

            function renderDepartments(departments, selectedIds) {
                if (!departments.length) {
                    renderMessage('No departments found for this campus.');
                    return;
                }

                depBox.innerHTML = departments.map(d => {
                    const checked = selectedIds.includes(String(d.id)) ? 'checked' : '';
                    const code = d.code ? `<span class="text-muted">(${d.code})</span>` : '';
                    return `
                <label class="d-flex align-items-start gap-2 py-1">
                    <input type="checkbox" name="academic_department_ids[]" value="${d.id}" ${checked} class="mt-1">
                    <span>${d.name} ${code}</span>
                </label>
            `;
                }).join('');
            }

            function toggleHodUI() {
                depWrap.style.display = isHod() ? '' : 'none';
                campusRequiredMark.style.display = isHod() ? 'inline' : 'none';

                if (!isHod()) {
                    depBox.innerHTML = '<div class="text-muted small">Departments hidden (role not HOD).</div>';
                }
            }

            async function loadDepartments() {
                toggleHodUI();
                if (!isHod()) return;

                const campusId = campusSelect.value;

                if (!campusId) {
                    renderMessage('Select campus to load departments…');
                    return;
                }

                renderMessage('Loading departments...');

                try {
                    const url = `{{ route('admin.departments.byCampus', ':id') }}`.replace(':id', campusId);
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' }});

                    if (!res.ok) {
                        renderMessage('Failed to load departments.');
                        return;
                    }

                    const departments = await res.json();

                    // Priority: old() after validation error; else use assigned departments from DB
                    const oldDepartments = @json(old('academic_department_ids', null));
                    const selectedIds = (oldDepartments !== null)
                        ? oldDepartments.map(String)
                        : @json($userAcademicDepartmentIds ?? []).map(String);

                    renderDepartments(departments, selectedIds);

                } catch (e) {
                    console.error(e);
                    renderMessage('Error loading departments.');
                }
            }

            roleSelect.addEventListener('change', loadDepartments);
            campusSelect.addEventListener('change', loadDepartments);

            // initial
            loadDepartments();
        })();
    </script>
@endsection

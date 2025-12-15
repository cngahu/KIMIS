@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Edit User</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light border btn-sm">Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">Please correct the errors below.</div>
        @endif

        <div class="card radius-10">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Row 1 --}}
                        <div class="col-md-3">
                            <label class="form-label">Surname *</label>
                            <input type="text" name="surname" value="{{ old('surname', $user->surname) }}"
                                   class="form-control @error('surname') is-invalid @enderror">
                            @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}"
                                   class="form-control @error('firstname') is-invalid @enderror">
                            @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Other Name</label>
                            <input type="text" name="othername" value="{{ old('othername', $user->othername) }}"
                                   class="form-control @error('othername') is-invalid @enderror">
                            @error('othername') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Row 2 --}}
                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                   class="form-control @error('city') is-invalid @enderror">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                   class="form-control @error('address') is-invalid @enderror">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Row 3 --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Role *</label>
                            <select name="role" id="role"
                                    class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role', $userRole) === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Campus</label>
                            <select name="campus_id" id="campus_id"
                                    class="form-select @error('campus_id') is-invalid @enderror">
                                <option value="">-- Select Campus --</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}"
                                        {{ (int)old('campus_id', $user->campus_id ?? 0) === $campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }} ({{ $campus->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Courses (HOD only) --}}
                        <div class="col-md-3" id="courses_wrapper" style="display:none;">
                            <label class="form-label">Courses (HOD only)</label>

                            <div id="courses_box" class="border rounded p-2" style="max-height:220px; overflow:auto;">
                                <div class="text-muted small">Select campus to load courses…</div>
                            </div>

                            @error('course_ids') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <small class="text-muted">Tick one or more courses the HOD manages.</small>
                        </div>



                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        (function () {
            const roleSelect = document.getElementById('role');
            const campusSelect = document.getElementById('campus_id');
            const wrapper = document.getElementById('courses_wrapper');
            const box = document.getElementById('courses_box');

            function showCourses(show) {
                wrapper.style.display = show ? '' : 'none';
                if (!show) box.innerHTML = '<div class="text-muted small">Courses hidden (role not HOD).</div>';
            }

            function renderMessage(msg) {
                box.innerHTML = `<div class="text-muted small">${msg}</div>`;
            }

            function renderCourses(courses, selectedIds) {
                if (!courses.length) {
                    renderMessage('No courses found for this campus.');
                    return;
                }

                box.innerHTML = courses.map(c => {
                    const checked = selectedIds.includes(String(c.id)) ? 'checked' : '';
                    return `
                <label class="d-flex align-items-start gap-2 py-1">
                    <input type="checkbox" name="course_ids[]" value="${c.id}" ${checked} class="mt-1">
                    <span>${c.course_name} <span class="text-muted">(${c.course_code})</span></span>
                </label>
            `;
                }).join('');
            }

            async function loadCourses() {
                const isHod = roleSelect.value === 'hod';
                const campusId = campusSelect.value;

                showCourses(isHod);
                if (!isHod) return;

                if (!campusId) {
                    renderMessage('Select campus to load courses…');
                    return;
                }

                renderMessage('Loading courses...');

                try {
                    const url = `{{ route('admin.courses.byCampus', ':id') }}`.replace(':id', campusId);
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' }});

                    if (!res.ok) {
                        const text = await res.text();
                        console.error('Courses fetch failed:', res.status, text);
                        renderMessage('Failed to load courses.');
                        return;
                    }

                    const courses = await res.json();

                    // old() first (validation error), else DB values
                    const selectedIds = @json(old('course_ids', $userCourseIds)).map(String);

                    renderCourses(courses, selectedIds);

                } catch (e) {
                    console.error(e);
                    renderMessage('Error loading courses.');
                }
            }

            roleSelect.addEventListener('change', loadCourses);
            campusSelect.addEventListener('change', loadCourses);

            loadCourses();
        })();
    </script>
@endsection

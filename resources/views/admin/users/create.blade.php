@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Create User</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light border btn-sm">Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">Please correct the errors below.</div>
        @endif

        <div class="card radius-10">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf




                        {{-- Row 1 --}}
                        <div class="col-md-3">
                            <label class="form-label">Surname *</label>
                            <input type="text" name="surname" value="{{ old('surname') }}"
                                   class="form-control @error('surname') is-invalid @enderror">
                            @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="firstname" value="{{ old('firstname') }}"
                                   class="form-control @error('firstname') is-invalid @enderror">
                            @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Other Name</label>
                            <input type="text" name="othername" value="{{ old('othername') }}"
                                   class="form-control @error('othername') is-invalid @enderror">
                            @error('othername') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Row 2 --}}
                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                   class="form-control @error('city') is-invalid @enderror">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                   class="form-control @error('address') is-invalid @enderror">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Row 3 --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Role *</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role') === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Campus</label>
                            <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror">
                                <option value="">-- Select Campus --</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}"
                                        {{ (int)old('campus_id') === $campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }} ({{ $campus->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Courses (HOD only) --}}
                        {{-- Departments (HOD only) --}}
                        <div class="col-md-6" id="departments_wrapper" style="display:none;">
                            <label class="form-label">Departments (HOD only)</label>

                            <div id="departments_box" class="border rounded p-2" style="max-height: 220px; overflow:auto;">
                                <div class="text-muted small">Select campus to load departments…</div>
                            </div>

                            @error('department_ids') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <small class="text-muted">Tick one or more departments the HOD manages.</small>
                        </div>

                        {{-- Courses (auto from departments) --}}
                        <div class="col-md-6" id="courses_wrapper" style="display:none;">
                            <label class="form-label">Courses (from selected departments)</label>

                            <div id="courses_box" class="border rounded p-2" style="max-height: 220px; overflow:auto;">
                                <div class="text-muted small">Select department(s) to load courses…</div>
                            </div>

                            @error('course_ids') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <small class="text-muted">Tick one or more courses under those departments.</small>
                        </div>


                    </div>


                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            Save User
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

            const depWrap = document.getElementById('departments_wrapper');
            const depBox  = document.getElementById('departments_box');

            const courseWrap = document.getElementById('courses_wrapper');
            const courseBox  = document.getElementById('courses_box');

            function showForHod(show) {
                depWrap.style.display = show ? '' : 'none';
                courseWrap.style.display = show ? '' : 'none';
                if (!show) {
                    depBox.innerHTML = '<div class="text-muted small">Departments hidden (role not HOD).</div>';
                    courseBox.innerHTML = '<div class="text-muted small">Courses hidden (role not HOD).</div>';
                }
            }

            function renderMessage(el, msg) {
                el.innerHTML = `<div class="text-muted small">${msg}</div>`;
            }

            function renderCheckboxList(el, items, name, selectedIds, labelFn) {
                if (!items.length) {
                    renderMessage(el, 'No records found.');
                    return;
                }
                el.innerHTML = items.map(x => {
                    const checked = selectedIds.includes(String(x.id)) ? 'checked' : '';
                    return `
              <label class="d-flex align-items-start gap-2 py-1">
                <input type="checkbox" name="${name}[]" value="${x.id}" ${checked} class="mt-1">
                <span>${labelFn(x)}</span>
              </label>
            `;
                }).join('');
            }

            function getCheckedValues(name) {
                return [...document.querySelectorAll(`input[name="${name}[]"]:checked`)].map(i => i.value);
            }

            async function loadDepartments() {
                const isHod = roleSelect.value === 'hod';
                const campusId = campusSelect.value;

                showForHod(isHod);
                if (!isHod) return;

                if (!campusId) {
                    renderMessage(depBox, 'Select campus to load departments…');
                    renderMessage(courseBox, 'Select department(s) to load courses…');
                    return;
                }

                renderMessage(depBox, 'Loading departments...');
                renderMessage(courseBox, 'Select department(s) to load courses…');

                const url = `{{ route('admin.departments.byCampus', ':id') }}`.replace(':id', campusId);
                const res = await fetch(url, { headers: { 'Accept': 'application/json' }});

                if (!res.ok) {
                    renderMessage(depBox, 'Failed to load departments.');
                    return;
                }

                const departments = await res.json();

                const oldDepartments = @json(old('department_ids', [])).map(String);
                renderCheckboxList(depBox, departments, 'department_ids', oldDepartments, d => `${d.name} (${d.code ?? ''})`);

                // attach listeners to newly rendered department checkboxes
                depBox.querySelectorAll('input[name="department_ids[]"]').forEach(cb => {
                    cb.addEventListener('change', loadCourses);
                });

                // load courses after restoring old department selections
                await loadCourses();
            }

            async function loadCourses() {
                const isHod = roleSelect.value === 'hod';
                if (!isHod) return;

                const campusId = campusSelect.value;
                const departmentIds = getCheckedValues('department_ids');

                if (!campusId) {
                    renderMessage(courseBox, 'Select campus to load courses…');
                    return;
                }

                if (!departmentIds.length) {
                    renderMessage(courseBox, 'Select department(s) to load courses…');
                    return;
                }

                renderMessage(courseBox, 'Loading courses...');

                const url = `{{ route('admin.courses.byDepartments') }}`;
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ campus_id: campusId, department_ids: departmentIds })
                });

                if (!res.ok) {
                    renderMessage(courseBox, 'Failed to load courses.');
                    return;
                }

                const courses = await res.json();
                const oldCourses = @json(old('course_ids', [])).map(String);

                renderCheckboxList(courseBox, courses, 'course_ids', oldCourses, c => `${c.course_name} (${c.course_code})`);
            }

            roleSelect.addEventListener('change', loadDepartments);
            campusSelect.addEventListener('change', loadDepartments);

            loadDepartments();
        })();
    </script>



@endsection

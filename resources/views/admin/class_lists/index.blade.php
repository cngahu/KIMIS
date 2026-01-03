@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-1">Class Lists</h4>
            <p class="text-muted mb-0">
                View and download class lists by campus, department, course and cohort
            </p>

        </div>

        {{-- Filters --}}
        <div class="card radius-10 mb-4">
            <div class="card-body">
                <div class="row g-3">

                    {{-- Campus --}}
                    <div class="col-md-3">
                        <label class="form-label">Campus</label>
                        <select id="campus" class="form-select">
                            <option value="">-- Select Campus --</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">
                                    {{ $campus->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <select id="department" class="form-select" disabled>
                            <option value="">-- Select Department --</option>
                        </select>
                    </div>

                    {{-- Course --}}
                    <div class="col-md-3">
                        <label class="form-label">Course</label>
                        <select id="course" class="form-select" disabled>
                            <option value="">-- Select Course --</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- Cohorts --}}
        <div class="card radius-10">
            <div class="card-body">

                <h6 class="fw-semibold mb-3">Cohorts</h6>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Intake</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="cohortsTable">
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">
                                Select a course to view cohorts.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    {{-- JS --}}
    <script>
        (function () {

            const campus     = document.getElementById('campus');
            const department = document.getElementById('department');
            const course     = document.getElementById('course');
            const cohortsTbl = document.getElementById('cohortsTable');

            const baseAdminUrl = "{{ url('/admin') }}";

            function resetSelect(select, placeholder) {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                select.disabled = true;
            }

            function emptyRow(msg) {
                return `<tr>
            <td colspan="3" class="text-muted text-center py-4">${msg}</td>
        </tr>`;
            }

            /* ================= CAMPUS ================= */
            campus.addEventListener('change', async () => {
                resetSelect(department, '-- Select Department --');
                resetSelect(course, '-- Select Course --');
                cohortsTbl.innerHTML = emptyRow('Select a course to view cohorts.');

                if (!campus.value) return;

                const res = await fetch(
                    "{{ route('admin.class-lists.departments', ':id') }}"
                        .replace(':id', campus.value)
                );

                const data = await res.json();
                department.disabled = false;

                data.forEach(d => {
                    department.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${d.id}">${d.name}</option>`
                    );
                });
            });

            /* ================= DEPARTMENT ================= */
            department.addEventListener('change', async () => {
                resetSelect(course, '-- Select Course --');
                cohortsTbl.innerHTML = emptyRow('Select a course to view cohorts.');

                if (!department.value) return;

                const res = await fetch(
                    "{{ route('admin.class-lists.courses', ':id') }}"
                        .replace(':id', department.value)
                );

                const data = await res.json();
                course.disabled = false;

                data.forEach(c => {
                    course.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${c.id}">
                    ${c.course_name} (${c.course_code})
                </option>`
                    );
                });
            });

            /* ================= COURSE ================= */
            course.addEventListener('change', async () => {
                if (!course.value) {
                    cohortsTbl.innerHTML = emptyRow('Select a course to view cohorts.');
                    return;
                }

                const res = await fetch(
                    "{{ route('admin.class-lists.cohorts', ':id') }}"
                        .replace(':id', course.value)
                );

                const data = await res.json();

                if (!data.length) {
                    cohortsTbl.innerHTML = emptyRow('No cohorts found.');
                    return;
                }

                cohortsTbl.innerHTML = '';

                data.forEach(c => {
                    const viewUrl  = `${baseAdminUrl}/courses/${course.value}/cohorts/${c.id}/class-list`;
                    const printUrl = `${baseAdminUrl}/courses/${course.value}/cohorts/${c.id}/class-list/print`;

                    cohortsTbl.insertAdjacentHTML(
                        'beforeend',
                        `<tr>
                    <td>${c.intake_year} / ${c.intake_month}</td>
                    <td>
                        <span class="badge bg-info">${c.status}</span>
                    </td>
                    <td class="text-end">
                        <a href="${viewUrl}"
                           class="btn btn-sm btn-outline-secondary">
                            View Class List
                        </a>

                        <a href="${printUrl}"
                           class="btn btn-sm btn-outline-primary">
                            Download Class List (PDF)
                        </a>
                    </td>
                </tr>`
                    );
                });
            });

        })();
    </script>

@endsection

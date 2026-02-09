@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Add New Student</h5>

                <form method="POST" action="{{ route('masterdata.store') }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Admission No</label>
                            <input type="text" name="admissionNo" class="form-control" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">-- Select Gender --</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Campus</label>
                            <select name="campus_id" id="campus_id" class="form-select" required>
                                <option value="">-- Select Campus --</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}">{{ $college->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">-- Select Department --</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label">Course</label>
                            <select name="course_id" id="course_id" class="form-select" required>
                                <option value="">-- Select Course --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Current Stage</label>
                            <select name="current" class="form-select" required>
                                <option value="">-- Select Stage --</option>
                                @foreach($courseStages as $stage)
                                    <option value="{{ $stage->code }}">{{ $stage->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Intake Month</label>
                            <select name="resolved_intake_month" class="form-select" required>
                                <option value="">-- Select Month --</option>
                                <option value="JAN">JAN</option>
                                <option value="MAY">MAY</option>
                                <option value="SEP">SEP</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Intake Year</label>
                            <select name="resolved_intake_year" class="form-select" required>
                                <option value="">-- Select Year --</option>
                                @for($year = 2021; $year <= 2027; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cohort</label>
                            <select name="cohort_id_provisional" id="cohort_id_provisional" class="form-select" required>
                                <option value="">-- Select Cohort --</option>
                            </select>
                        </div>



                        {{--                        <div class="col-md-4">--}}
{{--                            <label class="form-label">Intake</label>--}}
{{--                            <input type="text" name="intake" class="form-control">--}}
{{--                        </div>--}}

                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">National ID / Passport No</label>
                            <input
                                type="text"
                                name="idno"
                                class="form-control"
                                placeholder="e.g. 12345678 or A1234567"
                            >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Arrears</label>
                            <input type="number" step="0.01" name="balance" class="form-control">
                        </div>

                    </div>

                    <div class="mt-4">
{{--                        <button type="submit" class="btn btn-primary">Save Student</button>--}}
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Save Student
                        </button>

                        <a href="{{ route('masterdata.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <script>
        const campusSelect = document.getElementById('campus_id');
        const departmentSelect = document.getElementById('department_id');
        const courseSelect = document.getElementById('course_id');
        const cohortSelect = document.getElementById('cohort_id_provisional');

        const monthMap = {
            1: 'JAN',
            5: 'MAY',
            9: 'SEP'
        };

        campusSelect.addEventListener('change', function () {
            let collegeId = this.value;

            departmentSelect.innerHTML = '<option value="">Loading...</option>';
            courseSelect.innerHTML = '<option value="">Loading...</option>';
            cohortSelect.innerHTML = '<option value="">-- Select Cohort --</option>';

            if (!collegeId) {
                departmentSelect.innerHTML = '<option value="">-- Select Department --</option>';
                courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
                return;
            }

            // Load departments
            fetch(`/colleges/${collegeId}/departments`)
                .then(res => res.json())
                .then(data => {
                    departmentSelect.innerHTML = '<option value="">-- Select Department --</option>';
                    data.forEach(dept => {
                        departmentSelect.innerHTML +=
                            `<option value="${dept.id}">${dept.name}</option>`;
                    });
                });

            // Load courses (Long Term only)
            fetch(`/colleges/${collegeId}/courses`)
                .then(res => res.json())
                .then(data => {
                    courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
                    data.forEach(course => {
                        courseSelect.innerHTML +=
                            `<option value="${course.id}">${course.course_name}</option>`;
                    });
                });
        });

        courseSelect.addEventListener('change', function () {
            let courseId = this.value;
            cohortSelect.innerHTML = '<option value="">Loading...</option>';

            if (!courseId) {
                cohortSelect.innerHTML = '<option value="">-- Select Cohort --</option>';
                return;
            }

            fetch(`/courses/${courseId}/cohorts`)
                .then(res => res.json())
                .then(data => {
                    cohortSelect.innerHTML = '<option value="">-- Select Cohort --</option>';

                    if (!data.length) {
                        cohortSelect.innerHTML =
                            '<option value="">No cohorts found</option>';
                        return;
                    }

                    data.forEach(cohort => {
                        let label = `${monthMap[cohort.intake_month]} ${cohort.intake_year}`;
                        cohortSelect.innerHTML +=
                            `<option value="${cohort.id}">${label}</option>`;
                    });
                });
        });
    </script>

{{--    <script>--}}
{{--        const campusSelect = document.getElementById('campus_id');--}}
{{--        const departmentSelect = document.getElementById('department_id');--}}
{{--        const courseSelect = document.getElementById('course_id');--}}

{{--        campusSelect.addEventListener('change', function () {--}}
{{--            let collegeId = this.value;--}}

{{--            departmentSelect.innerHTML = '<option value="">Loading...</option>';--}}
{{--            courseSelect.innerHTML = '<option value="">Loading...</option>';--}}

{{--            if (!collegeId) {--}}
{{--                departmentSelect.innerHTML = '<option value="">-- Select Department --</option>';--}}
{{--                courseSelect.innerHTML = '<option value="">-- Select Course --</option>';--}}
{{--                return;--}}
{{--            }--}}

{{--            // Load departments--}}
{{--            fetch(`/colleges/${collegeId}/departments`)--}}
{{--                .then(res => res.json())--}}
{{--                .then(data => {--}}
{{--                    departmentSelect.innerHTML = '<option value="">-- Select Department --</option>';--}}
{{--                    data.forEach(dept => {--}}
{{--                        departmentSelect.innerHTML +=--}}
{{--                            `<option value="${dept.id}">${dept.name}</option>`;--}}
{{--                    });--}}
{{--                });--}}

{{--            // Load courses (Long Term only)--}}
{{--            fetch(`/colleges/${collegeId}/courses`)--}}
{{--                .then(res => res.json())--}}
{{--                .then(data => {--}}
{{--                    courseSelect.innerHTML = '<option value="">-- Select Course --</option>';--}}
{{--                    data.forEach(course => {--}}
{{--                        courseSelect.innerHTML +=--}}
{{--                            `<option value="${course.id}">${course.course_name}</option>`;--}}
{{--                    });--}}
{{--                });--}}
{{--        });--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        const courseSelect = document.getElementById('course_id');--}}
{{--        const cohortSelect = document.getElementById('cohort_id_provisional');--}}

{{--        const monthMap = {--}}
{{--            1: 'JAN',--}}
{{--            5: 'MAY',--}}
{{--            9: 'SEP'--}}
{{--        };--}}

{{--        courseSelect.addEventListener('change', function () {--}}
{{--            let courseId = this.value;--}}
{{--            cohortSelect.innerHTML = '<option value="">Loading...</option>';--}}

{{--            if (!courseId) {--}}
{{--                cohortSelect.innerHTML = '<option value="">-- Select Cohort --</option>';--}}
{{--                return;--}}
{{--            }--}}

{{--            fetch(`/courses/${courseId}/cohorts`)--}}
{{--                .then(res => res.json())--}}
{{--                .then(data => {--}}
{{--                    cohortSelect.innerHTML = '<option value="">-- Select Cohort --</option>';--}}

{{--                    if (data.length === 0) {--}}
{{--                        cohortSelect.innerHTML =--}}
{{--                            '<option value="">No cohorts found</option>';--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    data.forEach(cohort => {--}}
{{--                        let label = `${monthMap[cohort.intake_month]} ${cohort.intake_year}`;--}}

{{--                        let option = document.createElement('option');--}}
{{--                        option.value = cohort.id;--}}
{{--                        option.textContent = label;--}}

{{--                        cohortSelect.appendChild(option);--}}
{{--                    });--}}
{{--                });--}}
{{--        });--}}
{{--    </script>--}}
    <script>
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving...';
        });
    </script>

@endsection

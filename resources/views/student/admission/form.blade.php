@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-3">Admission Form</h4>

        <div class="card radius-10 p-4 shadow-sm">

            <form action="{{ route('student.admission.form.submit') }}" method="POST">
                @csrf

                {{-- PARENT/GUARDIAN --}}
                <h5 class="fw-bold mt-3">Parent / Guardian Details</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Parent Name *</label>
                        <input type="text" name="parent_name"
                               value="{{ old('parent_name', $admission->details->parent_name ?? '') }}"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Parent Phone *</label>
                        <input type="text" name="parent_phone"
                               class="form-control"
                               value="{{ old('parent_phone', $admission->details->parent_phone ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>ID Number</label>
                        <input type="text" name="parent_id_number"
                               class="form-control"
                               value="{{ old('parent_id_number', $admission->details->parent_id_number ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Relationship *</label>
                        <input type="text" name="parent_relationship"
                               class="form-control"
                               value="{{ old('parent_relationship', $admission->details->parent_relationship ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="parent_email"
                               class="form-control"
                               value="{{ old('parent_email', $admission->details->parent_email ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Occupation</label>
                        <input type="text" name="parent_occupation"
                               class="form-control"
                               value="{{ old('parent_occupation', $admission->details->parent_occupation ?? '') }}">
                    </div>
                </div>

                {{-- NEXT OF KIN --}}
                <h5 class="fw-bold mt-4">Next of Kin</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name *</label>
                        <input type="text" name="nok_name"
                               class="form-control"
                               value="{{ old('nok_name', $admission->details->nok_name ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone *</label>
                        <input type="text" name="nok_phone"
                               class="form-control"
                               value="{{ old('nok_phone', $admission->details->nok_phone ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Relationship *</label>
                        <input type="text" name="nok_relationship"
                               class="form-control"
                               value="{{ old('nok_relationship', $admission->details->nok_relationship ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Address *</label>
                        <input type="text" name="nok_address"
                               class="form-control"
                               value="{{ old('nok_address', $admission->details->nok_address ?? '') }}"
                               required>
                    </div>
                </div>

                {{-- EDUCATION --}}
                <h5 class="fw-bold mt-4">Education Background</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>School Attended *</label>
                        <input type="text" name="education_school"
                               class="form-control"
                               value="{{ old('education_school', $admission->details->education_school ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Year Completed *</label>
                        <input type="text" name="education_year"
                               class="form-control"
                               value="{{ old('education_year', $admission->details->education_year ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Index Number *</label>
                        <input type="text" name="education_index_number"
                               class="form-control"
                               value="{{ old('education_index_number', $admission->details->education_index_number ?? '') }}"
                               required>
                    </div>
                </div>

                {{-- EMERGENCY CONTACT --}}
                <h5 class="fw-bold mt-4">Emergency Contact</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Emergency Name *</label>
                        <input type="text" name="emergency_name"
                               class="form-control"
                               value="{{ old('emergency_name', $admission->details->emergency_name ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Emergency Phone *</label>
                        <input type="text" name="emergency_phone"
                               class="form-control"
                               value="{{ old('emergency_phone', $admission->details->emergency_phone ?? '') }}"
                               required>
                    </div>
                </div>

                <div class="mt-4">
                    <label>
                        <input type="checkbox" name="declaration" required>
                        I confirm that the above information is true and correct.
                    </label>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary px-4">
                        Save & Continue
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection

@extends('layouts.public')

@section('content')
    <section class="page-hero">
        <h1>Short Course Application</h1>
        <p>
            You are applying for:
            <strong>{{ optional($training->course)->course_name }} ({{ optional($training->course)->course_code }})</strong><br>
            Campus:
            <strong>{{ optional($training->college)->name }}</strong>
        </p>
    </section>

    <section class="px-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }} <br>

                        @if(session('total_amount'))
                            <strong>Total to pay:</strong>
                            KSh {{ number_format(session('total_amount'), 2) }}
                            @if(session('applicant_count'))
                                <span class="text-muted">
                    ({{ session('applicant_count') }} applicant{{ session('applicant_count') > 1 ? 's' : '' }})
                </span>
                            @endif
                        @endif
                    </div>
                @endif


            @if($errors->any())
                    <div class="alert alert-danger">
                        Please correct the errors below.
                    </div>
                @endif

                <form action="{{ route('short_trainings.store', $training) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="shortTrainingForm"
                      class="mt-3">
                    @csrf

                    {{-- FINANCIER BLOCK --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Financier</div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Who is paying? *</label>
                                <select name="financier"
                                        id="financierSelect"
                                        class="form-select @error('financier') is-invalid @enderror"
                                        required>
                                    <option value="">Select...</option>
                                    <option value="self" {{ old('financier') == 'self' ? 'selected' : '' }}>Self</option>
                                    <option value="employer" {{ old('financier') == 'employer' ? 'selected' : '' }}>Employer / Institution</option>
                                </select>
                                @error('financier')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Employer/Institution name only --}}
                            <div id="employerFields"
                                 style="display: {{ old('financier') === 'employer' ? 'block' : 'none' }};">

                                <div class="mb-3">
                                    <label class="form-label">Employer / Institution Name *</label>
                                    <input type="text"
                                           name="employer_name"
                                           value="{{ old('employer_name') }}"
                                           class="form-control @error('employer_name') is-invalid @enderror">
                                    @error('employer_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- APPLICANTS (REPEATABLE) --}}
                    <div class="card public-card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Applicant(s)</span>
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    id="addApplicantBtn">
                                <i class="la la-plus-circle"></i> Add Applicant
                            </button>
                        </div>
                        <div class="card-body" id="applicantsContainer">

                            @php
                                $oldApplicants = old('applicants', [ [] ]);
                            @endphp

                            @foreach($oldApplicants as $index => $oldApp)
                                <div class="applicant-block border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>Applicant #<span class="applicant-number">{{ $loop->iteration }}</span></strong>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger removeApplicantBtn"
                                                style="{{ $loop->count === 1 ? 'display:none;' : '' }}">
                                            Remove
                                        </button>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name *</label>
                                            <input type="text"
                                                   name="applicants[{{ $index }}][full_name]"
                                                   value="{{ $oldApp['full_name'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.full_name") is-invalid @enderror"
                                                   required>
                                            @error("applicants.$index.full_name")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">ID No</label>
                                            <input type="text"
                                                   name="applicants[{{ $index }}][id_no]"
                                                   value="{{ $oldApp['id_no'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.id_no") is-invalid @enderror">
                                            @error("applicants.$index.id_no")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text"
                                                   name="applicants[{{ $index }}][phone]"
                                                   value="{{ $oldApp['phone'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.phone") is-invalid @enderror">
                                            @error("applicants.$index.phone")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Email</label>
                                            <input type="email"
                                                   name="applicants[{{ $index }}][email]"
                                                   value="{{ $oldApp['email'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.email") is-invalid @enderror">
                                            @error("applicants.$index.email")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label">National ID (upload)</label>
                                            <input type="file"
                                                   name="applicants[{{ $index }}][national_id]"
                                                   class="form-control @error("applicants.$index.national_id") is-invalid @enderror">
                                            @error("applicants.$index.national_id")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="card public-card">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <p class="mb-3 mb-md-0 text-muted small">
                                Please confirm that the information provided is correct before submitting.
                            </p>

                            <button class="btn-primary-kihbt d-inline-flex align-items-center gap-2">
                                <i class="la la-paper-plane"></i> Submit Application
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const financierSelect = document.getElementById('financierSelect');
            const employerFields  = document.getElementById('employerFields');
            const applicantsContainer = document.getElementById('applicantsContainer');
            const addApplicantBtn = document.getElementById('addApplicantBtn');

            financierSelect?.addEventListener('change', function () {
                if (this.value === 'employer') {
                    employerFields.style.display = 'block';
                } else {
                    employerFields.style.display = 'none';
                }
            });

            function createApplicantBlock(index) {
                return `
            <div class="applicant-block border rounded p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>Applicant #<span class="applicant-number"></span></strong>
                    <button type="button"
                            class="btn btn-sm btn-outline-danger removeApplicantBtn">
                        Remove
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name *</label>
                        <input type="text"
                               name="applicants[${index}][full_name]"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">ID No</label>
                        <input type="text"
                               name="applicants[${index}][id_no]"
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="applicants[${index}][phone]"
                               class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="applicants[${index}][email]"
                               class="form-control">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">National ID (upload)</label>
                        <input type="file"
                               name="applicants[${index}][national_id]"
                               class="form-control">
                    </div>
                </div>
            </div>`;
            }

            function renumberApplicants() {
                const blocks = applicantsContainer.querySelectorAll('.applicant-block');
                blocks.forEach((block, idx) => {
                    const numSpan = block.querySelector('.applicant-number');
                    if (numSpan) numSpan.textContent = (idx + 1).toString();
                    const removeBtn = block.querySelector('.removeApplicantBtn');
                    if (removeBtn) removeBtn.style.display = (blocks.length === 1) ? 'none' : 'inline-block';
                });
            }

            addApplicantBtn?.addEventListener('click', function () {
                const currentCount = applicantsContainer.querySelectorAll('.applicant-block').length;
                const index = currentCount;
                const wrapper = document.createElement('div');
                wrapper.innerHTML = createApplicantBlock(index);
                applicantsContainer.appendChild(wrapper.firstElementChild);
                renumberApplicants();
            });

            applicantsContainer?.addEventListener('click', function (e) {
                if (e.target.closest('.removeApplicantBtn')) {
                    const blocks = applicantsContainer.querySelectorAll('.applicant-block');
                    if (blocks.length <= 1) return;
                    const block = e.target.closest('.applicant-block');
                    block.remove();
                    renumberApplicants();
                }
            });

            renumberApplicants();
        });
    </script>
@endpush

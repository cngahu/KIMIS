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
                                        {{-- Personal Information --}}
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

                                        {{-- Location Fields --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Home County *</label>
                                            <select name="applicants[{{ $index }}][home_county_id]"
                                                    class="form-select select2 @error("applicants.$index.home_county_id") is-invalid @enderror" required>
                                                <option value="">Choose...</option>
                                                @foreach($counties as $county)
                                                    <option value="{{ $county->id }}" {{ ($oldApp['home_county_id'] ?? '') == $county->id ? 'selected':'' }}>
                                                        {{ $county->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("applicants.$index.home_county_id")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Current County *</label>
                                            <select name="applicants[{{ $index }}][current_county_id]"
                                                    class="form-select select2 current-county @error("applicants.$index.current_county_id") is-invalid @enderror" required>
                                                <option value="">Choose...</option>
                                                @foreach($counties as $county)
                                                    <option value="{{ $county->id }}" {{ ($oldApp['current_county_id'] ?? '') == $county->id ? 'selected':'' }}>
                                                        {{ $county->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("applicants.$index.current_county_id")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Current Subcounty *</label>
                                            <select name="applicants[{{ $index }}][current_subcounty_id]"
                                                    class="form-select select2 current-subcounty @error("applicants.$index.current_subcounty_id") is-invalid @enderror" required>
                                                <option value="">Select county first</option>
                                                @if(isset($oldApp['current_county_id']))
                                                    @php
                                                        $countyId = $oldApp['current_county_id'];
                                                        $subcounties = \App\Models\Subcounty::where('county_id', $countyId)->get();
                                                    @endphp
                                                    @foreach($subcounties as $subcounty)
                                                        <option value="{{ $subcounty->id }}" {{ ($oldApp['current_subcounty_id'] ?? '') == $subcounty->id ? 'selected':'' }}>
                                                            {{ $subcounty->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error("applicants.$index.current_subcounty_id")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Postal Address *</label>
                                            <input type="text"
                                                   name="applicants[{{ $index }}][postal_address]"
                                                   value="{{ $oldApp['postal_address'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.postal_address") is-invalid @enderror"
                                                   required>
                                            @error("applicants.$index.postal_address")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Postal Code *</label>
                                            <select name="applicants[{{ $index }}][postal_code_id]"
                                                    class="form-select select2 @error("applicants.$index.postal_code_id") is-invalid @enderror" required>
                                                <option value="">Choose...</option>
                                                @foreach($postalCodes as $pc)
                                                    <option value="{{ $pc->id }}" {{ ($oldApp['postal_code_id'] ?? '') == $pc->id ? 'selected':'' }}>
                                                        {{ $pc->code }} - {{ $pc->town }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("applicants.$index.postal_code_id")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">C/O (optional)</label>
                                            <input type="text"
                                                   name="applicants[{{ $index }}][co]"
                                                   value="{{ $oldApp['co'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.co") is-invalid @enderror">
                                            @error("applicants.$index.co")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Town (optional)</label>
                                            <input type="text"
                                                   name="applicants[{{ $index }}][town]"
                                                   value="{{ $oldApp['town'] ?? '' }}"
                                                   class="form-control @error("applicants.$index.town") is-invalid @enderror">
                                            @error("applicants.$index.town")
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

            // Initialize Select2 for existing elements
            $('.select2').select2();

            // Financier toggle
            financierSelect?.addEventListener('change', function () {
                if (this.value === 'employer') {
                    employerFields.style.display = 'block';
                } else {
                    employerFields.style.display = 'none';
                }
            });

            // County change handler for dynamic subcounty loading
            function initCountyChangeHandler(block) {
                const countySelect = block.querySelector('.current-county');
                const subcountySelect = block.querySelector('.current-subcounty');

                if (countySelect && subcountySelect) {
                    $(countySelect).off('change').on('change', function () {
                        const countyId = $(this).val();
                        const url = '/api/counties/' + countyId + '/subcounties';

                        $(subcountySelect).html('<option>Loading...</option>');

                        $.get(url, function (data) {
                            let options = '<option value="">Choose...</option>';
                            data.forEach(sc => {
                                options += `<option value="${sc.id}">${sc.name}</option>`;
                            });
                            $(subcountySelect).html(options);
                        });
                    });
                }
            }

            // Initialize county handlers for existing blocks
            document.querySelectorAll('.applicant-block').forEach(block => {
                initCountyChangeHandler(block);
            });

            // Create applicant block HTML
            function createApplicantBlock(index) {
                return `
                <div class="applicant-block border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Applicant #<span class="applicant-number"></span></strong>
                        <button type="button" class="btn btn-sm btn-outline-danger removeApplicantBtn">Remove</button>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="applicants[${index}][full_name]" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">ID No</label>
                            <input type="text" name="applicants[${index}][id_no]" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="applicants[${index}][phone]" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="applicants[${index}][email]" class="form-control">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">National ID (upload)</label>
                            <input type="file" name="applicants[${index}][national_id]" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Home County *</label>
                            <select name="applicants[${index}][home_county_id]" class="form-select select2" required>
                                <option value="">Choose...</option>
                                @foreach($counties as $county)
                <option value="{{ $county->id }}">{{ $county->name }}</option>
                                @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Current County *</label>
                <select name="applicants[${index}][current_county_id]" class="form-select select2 current-county" required>
                                <option value="">Choose...</option>
                                @foreach($counties as $county)
                <option value="{{ $county->id }}">{{ $county->name }}</option>
                                @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Current Subcounty *</label>
                <select name="applicants[${index}][current_subcounty_id]" class="form-select select2 current-subcounty" required>
                                <option value="">Select county first</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Postal Address *</label>
                            <input type="text" name="applicants[${index}][postal_address]" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Postal Code *</label>
                            <select name="applicants[${index}][postal_code_id]" class="form-select select2" required>
                                <option value="">Choose...</option>
                                @foreach($postalCodes as $pc)
                <option value="{{ $pc->id }}">{{ $pc->code }} - {{ $pc->town }}</option>
                                @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">C/O (optional)</label>
                <input type="text" name="applicants[${index}][co]" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Town (optional)</label>
                            <input type="text" name="applicants[${index}][town]" class="form-control">
                        </div>
                    </div>
                </div>`;
            }

            // Add new applicant
            addApplicantBtn?.addEventListener('click', function () {
                const currentCount = applicantsContainer.querySelectorAll('.applicant-block').length;
                const index = currentCount;
                const wrapper = document.createElement('div');
                wrapper.innerHTML = createApplicantBlock(index);
                const newBlock = wrapper.firstElementChild;
                applicantsContainer.appendChild(newBlock);

                // Initialize Select2 for new block
                $(newBlock).find('.select2').select2();

                // Initialize county change handler for new block
                initCountyChangeHandler(newBlock);

                renumberApplicants();
            });

            // Remove applicant
            applicantsContainer?.addEventListener('click', function (e) {
                if (e.target.closest('.removeApplicantBtn')) {
                    const blocks = applicantsContainer.querySelectorAll('.applicant-block');
                    if (blocks.length <= 1) return;
                    const block = e.target.closest('.applicant-block');
                    block.remove();
                    renumberApplicants();
                }
            });

            // Renumber applicants
            function renumberApplicants() {
                const blocks = applicantsContainer.querySelectorAll('.applicant-block');
                blocks.forEach((block, idx) => {
                    const numSpan = block.querySelector('.applicant-number');
                    if (numSpan) numSpan.textContent = (idx + 1).toString();
                    const removeBtn = block.querySelector('.removeApplicantBtn');
                    if (removeBtn) removeBtn.style.display = (blocks.length === 1) ? 'none' : 'inline-block';
                });
            }

            renumberApplicants();
        });
    </script>
@endpush

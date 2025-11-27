@extends('layouts.public')

@section('content')

    {{-- Hero --}}
    <section class="page-hero">
        <h1>Apply for Training</h1>
        <p>
            You are applying for:
            <strong>{{ $course->name }}</strong>
        </p>
    </section>

    <section class="px-4 pb-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf

                    <!-- HONEYPOT -->
                    <input type="text" name="website" style="display:none">

                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    {{-- PERSONAL INFORMATION --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Personal Information</div>
                        <div class="card-body">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}"
                                           class="form-control @error('full_name') is-invalid @enderror" required>
                                    @error('full_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ID Number <span class="text-danger" id="idNumberRequiredMark" style="display:none">*</span></label>
                                    <input type="text"
                                           id="idNumberInput"
                                           name="id_number"
                                           value="{{ old('id_number') }}"
                                           class="form-control @error('id_number') is-invalid @enderror">
                                    @error('id_number') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone (+254...) *</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="form-control @error('phone') is-invalid @enderror" required>
                                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror" required>
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Date of Birth *
                                        <small class="text-muted d-block" id="ageHint"></small>
                                    </label>
                                    <input type="date"
                                           id="dobInput"
                                           name="date_of_birth"
                                           value="{{ old('date_of_birth') }}"
                                           class="form-control @error('date_of_birth') is-invalid @enderror"
                                           required>
                                    @error('date_of_birth') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- LOCATION --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Location</div>
                        <div class="card-body">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label">Home County *</label>
                                    <select name="home_county_id"
                                            class="form-select select2 @error('home_county_id') is-invalid @enderror" required>
                                        <option value="">Choose...</option>
                                        @foreach($counties as $county)
                                            <option value="{{ $county->id }}" {{ old('home_county_id') == $county->id ? 'selected':'' }}>
                                                {{ $county->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('home_county_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Current County *</label>
                                    <select id="currentCounty"
                                            name="current_county_id"
                                            class="form-select select2 @error('current_county_id') is-invalid @enderror" required>
                                        <option value="">Choose...</option>
                                        @foreach($counties as $county)
                                            <option value="{{ $county->id }}" {{ old('current_county_id') == $county->id ? 'selected':'' }}>
                                                {{ $county->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('current_county_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Current Subcounty *</label>
                                    <select id="currentSubcounty"
                                            name="current_subcounty_id"
                                            class="form-select select2 @error('current_subcounty_id') is-invalid @enderror" required>
                                        <option value="">Select county first</option>
                                    </select>
                                    @error('current_subcounty_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- ADDRESS --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Address</div>
                        <div class="card-body">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label">Postal Address *</label>
                                    <input type="text" name="postal_address" value="{{ old('postal_address') }}"
                                           class="form-control @error('postal_address') is-invalid @enderror" required>
                                    @error('postal_address') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Postal Code *</label>
                                    <select name="postal_code_id"
                                            class="form-select select2 @error('postal_code_id') is-invalid @enderror" required>
                                        <option value="">Choose...</option>
                                        @foreach($postalCodes as $pc)
                                            <option value="{{ $pc->id }}" {{ old('postal_code_id') == $pc->id ? 'selected':'' }}>
                                                {{ $pc->code }} - {{ $pc->town }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('postal_code_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">C/O (optional)</label>
                                    <input type="text" name="co" value="{{ old('co') }}"
                                           class="form-control @error('co') is-invalid @enderror">
                                    @error('co') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Town (optional)</label>
                                    <input type="text" name="town" value="{{ old('town') }}"
                                           class="form-control @error('town') is-invalid @enderror">
                                    @error('town') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- OTHER DETAILS --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Other Details</div>
                        <div class="card-body">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label">Financier *</label>
                                    <select name="financier" class="form-select @error('financier') is-invalid @enderror" required>
                                        <option value="">Choose...</option>
                                        <option value="self" {{ old('financier')=='self' ? 'selected':'' }}>Self</option>
                                        <option value="parent" {{ old('financier')=='parent' ? 'selected':'' }}>Parent</option>
                                    </select>
                                    @error('financier') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">KCSE Mean Grade *</label>
                                    <select name="kcse_mean_grade"
                                            class="form-select @error('kcse_mean_grade') is-invalid @enderror"
                                            required>
                                        <option value="">Select grade...</option>

                                        @foreach([
                                            'A ', 'A-',
                                            'B+', 'B', 'B-',
                                            'C+', 'C', 'C-',
                                            'D+', 'D', 'D-',
                                            'E'
                                        ] as $grade)
                                            <option value="{{ $grade }}" {{ old('kcse_mean_grade') === $grade ? 'selected' : '' }}>
                                                {{ $grade }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('kcse_mean_grade')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                        </div>
                    </div>

                    {{-- FIXED UPLOAD DOCUMENTS --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Mandatory & Optional Uploads</div>
                        <div class="card-body">

                            <div class="row g-4">

                                {{-- Birth Certificate (required if < 18) --}}
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Birth Certificate
                                        <span class="text-danger" id="birthCertRequiredMark" style="display:none">*</span>
                                    </label>
                                    <input type="file"
                                           id="birthCertInput"
                                           name="birth_certificate"
                                           class="form-control @error('birth_certificate') is-invalid @enderror">
                                    @error('birth_certificate') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- National ID (required if >= 18) --}}
                                <div class="col-md-6">
                                    <label class="form-label">
                                        National ID
                                        <span class="text-danger" id="nationalIdRequiredMark" style="display:none">*</span>
                                    </label>
                                    <input type="file"
                                           id="nationalIdInput"
                                           name="national_id"
                                           class="form-control @error('national_id') is-invalid @enderror">
                                    @error('national_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- REQUIREMENTS (Dynamic AJAX) --}}
                    <div class="card public-card mb-4">
                        <div class="card-header">Required Documents</div>
                        <div class="card-body">
                            <div id="requirementsContainer">
                                <!-- Dynamically loaded -->
                            </div>
                        </div>
                    </div>

                    {{-- DECLARATION + SUBMIT --}}
                    <div class="card public-card">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                            <label class="d-flex align-items-center gap-2 mb-3 mb-md-0">
                                <input type="checkbox" name="declaration" required>
                                <span class="small">I confirm that the information provided is correct.</span>
                            </label>

                            <button class="btn-primary-kihbt d-inline-flex align-items-center gap-2">
                                <i class="la la-credit-card"></i>
                                Proceed to Payment
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
        $(document).ready(function () {

            $('.select2').select2();

            // Load subcounties
            $('#currentCounty').on('change', function () {
                let countyId = $(this).val();
                let url = '/api/counties/' + countyId + '/subcounties';

                $('#currentSubcounty').html('<option>Loading...</option>');

                $.get(url, function (data) {
                    let options = '<option value="">Choose...</option>';
                    data.forEach(sc => {
                        options += `<option value="${sc.id}">${sc.name}</option>`;
                    });
                    $('#currentSubcounty').html(options);
                });
            });

            @if(old('current_county_id'))
            $('#currentCounty').trigger('change');
            @endif

            // Load requirements
            loadRequirements();

            function loadRequirements() {
                $.get("{{ route('applications.requirements', $course->id) }}", function (reqs) {
                    let html = '';

                    reqs.forEach(r => {
                        if (r.type === 'upload') {
                            html += `
                          <div class="mb-3">
                            <label class="form-label">${r.course_requirement} ${r.required ? '*' : ''}</label>
                            <input type="file" name="requirements[${r.id}]" class="form-control">
                          </div>`;
                        } else {
                            html += `
                          <div class="mb-3">
                            <label class="form-label">${r.course_requirement} ${r.required ? '*' : ''}</label>
                            <input type="text" name="requirements[${r.id}]" class="form-control">
                          </div>`;
                        }
                    });

                    $('#requirementsContainer').html(html);
                });
            }

            // === AGE-BASED REQUIREMENTS ===
            const dobInput      = document.getElementById('dobInput');
            const idNumberInput = document.getElementById('idNumberInput');
            const nationalIdInput = document.getElementById('nationalIdInput');
            const birthCertInput  = document.getElementById('birthCertInput');

            const idNumberMark      = document.getElementById('idNumberRequiredMark');
            const nationalIdMark    = document.getElementById('nationalIdRequiredMark');
            const birthCertMark     = document.getElementById('birthCertRequiredMark');
            const ageHint           = document.getElementById('ageHint');

            function calculateAge(dobStr) {
                if (!dobStr) return null;
                const dob = new Date(dobStr);
                if (isNaN(dob.getTime())) return null;

                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                return age;
            }

            function updateAgeRequirements() {
                const dobVal = dobInput.value;
                const age = calculateAge(dobVal);

                // reset hints + required flags
                idNumberInput.removeAttribute('required');
                nationalIdInput.removeAttribute('required');
                birthCertInput.removeAttribute('required');

                idNumberMark.style.display   = 'none';
                nationalIdMark.style.display = 'none';
                birthCertMark.style.display  = 'none';
                ageHint.textContent          = '';

                if (age === null) return;

                if (age >= 18) {
                    // Adult: require ID number & National ID
                    idNumberInput.setAttribute('required', 'required');
                    nationalIdInput.setAttribute('required', 'required');

                    idNumberMark.style.display   = 'inline';
                    nationalIdMark.style.display = 'inline';

                    ageHint.textContent = `(Age: ${age}) Please provide ID Number and National ID.`;
                } else {
                    // Minor: require Birth Certificate
                    birthCertInput.setAttribute('required', 'required');
                    birthCertMark.style.display = 'inline';

                    ageHint.textContent = `(Age: ${age}) Please upload Birth Certificate.`;
                }
            }

            dobInput.addEventListener('change', updateAgeRequirements);

            // Trigger once on load (in case old value exists)
            updateAgeRequirements();

        });
    </script>
@endpush

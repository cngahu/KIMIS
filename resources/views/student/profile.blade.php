@extends('student.student_dashboard')
@section('title', 'Student Profile')

@section('student')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Student Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.student_dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profile View</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <div class="container">
        <div class="main-body">
            <div class="row">
                <!-- Left Profile Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">

                            {{-- ✅ FIXED: Use $student->user->photo --}}
                            <img src="{{ $student->user->photo ? asset('upload/student_images/' . $student->user->photo) : asset('adminbackend/assets/images/no-image.jpg') }}" 
                                class="rounded-circle p-1 bg-primary" width="110" alt="Profile Photo">

                            <div class="mt-3">
                                {{-- ✅ FIXED: Use proper user fields --}}
                                <h4>{{ $student->user->firstname ?? 'Unknown' }} {{ $student->user->surname ?? '' }}</h4>
                                <p class="text-secondary mb-1">{{ $student->user->email ?? 'No email' }}</p>
                                <p class="text-muted font-size-sm">{{ $student->user->address ?? 'No address' }}</p>
                            </div>
                        </div>

                        <hr class="my-4" />

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <h6 class="mb-0">Student ID</h6>
                                {{-- ✅ FIXED: Safe fallback chain --}}
                                <span class="text-secondary">{{ $student->student_number ?? $student->user->id ?? 'N/A' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <h6 class="mb-0">Phone</h6>
                                <span class="text-secondary">{{ $student->user->phone ?? 'Not provided' }}</span>
                            </li>
                            
                            @if($student->course)
                            <li class="list-group-item d-flex justify-content-between">
                                <h6 class="mb-0">Course</h6>
                                <span class="text-secondary">{{ $student->course->course_name ?? 'N/A' }}</span>
                            </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>

                <!-- Right Form Section -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            {{-- ✅ FIXED: Correct route and method --}}
                            <form method="POST" 
                                  action="{{ route('student.profile.update') }}" 
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')  {{-- ✅ Required for update --}}

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Username</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control"
                                               value="{{ $student->user->username ?? $student->user->email }}" disabled />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name *</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="firstname"
                                               class="form-control @error('firstname') is-invalid @enderror"
                                               value="{{ old('firstname', $student->user->firstname) }}" required />
                                        @error('firstname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Surname *</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="surname"
                                               class="form-control @error('surname') is-invalid @enderror"
                                               value="{{ old('surname', $student->user->surname) }}" required />
                                        @error('surname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email *</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $student->user->email) }}" required />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               value="{{ old('phone', $student->user->phone) }}" />
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="address"
                                               class="form-control @error('address') is-invalid @enderror"
                                               value="{{ old('address', $student->user->address) }}" />
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="city"
                                               class="form-control @error('city') is-invalid @enderror"
                                               value="{{ old('city', $student->user->city) }}" />
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Photo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="photo"
                                               class="form-control @error('photo') is-invalid @enderror"
                                               id="image" accept="image/*" />
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage"
                                             src="{{ $student->user->photo ? asset('upload/student_images/' . $student->user->photo) : asset('adminbackend/assets/images/no-image.jpg') }}"
                                             style="width:100px; height:100px; object-fit:cover;" 
                                             class="rounded border">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit"
                                               class="btn btn-primary px-4"
                                               value="Save Changes" />
                                        <a href="{{ route('student.student_dashboard') }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Image preview
    $('#image').change(function(e){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function(){
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>

@endsection
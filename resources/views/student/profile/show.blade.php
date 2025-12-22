@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <h4 class="fw-bold mb-4">My Profile</h4>

        <div class="row g-4">

            {{-- Profile Photo --}}
            <div class="col-md-4">
                <div class="card radius-10 shadow-sm p-4 text-center">

{{--                    <img src="{{ auth()->user()->photo--}}
{{--                        ? asset('storage/' . auth()->user()->photo)--}}
{{--                        : asset('images/default-avatar.png') }}"--}}
{{--                         class="rounded-circle mb-3"--}}
{{--                         width="140"--}}
{{--                         height="140"--}}
{{--                         style="object-fit:cover">--}}

                    <img src="{{ !empty(auth()->user()->photo)
    ? url('upload/admin_images/' . auth()->user()->photo)
    : url('upload/no_image.jpg') }}"
                         class="rounded-circle mb-3"
                         width="140"
                         height="140"
                         style="object-fit:cover">

                    <form method="POST"
                          action="{{ route('student.profile.photo') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <input type="file"
                               name="photo"
                               class="form-control mb-2"
                               required>

                        <button class="btn btn-outline-primary btn-sm">
                            Update Photo
                        </button>
                    </form>
                </div>
            </div>

            {{-- Bio Data --}}
            <div class="col-md-8">
                <div class="card radius-10 shadow-sm p-4">

                    <h6 class="fw-bold mb-3">Bio Data</h6>

                    <table class="table table-borderless">
                        <tr>
                            <th>Name</th>
                            <td>{{ auth()->user()->firstname }}</td>
                        </tr>
                        <tr>
                            <th>Admission No</th>
                            <td>{{ $student->student_number }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ auth()->user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ auth()->user()->phone }}</td>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <td>{{ $student->course->course_name ?? '-' }}</td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>

    </div>

@endsection

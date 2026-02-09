<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Hostel – KIHBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        body{
            font-family:'Poppins',sans-serif;
            background:#f5f6f5;
        }
        .select2-container .select2-selection--single{
            height:38px;
            padding:5px 10px;
            border-radius:6px;
            border:1px solid #ced4da;
        }
        .select2-selection__rendered{
            line-height:26px!important;
        }
        .select2-selection__arrow{
            height:36px!important;
        }
    </style>
</head>
<body>

<div class="container py-5" style="max-width:900px">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">

            <h3 class="fw-bold mb-2 text-primary">
                <i class="la la-bed me-1"></i> Hostel Booking
            </h3>
            <p class="text-muted mb-4">
                Apply for hostel accommodation for both short term and long term courses.
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('hostel.book.store') }}">
                @csrf

                {{-- Personal details --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ID / Passport Number</label>
                        <input type="text" name="id_number" class="form-control" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                </div>

                {{-- Course (with campus) --}}
                <div class="mb-4">
                    <label class="form-label">Course & Campus</label>
                    <select name="course_id" class="form-select select2" required>
                        <option value="">Search and select course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">
                                {{ $course->course_name }}
                                —
                                {{ optional($course->college)->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">
                        Start typing to search by course or campus.
                    </small>
                </div>

                {{-- Boarding type --}}
                <div class="mb-4">
                    <label class="form-label d-block">Boarding Type</label>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="boarding_type" value="half" required>
                        <label class="form-check-label">
                            Half Board
                        </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="boarding_type" value="full">
                        <label class="form-check-label">
                            Full Board
                        </label>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="la la-paper-plane me-1"></i> Apply for Hostel
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Search course or campus',
            allowClear: true,
            width: '100%'
        });
    });
</script>

</body>
</html>

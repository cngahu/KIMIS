<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            color: #3B2818;
            margin: 25px 35px;
        }

        .letter-header img {
            width: 100%;
            height: auto;
            margin-bottom: 2px;
        }

        .address-block {
            text-align: right;
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .section-title {
            font-weight: bold;
            color: #3B2818;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        p {
            margin: 5px 0;
        }

        ul {
            padding-left: 18px;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        ul li {
            margin-bottom: 3px;
        }

        .signature {
            margin-top: 20px;
        }

        .signature img {
            height: 30px;
            margin-bottom: -5px;
        }


        .footer-note {
            font-size: 11px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

@php
    $course  = optional($application->course);
    $college = optional($course->college);
    $reportDate = now()->addMonth()->startOfMonth();
@endphp

{{-- LETTERHEAD --}}
<div class="letter-header">
    <img src="{{ public_path('upload/admin_images/letterheader.png') }}" alt="KIHBT Letterhead">
</div>

{{-- ADDRESS BLOCK --}}
<div class="address-block">
    P. O BOX 57511-00200<br>
    NAIROBI<br>
    TEL: 0202465760-1 / 0115827053 / 0202390758<br>
    Email: principal@kihbt.ac.ke<br>
    {{ now()->format('jS F Y') }}
</div>

{{-- REF --}}
<p>
    REF: MOR&amp;T/R/KIHBT/ARC/{{ $course->course_code ?? '____' }}/{{ now()->format('Y') }}
</p>

{{-- TO --}}
<p>
    TO: {{ strtoupper($application->full_name) }}<br>
    E-CITIZEN CODE: {{ $application->reference ?? '_________' }}
</p>
<br>
<p> <strong>Dear Sir/Madam,</strong></p>
<br>
{{-- SUBJECT --}}
<p class="section-title">RE: ADMISSION FOR TRAINING.</p>

{{-- BODY --}}
<p>
    I am pleased to inform you that your application to join this Institution was successful.
    You are therefore offered to train at
    <strong>{{ $course->course_name }}</strong>
    ({{ $course->course_code }}),
    tenable in <strong>{{ $college->name }} Campus</strong>.
    The college is located <strong>{{ $college->location }}</strong>.
</p>

<p>
    You are expected to report to KIHBT – {{ $college->name }} Campus on
    <strong>{{ $reportDate->format('l jS F Y') }}</strong>.
</p>

{{-- DOCUMENTS --}}
<p class="section-title">Documents to Present</p>
<ul>
    <li>(a) Admission Letter</li>
    <li>(b) KIHBT Medical Form (KIHBT/Med/020)</li>
    <li>(c) Original & copy of ID (Student + Parent/Guardian)</li>
    <li>(d) Original & copy of Birth Certificate</li>
    <li>(e) KCSE & KCPE Certificates / Result Slips</li>
    <li>(f) Leaving Certificates</li>
    <li>(g) Two passport-size photos</li>
</ul>

<p>
    Your course includes industrial attachment. Firms require students to be insured against
    personal accident risks.
</p>

<p>
    Limited accommodation is available at <strong>KSh 23,000 per term</strong>.
    Boarders must bring their own personal effects.
</p>

<p>
    I look forward to having you join us as you commit to your future.
</p>

{{-- SIGNATURE BLOCK --}}
<div class="signature">
    Yours faithfully,<br>

    <img src="{{ public_path('upload/admin_images/sig.png') }}" alt="Signature"><br>

    <strong>MULAMULA BANDI</strong><br>
    FOR DIRECTOR - KIHBT
</div>

<p class="footer-note">Encls. Pg.1</p>


</body>
</html>

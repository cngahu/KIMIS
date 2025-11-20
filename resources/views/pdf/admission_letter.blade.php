<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; color: #099139; }
        .content { margin-top: 20px; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo/kihbt_logo.png') }}" height="80"><br>
    <div class="title">OFFICIAL ADMISSION LETTER</div>
    <div>Kenya Institute of Highways and Building Technology (KIHBT)</div>
</div>

<div class="content">
    <p>Date: {{ now()->format('d M Y') }}</p>

    <p>Dear <strong>{{ $application->full_name }}</strong>,</p>

    <p>
        Congratulations! We are pleased to inform you that your application for admission to the
        <strong>{{ $application->course->course_name }}</strong> programme at the
        <strong>Kenya Institute of Highways and Building Technology (KIHBT)</strong> has been successful.
    </p>

    <p>
        You are hereby offered provisional admission subject to compliance with all institute requirements
        including payment of fees as outlined in the attached fee structure document.
    </p>

    <p><strong>Reporting Instructions:</strong></p>

    <ul>
        <li>Report to your respective campus with your original certificates.</li>
        <li>Present this admission letter upon arrival.</li>
        <li>Ensure you have completed your school fee payment as per the attached schedule.</li>
    </ul>

    <p>
        We look forward to welcoming you to KIHBT and wish you every success in your studies.
    </p>

    <div class="signature">
        Regards,<br><br>
        <strong>Registrar – Admissions</strong><br>
        Kenya Institute of Highways and Building Technology (KIHBT)
    </div>
</div>

</body>
</html>

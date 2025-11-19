<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Received</title>
</head>
<body style="margin:0; padding:0; background:#F5F7FA; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:40px auto; background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

    <!-- Header -->
    <div style="background:#003366; padding:20px; color:white; text-align:center;">
        <img src="https://kihbt.ac.ke/sites/default/files/coat_of_arms_kihbt_0.png"
             alt="KIHBT Logo" style="max-height:60px; margin-bottom:10px;">
        <h2 style="margin:0; font-size:22px; font-weight:bold;">Kenya Institute of Highways & Building Technology</h2>
    </div>

    <!-- Body -->
    <div style="padding:30px; color:#333333; font-size:15px;">

        <p>Dear <strong>{{ $application->full_name }}</strong>,</p>

        <p>Thank you for submitting your application to the
            <strong>Kenya Institute of Highways & Building Technology (KIHBT)</strong>.</p>

        <p>We have successfully received your application for:</p>

        <h3 style="color:#003366; margin-top:10px;">
            {{ $application->course->name }}
        </h3>

        <p>Your unique application reference number is:</p>

        <div style="background:#003366; color:white; padding:12px 18px; border-radius:6px; font-size:18px; font-weight:bold; width:fit-content;">
            {{ $application->reference }}
        </div>

        <p style="margin-top:20px;">
            Our team will review your submission and communicate the next steps.
            You may be contacted if additional information or clarification is required.
        </p>

        <p style="margin-top:20px;">
            If you have any questions, feel free to reach us through the contacts provided on our website.
        </p>

        <p style="margin-top:25px;">
            Regards,<br>
            <strong>Admissions Office</strong><br>
            Kenya Institute of Highways & Building Technology (KIHBT)
        </p>

    </div>

    <!-- Footer -->
    <div style="background:#F4B400; padding:15px; text-align:center; font-size:13px; color:#003366;">
        © {{ date('Y') }} Kenya Institute of Highways & Building Technology. All Rights Reserved.
    </div>

</div>

</body>
</html>

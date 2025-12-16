<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Application Received</title>
</head>
<body style="margin:0; padding:0; background:#F5F7FA; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:40px auto; background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

    <!-- Header -->
    <div style="background:#003366; padding:20px; color:white; text-align:center;">
        <img src="https://kihbt.ac.ke/sites/default/files/coat_of_arms_kihbt_0.png"
             alt="KIHBT Logo" style="max-height:60px; margin-bottom:10px;">
        <h2 style="margin:0; font-size:22px; font-weight:bold;">New Application Notification</h2>
    </div>

    <!-- Body -->
    <div style="padding:30px; color:#333333; font-size:15px;">

        <p>Hello Team,</p>

        <p>A new applicant has successfully submitted and paid for a course application.</p>

        <div style="background:#F5F7FA; padding:15px; border-left:4px solid #F4B400; margin:20px 0;">
            <p>
                <strong>Applicant Name:</strong>
                {{ $application->salutation ? $application->salutation.' ' : '' }}{{ $application->full_name }}
            </p>

            <p><strong>Course Applied:</strong> {{ $application->course->course_name }}</p>
            <p><strong>Reference No:</strong> {{ $application->reference }}</p>
            <p><strong>Date Submitted:</strong> {{ $application->created_at->format('d M Y, h:i A') }}</p>
        </div>

        <p>Please log in to the admissions system to proceed with the review process.</p>

        <p style="margin-top:25px;">
            Regards,<br>
            <strong>KIHBT Application System</strong>
        </p>

    </div>

    <!-- Footer -->
    <div style="background:#F4B400; padding:15px; text-align:center; font-size:13px; color:#003366;">
        © {{ date('Y') }} Kenya Institute of Highways & Building Technology. All Rights Reserved.
    </div>

</div>

</body>
</html>

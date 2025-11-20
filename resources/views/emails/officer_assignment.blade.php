<!DOCTYPE html>
<html>
<body style="font-family: Arial; font-size: 15px;">

<p>Hello {{ $application->reviewer->surname }} {{ $application->reviewer->firstname }},</p>

<p>You have been assigned a new application for review.</p>

<p><strong>Applicant:</strong> {{ $application->full_name }}<br>
    <strong>Course:</strong> {{ $application->course_name }}<br>
    <strong>Reference:</strong> {{ $application->reference }}</p>

<p>Please log in to your officer dashboard to begin the evaluation.</p>

<p>Regards,<br>
    <strong>KIHBT Application System</strong></p>

</body>
</html>

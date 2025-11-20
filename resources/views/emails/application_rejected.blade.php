<!DOCTYPE html>
<html>
<body style="font-family: Arial; background: #f6f6f6; padding: 20px;">

<div style="max-width: 650px; margin: auto; background: white; padding: 30px; border-radius: 8px;">

    <h2 style="color:#cc0000;">Application Status – Not Successful</h2>

    <p>Dear <strong>{{ $application->full_name }}</strong>,</p>

    <p>
        Thank you for your interest in the
        <strong>{{ $application->course->course_name }}</strong> programme at the
        <strong>Kenya Institute of Highways and Building Technology (KIHBT)</strong>.
    </p>

    <p>
        After careful review of your application, we regret to inform you that your application
        was <strong>not successful</strong>.
    </p>

    @if($comments)
        <p><strong>Reason:</strong> {{ $comments }}</p>
    @endif

    <p>
        We encourage you to reapply in the next admission cycle or explore other courses we offer.
    </p>

    <p style="margin-top: 30px;">Regards,<br>
        <strong>Admissions Office</strong><br>
        Kenya Institute of Highways and Building Technology (KIHBT)
    </p>

</div>

</body>
</html>

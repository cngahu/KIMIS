<p>Dear {{ $admission->application->full_name }},</p>

<p>Your admission fee payment has been received successfully.</p>

<p><strong>Course:</strong> {{ $admission->application->course->course_name }}</p>
<p><strong>Amount Paid:</strong> KES {{ number_format($admission->required_fee, 2) }}</p>

<p>Thank you.</p>

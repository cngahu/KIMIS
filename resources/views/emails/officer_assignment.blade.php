<p>Hello {{ $application->reviewer->name }},</p>

<p>You have been assigned a new application for review.</p>

<p><strong>Applicant:</strong> {{ $application->full_name }}<br>
    <strong>Course:</strong> {{ $application->course->name }}<br>
    <strong>Reference:</strong> {{ $application->reference }}</p>

<p>Please log in to your dashboard to begin evaluation.</p>

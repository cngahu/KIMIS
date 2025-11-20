<!DOCTYPE html>
<html>
<body style="font-family: Arial; background: #f6f6f6; padding: 20px;">

<div style="max-width: 650px; margin: auto; background: white; padding: 30px; border-radius: 8px;">

    <h2 style="color:#099139;">Congratulations, {{ $application->full_name }}!</h2>

    <p>Your application for admission to <strong>KIHBT</strong> has been successfully <strong>approved</strong>.</p>

    <p>Please find attached:</p>
    <ul>
        <li><strong>Official Admission Letter</strong></li>
        <li><strong>Fee Structure</strong></li>
    </ul>

    <h3 style="margin-top: 30px;">Portal Login Details</h3>

    <p>You can now access the KIHBT Student Portal using the details below:</p>

    <p>
        <strong>Portal Link:</strong> https://kihbt.ac.ke/portal <br>
        <strong>Username:</strong> {{ $user->email }} <br>
    @if($password)
        <p><strong>Temporary Password:</strong> {{ $password }}</p>
    @else
        <p><strong>Password:</strong> Your existing portal password remains unchanged.</p>
        @endif

        </p>

    <p>Please log in and change your password immediately.</p>

    <p style="margin-top: 30px;">Welcome to the Kenya Institute of Highways and Building Technology.</p>

    <p>Regards,<br>
        <strong>KIHBT Admissions Office</strong></p>

</div>

</body>
</html>
<?php

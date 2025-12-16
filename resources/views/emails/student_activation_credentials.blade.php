<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
<h3>Dear {{ $studentName }},</h3>

<p>Your KIHBT Student Portal account has been activated successfully.</p>

<p><strong>Login Credentials:</strong></p>
<ul>
    <li><strong>Username (Admission No):</strong> {{ $username }}</li>
    <li><strong>Temporary Password:</strong> {{ $password }}</li>
</ul>

<p>
    For security, you will be required to change your password after logging in.
</p>

<p>
    Login here: <a href="{{ url('/login') }}">{{ url('/login') }}</a>
</p>

<p>Regards,<br>KIHBT ICT Support</p>
</body>
</html>

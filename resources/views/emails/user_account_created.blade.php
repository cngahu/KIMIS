<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<p>Hello {{ $user->firstname }} {{ $user->surname }},</p>

<p>Your account has been created successfully.</p>

<p><strong>Login Email:</strong> {{ $user->email }}</p>
<p><strong>Temporary Password:</strong> {{ $plainPassword }}</p>

<p>
    You will be required to change your password before you can continue.
    Please change it immediately after your first login.
</p>

<p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>

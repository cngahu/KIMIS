<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>KIHBT OTP Verification</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f7; font-family:Arial, sans-serif;">

<!-- Outer Container -->
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding: 20px 0;">

            <!-- Email Card -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

                <!-- Header Banner -->
                <tr>
                    <td style="
                background:#006699;
                padding: 25px 15px;
                text-align:center;
                color:#ffffff;
                font-size:22px;
                font-weight:bold;">
                        KIHBT Portal – Secure Login
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 30px 40px;">

                        <!-- Title -->
                        <h2 style="margin:0; font-size:22px; color:#006699; font-weight:700;">
                            🔐 Login Verification
                        </h2>

                        <p style="margin-top:20px; font-size:15px; color:#444;">
                            Hello <strong>{{ $user->name }}</strong>,
                        </p>

                        <p style="font-size:15px; color:#444; margin-bottom:20px;">
                            Your one-time password (OTP) for accessing your KIHBT account is:
                        </p>

                        <!-- OTP Box -->
                        <div style="
                    padding:18px 0;
                    background:#006699;
                    color:#ffffff;
                    text-align:center;
                    font-size:32px;
                    font-weight:bold;
                    letter-spacing:8px;
                    border-radius:6px;
                    margin:25px 0;
                ">
                            {{ $code }}
                        </div>

                        <p style="font-size:14px; color:#444;">
                            This code will <strong>expire in 5 minutes.</strong><br>
                            Please use it immediately to complete your login.
                        </p>

                        <!-- Login Info Box -->
                        <div style="
                    margin-top:25px;
                    background:#f1f5f9;
                    padding:15px 20px;
                    border-radius:6px;
                    border:1px solid #dce3eb;
                    font-size:14px;
                    color:#444;
                ">
                            <div style="margin-bottom:5px;">
                                <strong>Login attempt:</strong> {{ $date }}
                            </div>
                            <div>
                                <strong>IP Address:</strong> {{ $ip }}
                            </div>
                        </div>

                        <!-- Warning Box -->
                        <div style="
                    margin-top:25px;
                    background:#fff4e5;
                    padding:15px 20px;
                    border-left:4px solid #ffb300;
                    border-radius:4px;
                    font-size:14px;
                    color:#8a6d3b;
                ">
                            ⚠️ If you did not request this code, please ignore this email or contact support immediately.
                        </div>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="
                padding: 20px 10px;
                text-align:center;
                background:#f4f4f7;
                font-size:12px;
                color:#6b7280;
            ">
                        © {{ date('Y') }} Kenya Institute of Highways and Building Technology (KIHBT). All rights reserved.<br>
                        This is an automated message – please do not reply.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>

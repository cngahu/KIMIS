<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hostel Booking Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f6f5; padding:20px;">

<div style="max-width:600px;margin:0 auto;background:#ffffff;padding:25px;border-radius:8px;">
    <h2 style="color:#3b2818;">Hostel Booking Submitted</h2>

    <p>Dear {{ $booking->full_name }},</p>

    <p>
        Your hostel booking request has been received successfully.
        Below are the booking details:
    </p>

    <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td><strong>Reference</strong></td>
            <td>{{ $booking->reference }}</td>
        </tr>
        <tr>
            <td><strong>Course</strong></td>
            <td>{{ optional($booking->course)->course_name }}</td>
        </tr>
        <tr>
            <td><strong>Campus</strong></td>
            <td>{{ optional($booking->college)->name }}</td>
        </tr>
        <tr>
            <td><strong>Boarding Type</strong></td>
            <td>{{ ucfirst($booking->boarding_type) }} Board</td>
        </tr>
        <tr>
            <td><strong>Amount Payable</strong></td>
            <td>
                KSh {{ number_format($booking->metadata['boarding_fee'] ?? 0, 2) }}
            </td>
        </tr>
    </table>

    <p style="margin-top:20px;">
        Please proceed to payment using the link below:
    </p>

    <p>
        <a href="{{ route('hostel.booking.payment', $booking->reference) }}"
           style="display:inline-block;padding:10px 18px;background:#3b2818;color:#ffffff;text-decoration:none;border-radius:6px;">
            Proceed to Payment
        </a>
    </p>

    <p style="margin-top:25px;font-size:13px;color:#777;">
        If you did not initiate this booking, please ignore this email.
    </p>

    <p>Regards,<br><strong>KIHBT</strong></p>
</div>

</body>
</html>

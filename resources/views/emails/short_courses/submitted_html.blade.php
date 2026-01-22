<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Short Course Application Submitted</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f6f7f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 620px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 6px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header img {
            height: 80px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 20px;
            color: #0a664a;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .box {
            background: #f2f6f4;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .box p {
            margin: 5px 0;
        }
        .amount {
            font-size: 16px;
            font-weight: bold;
            color: #0a664a;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #0a664a;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <img src="{{ asset('adminbackend/assets/images/kihbtlogo.png') }}" alt="KIHBT">
        <h1>Application Submitted Successfully</h1>
    </div>

    <p>
        Dear
        <strong>
            {{ $application->financier === 'employer'
                ? $application->employer_contact_person
                : optional($application->participants->first())->full_name }}
        </strong>,
    </p>

    <p>
        We are pleased to inform you that your <strong>short course application</strong>
        has been successfully submitted to the <strong>Kenya Institute of Highway &amp; Building Technology (KIHBT)</strong>.
    </p>

    <div class="box">
        <p><strong>Application Reference:</strong> {{ $application->reference }}</p>
        <p><strong>Training:</strong> {{ optional($application->training)->name }}</p>
        <p><strong>Total Participants:</strong> {{ $application->total_participants }}</p>
        <p class="amount">
            Total Expected Fee:
            KES {{ number_format($application->metadata['total_amount'], 2) }}
        </p>
    </div>

    <p>
        <strong>Payments:</strong><br>
        You may pay the above amount either in full or through
        <strong>installments</strong>. Your balance will automatically update after
        each payment.
    </p>

    <p style="text-align:center;">
        <a href="{{ route('short_training.application.payment', $application->reference) }}"
           class="btn">
            Proceed to Payment
        </a>
    </p>

    <p>
        If you require a <strong>proforma invoice</strong> or any assistance,
        please contact the Accounts Office via
        <a href="mailto:accounts@kihbt.ac.ke">accounts@kihbt.ac.ke</a>.
    </p>

    <div class="footer">
        <p>
            Kenya Institute of Highway &amp; Building Technology<br>
            This is a system-generated email. Please do not reply.
        </p>
    </div>

</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Received</title>
</head>
<body style="margin:0; padding:0; background:#f5f6f5; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:40px auto; background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

    <!-- Header -->
    <div style="background:#3b2818; padding:20px; color:white; text-align:center;">
        <img src="https://kihbt.ac.ke/sites/default/files/coat_of_arms_kihbt_0.png"
             alt="KIHBT Logo" style="max-height:60px; margin-bottom:10px;">
        <h2 style="margin:0; font-size:22px; font-weight:bold;">
            Kenya Institute of Highways & Building Technology
        </h2>
    </div>

    <!-- Body -->
    <div style="padding:30px; color:#26211d; font-size:15px; line-height:1.6;">

        <p>Dear <strong>{{ $application->full_name }}</strong>,</p>

        <p>
            Thank you for submitting your application to the
            <strong>Kenya Institute of Highways & Building Technology (KIHBT)</strong>.
        </p>

        <p>We have successfully received your application for:</p>

        <h3 style="color:#3b2818; margin-top:10px; font-size:18px;">
            {{ $application->course->name }}
        </h3>

        <p>Your unique application reference number is:</p>

        <div style="background:#f9a90f; color:#3b2818; padding:12px 18px;
             border-radius:6px; font-size:18px; font-weight:bold; width:fit-content;">
            {{ $application->reference }}
        </div>

        <hr style="margin:25px 0; border:none; border-top:1px solid #ddd;">

        <!-- Applicant Details -->
        <h3 style="color:#3b2818; margin-bottom:10px;">Applicant Details</h3>
        <p><strong>Full Name:</strong> {{ $application->full_name }}</p>
        <p><strong>ID Number:</strong> {{ $application->id_number ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $application->phone }}</p>
        <p><strong>Email:</strong> {{ $application->email ?? 'N/A' }}</p>
        <p><strong>Date of Birth:</strong> {{ $application->date_of_birth ?? 'N/A' }}</p>

        <hr style="margin:25px 0; border:none; border-top:1px solid #ddd;">

        <!-- Address Details -->
        <h3 style="color:#3b2818; margin-bottom:10px;">Location & Address</h3>
        <p><strong>Home County:</strong> {{ optional($application->homeCounty)->name }}</p>
        <p><strong>Current County:</strong> {{ optional($application->homeCounty)->name }}</p>
        <p><strong>Current Subcounty:</strong> {{ optional($application->currentSubcounty)->name }}</p>
        <p><strong>Postal Address:</strong> {{ $application->postal_address }}</p>
        <p><strong>Postal Code:</strong>
            {{ optional($application->postalCode)->code }} {{ optional($application->postalCode)->town }}
        </p>
        <p><strong>C/O:</strong> {{ $application->co ?? 'N/A' }}</p>
        <p><strong>Town:</strong> {{ $application->town ?? 'N/A' }}</p>

        <hr style="margin:25px 0; border:none; border-top:1px solid #ddd;">

        <!-- Academic Details -->
        <h3 style="color:#3b2818; margin-bottom:10px;">Academic & Other Details</h3>
        <p><strong>KCSE Mean Grade:</strong> {{ $application->kcse_mean_grade }}</p>
        <p><strong>Financier:</strong> {{ ucfirst($application->financier) }}</p>

        <hr style="margin:25px 0; border:none; border-top:1px solid #ddd;">

        <!-- Uploaded Documents -->
        <h3 style="color:#3b2818; margin-bottom:10px;">Uploaded Documents</h3>

        <ul style="padding-left:18px; color:#26211d; font-size:15px;">
            <li>
                KCSE Certificate:
                <strong>{{ $application->kcse_certificate_path ? 'Received' : 'Not Provided' }}</strong>
            </li>
            <li>
                School Leaving Certificate:
                <strong>{{ $application->school_leaving_certificate_path ? 'Received' : 'Not Provided' }}</strong>
            </li>
            <li>
                Birth Certificate:
                <strong>{{ $application->birth_certificate_path ? 'Received' : 'Not Provided' }}</strong>
            </li>
            <li>
                National ID:
                <strong>{{ $application->national_id_path ? 'Received' : 'Not Provided' }}</strong>
            </li>
        </ul>

        <hr style="margin:25px 0; border:none; border-top:1px solid #ddd;">

        <p>
            Our admissions team will review your submission and communicate the next steps via SMS or email.
            You may be contacted if additional information is required.
        </p>

        <p style="margin-top:20px;">
            If you have any questions, feel free to reach us through the contacts on our official website.
        </p>

        <p style="margin-top:25px;">
            Regards,<br>
            <strong>Admissions Office</strong><br>
            Kenya Institute of Highways & Building Technology (KIHBT)
        </p>

    </div>

    <!-- Footer -->
    <div style="background:#3b2818; padding:15px; text-align:center; font-size:13px; color:white;">
        © {{ date('Y') }} Kenya Institute of Highways & Building Technology. All Rights Reserved.
    </div>

</div>

</body>
</html>

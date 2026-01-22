@component('mail::message')
    # Application Submitted Successfully 🎉

    Dear {{ $application->financier === 'employer'
    ? $application->employer_contact_person
    : $application->participants->first()->full_name }},

    Your **short course application** has been successfully submitted to **Kenya Institute of Highway & Building Technology (KIHBT)**.

    ---

    ### 📄 Application Details
    - **Application Reference:** **{{ $application->reference }}**
    - **Training:** {{ optional($application->training)->name }}
    - **Participants:** {{ $application->total_participants }}
    - **Total Expected Fee:**
    **KES {{ number_format($application->metadata['total_amount'], 2) }}**

    ---

    ### 💳 Payments (Important)
    You may pay the fees:
    - In **full**, or
    - In **installments**, at your convenience

    Your balance will automatically update after every payment.

    ---

    @component('mail::button', ['url' => route('short_training.application.payment', $application->reference)])
        Proceed to Payment
    @endcomponent

    ---

    If you need a **proforma invoice** or assistance, contact us via
    📧 **accounts@kihbt.ac.ke**

    Warm regards,
    **Accounts Office**
    Kenya Institute of Highway & Building Technology

@endcomponent

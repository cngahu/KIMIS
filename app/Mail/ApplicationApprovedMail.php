<?php

namespace App\Mail;
use App\Models\Application;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class ApplicationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Application $application;
    public User $user;
    public ?string $password; // <-- FIXED HERE
    public string $admissionLetter;
    public string $feeStructure;
    public string $medicalReport;
    public string $requirement;


    public function __construct($application, $user, $password, $admissionLetter, $feeStructure, $medicalReport, $requirement)
    {
        $this->application = $application;
        $this->user = $user;
        $this->password = $password;  // can be null now
        $this->admissionLetter = $admissionLetter;
        $this->feeStructure = $feeStructure;
        $this->medicalReport = $medicalReport;
        $this->requirement = $requirement;
    }

    public function build()
    {
        $courseCode = $this->application->course->course_code;

        $filenameMap = [
            'DHE' => '1_DIPLOMA IN HIGHWAYS ENGINEERING (DHE).pdf',
            'DLS' => '2_DIPLOMA IN LAND SURVEYING (DLS).pdf',
            'DQS' => '3_DIPLOMA IN QUANTITY SURVEYING (DQS).pdf',
            'ARCH' => '4_DIPLOMA IN ARCHITECTURE (ARCH).pdf',
            'BLD' => '5_DIPLOMA IN BUILDING CONSTRUCTION (BLD).pdf',
            'DCE' => '6_DIPLOMA IN CIVIL ENGINEERING (DCE).pdf',
            'DEP' => '7_DIPLOMA IN ELECTRICAL ENGINEERING-POWER OPTION (DEP).pdf',
            'ICT' => '8_DIPLOMA IN INFORMATION AND COMMUNICATION TECHNOLOGY (ICT).pdf',
            'MEA' => '9_DIPLOMA IN MECHANICAL ENGINEERING (AUTOMOTIVE OPTION) MEA.pdf',
            'MEC' => '10_DIPLOMA IN MECHANICAL ENGINEERING (CONSTRUCTION PLANT OPTION) MEC.pdf',
            'MEI' => '11_DIPLOMA IN MECHANICAL ENGINEERING (INDUSTRIAL PLANT OPTION) MEI.pdf',
            'CCRC' => '12_CRAFT CERTIFICATE IN ROADS CONSTRUCTION (CCRC).pdf',
            'PLMC' => '13_CRAFT CERTIFICATE IN PLUMBING (PLMC).pdf',
            'BLDC' => '14_CRAFT CERTIFICATE IN BUILDING TECHNOLOGY (BLDC).pdf',
            'ELIC' => '15_CRAFT CERTIFICATE IN ELECTRICAL INSTALLATION (ELIC).pdf',
            'MVMC' => '16_CRAFT CERTIFICATE IN AUTOMOTIVE TECHNOLOGY (MVMC).pdf',
            'CPM' => '17_NATIONAL SKILLS CERTIFICATE IN CONSTRUCTION PLANT MECHANICS (CPM).pdf',
            'PPF' => '18_NATIONAL SKILLS CERTIFICATE IN PLUMBING AND PIPE FITTING (PPF).pdf',
            'RAC' => '19_NATIONAL SKILLS CERTIFICATE IN REFRIGERATION AND AIR-CONDITIONING (RAC).pdf'
        ];

        $requirementFilename = $filenameMap[$courseCode] ?? 'Course_Requirements.pdf';

        return $this->subject('Your Admission to KIHBT Has Been Approved')
            ->view('emails.application_approved')
            ->attachData($this->admissionLetter, 'Admission_Letter.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($this->feeStructure, 'Fee_Structure.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($this->medicalReport, 'Medical_Report.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($this->requirement, $requirementFilename, [
                'mime' => 'application/pdf',
            ])
            ->with([
                'application' => $this->application,
                'user'        => $this->user,
                'password'    => $this->password,
            ]);
    }
//    public function build()
//    {
//        return $this->subject('Your Admission to KIHBT Has Been Approved')
//            ->view('emails.application_approved')
//            ->attachData($this->admissionLetter, 'Admission_Letter.pdf', [
//                'mime' => 'application/pdf',
//            ])
//            ->attachData($this->feeStructure, 'Fee_Structure.pdf', [
//                'mime' => 'application/pdf',
//            ])
//            ->attachData($this->medicalReport, 'medical_report.pdf', [
//                'mime' => 'application/pdf',
//            ])
//
//            ->attachData($this->requirement, $requirementFilename, [
//            'mime' => 'application/pdf',
//            ])
//            ->with([
//                'application' => $this->application,
//                'user'        => $this->user,
//                'password'    => $this->password,  // null is now valid
//            ]);
//    }

}


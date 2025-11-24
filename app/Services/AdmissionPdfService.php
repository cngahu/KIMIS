<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class AdmissionPdfService
{
//    public function generateAdmissionLetter($application)
//    {
//        return Pdf::loadView('pdf.admission_letter', compact('application'))
//            ->setPaper('A4')
//            ->output();  // returns raw PDF bytes
//    }

    public function generateAdmissionLetter($application)
    {
        // Load all required relationships
        $application->load([
            'course',
            'homeCounty',
            'currentCounty',
            'currentSubcounty',
            'invoice',
        ]);

        return Pdf::loadView('pdf.admission_letter', compact('application'))
            ->setPaper('A4')
            ->output();  // returns raw PDF bytes
    }

    public function generateFeeStructure($application)
    {
        return Pdf::loadView('pdf.fee_structure', compact('application'))
            ->setPaper('A4')
            ->output();  // returns raw PDF bytes
    }

    public function generatemedical($application)
    {
        return Pdf::loadView('pdf.medical_report', compact('application'))
            ->setPaper('A4')
            ->output();  // returns raw PDF bytes
    }


    public function generaterequirement($application)
    {
        $courseCode = $application->course->course_code;

        $viewMap = [
            'DHE' => 'pdf.requirements.1_DIPLOMA IN HIGHWAYS ENGINEERING (DHE)',
            'DLS' => 'pdf.requirements.2_DIPLOMA IN LAND SURVEYING (DLS)',
            'DQS' => 'pdf.requirements.3_DIPLOMA IN QUANTITY SURVEYING (DQS)',
            'ARCH' => 'pdf.requirements.4_DIPLOMA IN ARCHITECTURE (ARCH)',
            'BLD' => 'pdf.requirements.5_DIPLOMA IN BUILDING CONSTRUCTION (BLD)',
            'DCE' => 'pdf.requirements.6_DIPLOMA IN CIVIL ENGINEERING (DCE)',
            'DEP' => 'pdf.requirements.7_DIPLOMA IN ELECTRICAL ENGINEERING-POWER OPTION (DEP)',
            'ICT' => 'pdf.requirements.8_DIPLOMA IN INFORMATION AND COMMUNICATION TECHNOLOGY (ICT)',
            'MEA' => 'pdf.requirements.9_DIPLOMA IN MECHANICAL ENGINEERING (AUTOMOTIVE OPTION) MEA',
            'MEC' => 'pdf.requirements.10_DIPLOMA IN MECHANICAL ENGINEERING (CONSTRUCTION PLANT OPTION) MEC',
            'MEI' => 'pdf.requirements.11_DIPLOMA IN MECHANICAL ENGINEERING (INDUSTRIAL PLANT OPTION) MEI',
            'CCRC' => 'pdf.requirements.12_CRAFT CERTIFICATE IN ROADS CONSTRUCTION (CCRC)',
            'PLMC' => 'pdf.requirements.13_CRAFT CERTIFICATE IN PLUMBING (PLMC)',
            'BLDC' => 'pdf.requirements.14_CRAFT CERTIFICATE IN BUILDING TECHNOLOGY (BLDC)',
            'ELIC' => 'pdf.requirements.15_CRAFT CERTIFICATE IN ELECTRICAL INSTALLATION (ELIC)',
            'MVMC' => 'pdf.requirements.16_CRAFT CERTIFICATE IN AUTOMOTIVE TECHNOLOGY (MVMC)',
            'CPM' => 'pdf.requirements.17_NATIONAL SKILLS CERTIFICATE IN CONSTRUCTION PLANT MECHANICS (CPM)',
            'PPF' => 'pdf.requirements.18_NATIONAL SKILLS CERTIFICATE IN PLUMBING AND PIPE FITTING (PPF)',
            'RAC' => 'pdf.requirements.19_NATIONAL SKILLS CERTIFICATE IN REFRIGERATION AND AIR-CONDITIONING (RAC)'
        ];

        if (array_key_exists($courseCode, $viewMap)) {
            return Pdf::loadView($viewMap[$courseCode], compact('application'))
                ->setPaper('A4')
                ->output();
        }

        // Return a default PDF or throw an exception if course code not found
        return Pdf::loadView('pdf.requirements.default', compact('application'))
            ->setPaper('A4')
            ->output();
    }

}

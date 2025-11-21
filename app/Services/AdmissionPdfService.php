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


}

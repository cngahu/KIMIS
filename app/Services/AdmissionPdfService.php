<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class AdmissionPdfService
{
    public function generateAdmissionLetter($application)
    {
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
}

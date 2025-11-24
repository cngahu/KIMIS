<?php

namespace App\Services\Student;
use App\Models\AdmissionDetail;
use App\Models\Admission;
class AdmissionFormService
{

    public function saveAdmissionForm(Admission $admission, array $data)
    {
        // Store or update admission_details row
        AdmissionDetail::updateOrCreate(
            ['admission_id' => $admission->id],
            array_merge(
                $data,
                [
                    'declaration' => isset($data['declaration']) ? 1 : 0,

                    'student_id' => $admission->user_id,
                    'form_completed_at' => now(),
                ]
            )
        );


        // Update admission status
        $admission->update([
            'status' => 'form_submitted',
            'form_submitted_at' => now(),
        ]);

        return true;
    }
}

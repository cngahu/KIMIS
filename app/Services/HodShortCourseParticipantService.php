<?php

namespace App\Services;
use App\Models\AcademicDepartment;
use App\Models\ShortTraining;
use App\Models\ShortTrainingApplication;
use App\Models\Training;
use App\Models\User;
class HodShortCourseParticipantService
{
    public function getParticipants(Training $training, User $hod)
    {
        $this->authorize($training, $hod);

        return ShortTraining::with(['application'])
            ->where('training_id', $training->id)
            ->orderBy('full_name')
            ->get();
    }

    protected function authorize(Training $training, User $hod): void
    {
        $owns = AcademicDepartment::where('hod_user_id', $hod->id)
            ->where('id', $training->course->academic_department_id)
            ->exists();

        if (! $owns) {
            abort(403, 'Unauthorized access to participants.');
        }
    }
}


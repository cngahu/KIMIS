<?php

namespace App\Services;

use App\Models\AcademicDepartment;
use App\Models\ShortTrainingApplication;
use App\Models\Training;
use App\Models\User;

class HodShortCourseApplicationService
{
    public function getApplicationsForTraining(Training $training, User $hod)
    {
        $this->authorizeTraining($training, $hod);

        return ShortTrainingApplication::where('training_id', $training->id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function getRevenueStats(Training $training, User $hod): array
    {
        $this->authorizeTraining($training, $hod);

        $apps = ShortTrainingApplication::where('training_id', $training->id)->get();

        return [
            'total_applications' => $apps->count(),
            'total_participants' => $apps->sum('total_participants'),

            'paid_amount' => $apps->where('payment_status', 'paid')
                ->sum(fn ($a) => $a->total_participants * $training->cost),

            'unpaid_amount' => $apps->where('payment_status', '!=', 'paid')
                ->sum(fn ($a) => $a->total_participants * $training->cost),

            'paid_count' => $apps->where('payment_status', 'paid')->count(),
            'pending_count' => $apps->where('payment_status', 'pending')->count(),
        ];
    }

    protected function authorizeTraining(Training $training, User $hod)
    {
        $owns = AcademicDepartment::where('hod_user_id', $hod->id)
            ->where('id', optional($training->course)->academic_department_id)
            ->exists();

        if (! $owns) {
            abort(403, 'Unauthorized access to training.');
        }
    }
}


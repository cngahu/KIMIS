<?php

namespace App\Services;
use App\Models\Course;
use App\Models\CourseStageFee;
use Illuminate\Support\Facades\DB;
class CourseStageFeeService
{
    /**
     * Get stages with current fee + history
     */
    public function getCourseStageFees0(Course $course)
    {
        return $course->stages()->with([
            'fees' => function ($q) {
                $q->orderByDesc('effective_from');
            }
        ])->get();
    }
    public function getCourseStageFees(Course $course)
    {
        return $course->stages()->with([
            'fees' => function ($q) use ($course) {
                $q->where('course_id', $course->id)
                    ->orderByDesc('effective_from');
            }
        ])->get();
    }

    /**
     * Change fee safely (end old, create new)
     */
    public function changeFee(array $data)
    {
        return DB::transaction(function () use ($data) {

            // End current active fee if exists
            CourseStageFee::where('course_id', $data['course_id'])
                ->where('course_stage_id', $data['course_stage_id'])
                ->whereNull('effective_to')
                ->update([
                    'effective_to' => now()->subDay()
                ]);

            // Create new fee
            return CourseStageFee::create([
                'course_id'       => $data['course_id'],
                'course_stage_id' => $data['course_stage_id'],
                'amount'          => $data['amount'],
                'is_billable'     => $data['is_billable'],
                'effective_from'  => $data['effective_from'],
                'effective_to'    => null,
            ]);
        });
    }
}

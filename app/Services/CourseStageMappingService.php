<?php

namespace App\Services;
use App\Models\Course;
use App\Models\CourseStage;
use App\Models\CourseStageMapping;
use Illuminate\Support\Facades\DB;
class CourseStageMappingService
{
    /**
     * Get full structure for a course
     */
    public function getCourseStructure(Course $course)
    {
        return CourseStageMapping::with('stage')
            ->where('course_id', $course->id)
            ->orderBy('sequence_number')
            ->get();

    }

    /**
     * Replace course structure safely
     */
    public function saveStructure(Course $course, array $stageIds)
    {
        return DB::transaction(function () use ($course, $stageIds) {

            // Clear existing structure
            CourseStageMapping::where('course_id', $course->id)->delete();

            // Insert fresh structure
            foreach ($stageIds as $index => $stageId) {
                CourseStageMapping::create([
                    'course_id'       => $course->id,
                    'course_stage_id' => $stageId,
                    'sequence_number' => $index + 1,
                ]);
            }
        });
    }

    /**
     * All available stages (lookup)
     */
    public function allStages()
    {
        return CourseStage::orderBy('code')->get();
    }
}

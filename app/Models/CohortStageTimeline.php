<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CohortStageTimeline extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_cohort_id',
        'course_stage_id',
        'sequence_number',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function cohort()
    {
        return $this->belongsTo(CourseCohort::class, 'course_cohort_id');
    }

    public function stage()
    {
        return $this->belongsTo(CourseStage::class, 'course_stage_id');
    }


}

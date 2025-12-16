<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCohort extends Model
{
    protected $fillable = [
        'course_id',
        'intake_year',
        'intake_month',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function plannedStatistic()
    {
        return $this->hasOne(CoursePlannedStatistic::class);
    }
    public function timelines()
    {
        return $this->hasMany(
            CohortStageTimeline::class,
            'course_cohort_id'
        )->orderBy('sequence_number');
    }
}


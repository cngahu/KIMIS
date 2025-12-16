<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePlannedStatistic extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_cohort_id',
        'planned_male',
        'planned_female',
        'source',
    ];

    public function cohort()
    {
        return $this->belongsTo(CourseCohort::class, 'course_cohort_id');
    }

    // Convenience accessor (optional)
    public function getPlannedTotalAttribute()
    {
        return $this->planned_male + $this->planned_female;
    }
}

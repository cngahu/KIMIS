<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'campus_id',
        'year',
        'cohort',
        'semester',
        'status',
        'course_cohort_id',
        'course_stage_id',
        'source',
        'activated_at',
    ];


    public function cohort()
    {
        return $this->belongsTo(CourseCohort::class, 'course_cohort_id');
    }

    public function stage()
    {
        return $this->belongsTo(CourseStage::class, 'course_stage_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

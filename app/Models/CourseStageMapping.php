<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStageMapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'course_stage_id',
        'sequence_number',
    ];

    public function stage0()
    {
        return $this->belongsTo(CourseStage::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function stage()
    {
        return $this->belongsTo(CourseStage::class, 'course_stage_id');
    }

}

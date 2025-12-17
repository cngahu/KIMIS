<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function stageMappings()
    {
        return $this->hasMany(CourseStageMapping::class)
            ->orderBy('sequence_number');
    }

    public function stages()
    {
        return $this->belongsToMany(
            CourseStage::class,
            'course_stage_mappings'
        )->withPivot('sequence_number')
            ->orderBy('pivot_sequence_number');
    }

//    public function college()
//    {
//        return $this->belongsTo(College::class);
//    }

    public function college()
    {
        return $this->belongsTo(\App\Models\College::class, 'college_id');
    }

    public function hods()
    {
        return $this->belongsToMany(\App\Models\User::class, 'course_user')->withTimestamps();
    }


    public function department()
    {
        return $this->belongsTo(\App\Models\Departmentt::class, 'department_id');
    }


}

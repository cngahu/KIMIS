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
// 🔗 Course → Academic Department
    public function academicDepartment()
    {
        return $this->belongsTo(AcademicDepartment::class, 'academic_department_id');
    }

    public function hods()
    {
        return $this->belongsToMany(\App\Models\User::class, 'course_user')->withTimestamps();
    }


    public function department()
    {
        return $this->belongsTo(\App\Models\Departmentt::class, 'department_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'course_id',   // enrollments.course_id
            'id',          // students.id
            'id',          // courses.id
            'student_id'   // enrollments.student_id
        );
    }
    public function masterdata()
    {
        return $this->hasMany(Masterdata::class, 'course_id');
    }
    public function courseCohorts()
    {
        return $this->hasMany(CourseCohort::class, 'course_id');
    }

}

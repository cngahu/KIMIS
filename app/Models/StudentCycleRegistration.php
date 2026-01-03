<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCycleRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'enrollment_id',
        'course_stage_id',
        'cycle_year',
        'cycle_term',
        'status',
        'registered_at',
        'confirmed_at',
        'invoice_id',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function stage()
    {
        return $this->belongsTo(CourseStage::class, 'course_stage_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}


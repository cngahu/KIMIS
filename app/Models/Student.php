<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'admission_id',
        'student_number',
        'course_id',
        'campus_id',
        'admitted_at',
        'status',
    ];
    public function openingBalance()
    {
        return $this->hasOne(StudentOpeningBalance::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

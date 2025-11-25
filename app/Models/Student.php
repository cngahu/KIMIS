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
}

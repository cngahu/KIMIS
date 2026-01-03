<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicDepartment extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'academic_departments';

    protected $fillable = [
        'name',
        'college_id',
        'hod_user_id',
    ];

    // 🔗 Relationships
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
    // 🔗 Department → Campus


    // 🔗 Department → HOD (User)
    public function hod()
    {
        return $this->belongsTo(User::class, 'hod_user_id');
    }

    // 🔗 Department → Courses
    public function courses()
    {
        return $this->hasMany(Course::class, 'academic_department_id');
    }
}

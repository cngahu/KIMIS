<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class CoursesData extends Model
{
    use HasFactory;

    protected $table = 'coursesdata';

    protected $fillable = [
        'courseid',
        'coursecode',
        'coursename',
        'departmentid',
        'courseshortname',
        'location',
        'abbrev',
        'level',
        'shortcourse',
        'modular'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentid', 'departmentid');
    }
}

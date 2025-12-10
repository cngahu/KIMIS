<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortCourseData extends Model
{
    use HasFactory;
    protected $table = 'shortcoursedata';

    protected $fillable = [
        'classno',
        'departmentname',
        'coursecode',
        'coursename',
        'venue',
        'classname',
        'startdate',
        'enddate',
        'studyactualyear',
        'studyterm',
        'studentid',
        'studentsname',
        'gender',
        'company',
        'certno',
        'mobileno',
        'nationalidno',
        'emailaddress',
        'county',
        'officer',
    ];

    protected $casts = [
        'startdate' => 'date',
        'enddate' => 'date',
    ];
}

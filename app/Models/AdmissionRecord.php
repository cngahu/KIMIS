<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionRecord extends Model
{
    use HasFactory;

    protected $table = 'admission_records';

    protected $fillable = [
        'admissionid',
        'studentid',
        'courseid',
        'studyyearid',
        'meanpoints',
        'meangrade',
        'meanmarks',
        'overallgrade',
        'modifiedby',
        'cancelresults',
        'admissiondate',
        'streamid',
        'boarder',
        'refered',
        'found',
        'certno',
        'username',
    ];

    protected $casts = [
        'cancelresults' => 'boolean',
        'boarder'       => 'boolean',
        'refered'       => 'boolean',
        'found'         => 'boolean',
        'admissiondate' => 'datetime',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentid', 'departmentid');
    }
    public function course()
    {
        return $this->belongsTo(CoursesData::class, 'courseid', 'courseid');
    }


}

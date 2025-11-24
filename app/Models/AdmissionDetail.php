<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_id', 'student_id',

        'parent_name','parent_phone','parent_id_number','parent_relationship',
        'parent_email','parent_occupation',

        'nok_name','nok_phone','nok_relationship','nok_address',

        'religion','disability_status','chronic_illness','allergies',

        'education_school','education_year','education_index_number',

        'emergency_name','emergency_phone',

        'declaration','form_completed_at'
    ];

//    public function admission()
//    {
//        return $this->belongsTo(Admission::class);
//    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function admission()
    {
        return $this->belongsTo(\App\Models\Admission::class, 'admission_id');
    }

}

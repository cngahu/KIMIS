<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',

        'id_number',
        'gender',
        'date_of_birth',
        'nationality',

        'phone',
        'email',
        'postal_address',
        'town',
        'home_county_id',
        'current_county_id',

        'guardian_name',
        'guardian_phone',
        'guardian_relationship',

        'nok_name',
        'nok_phone',
        'nok_relationship',

        'disability',
        'chronic_illness',
        'allergies',

        'kcse_mean_grade',
        'school_attended',
        'year_completed',

        'extra_data',
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

}

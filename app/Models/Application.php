<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'full_name','id_number','phone','email',
        'date_of_birth','home_county_id','current_county_id','current_subcounty_id',
        'postal_address','postal_code_id','co','town',
        'financier','kcse_mean_grade','declaration',
        'status','payment_status','reference','reviewer_id','reviewer_comments','metadata',
        'kcse_certificate_path',
        'school_leaving_certificate_path',
        'birth_certificate_path',
        'national_id_path',
        'alt_course_1_id',
        'alt_course_2_id',
    ];

    protected $casts = [
        'metadata' => 'array',
        'declaration' => 'boolean',
    ];



    public function homeCounty()
    {
        return $this->belongsTo(County::class, 'home_county_id');
    }

    public function currentCounty()
    {
        return $this->belongsTo(County::class, 'current_county_id');
    }

    // FIXED RELATIONSHIP
    public function currentSubcounty()
    {
        return $this->belongsTo(Subcounty::class, 'current_subcounty_id');
    }

    public function answers()
    {
        return $this->hasMany(ApplicationRequirementAnswer::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class,'reviewer_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function altCourse1()
    {
        return $this->belongsTo(\App\Models\Course::class, 'alt_course_1_id');
    }

    public function altCourse2()
    {
        return $this->belongsTo(\App\Models\Course::class, 'alt_course_2_id');
    }




    // 🔹 Postal code
    public function postalCode()
    {
        return $this->belongsTo(PostalCode::class, 'postal_code_id');
    }



}

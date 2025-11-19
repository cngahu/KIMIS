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
        'status','payment_status','reference','reviewer_id','reviewer_comments','metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'declaration' => 'boolean',
    ];

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

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name','id_number','phone','email','date_of_birth',
        'home_county_id','current_county_id','current_subcounty_id',
        'postal_address','postal_code_id','co','town','financier',
        'kcse_mean_grade','declaration','extra'
    ];

    protected $casts = [
        'extra' => 'array',
        'date_of_birth' => 'date',
        'declaration' => 'boolean',
    ];

    public function homeCounty() { return $this->belongsTo(County::class,'home_county_id'); }
    public function currentCounty() { return $this->belongsTo(County::class,'current_county_id'); }
    public function currentSubcounty() { return $this->belongsTo(Subcounty::class,'current_subcounty_id'); }
    public function postalCode() { return $this->belongsTo(PostalCode::class,'postal_code_id'); }

    public function applications() {
        return $this->hasMany(Application::class);
    }
}

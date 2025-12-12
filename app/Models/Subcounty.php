<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Str;
class Subcounty extends Model
{
    use HasFactory;

    protected $table = 'subcounties';
    protected $fillable = [
        'county_id',
        'name',
        'code',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($sub) {
            if (empty($sub->slug) && !empty($sub->name)) {
                $sub->slug = Str::slug($sub->name);
            }
        });

        static::updating(function ($sub) {
            if (empty($sub->slug) && !empty($sub->name)) {
                $sub->slug = Str::slug($sub->name);
            }
        });
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'code',
    ];

    /**
     * Casts / attributes
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'code' => 'string',
    ];

    /**
     * Booted: auto-generate slug if not provided
     */
    protected static function booted()
    {
        static::creating(function ($county) {
            if (empty($county->slug) && !empty($county->name)) {
                $county->slug = Str::slug($county->name);
            }
        });

        static::updating(function ($county) {
            if (empty($county->slug) && !empty($county->name)) {
                $county->slug = Str::slug($county->name);
            }
        });
    }

    /**
     * Relationship: county has many subcounties
     */
    public function subcounties()
    {
        return $this->hasMany(Subcounty::class);
    }
}

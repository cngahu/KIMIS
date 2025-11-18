<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
class PostalCode extends Model
{
    use HasFactory;


    protected $fillable = [
        'code',
        'town',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($pc) {
            if (empty($pc->slug)) {
                $pc->slug = Str::slug($pc->code . '-' . $pc->town);
            }
        });

        static::updating(function ($pc) {
            if (empty($pc->slug)) {
                $pc->slug = Str::slug($pc->code . '-' . $pc->town);
            }
        });
    }
}

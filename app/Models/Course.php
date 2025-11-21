<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }


    public function college()
    {
        return $this->belongsTo(College::class);
    }
}

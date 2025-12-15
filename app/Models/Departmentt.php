<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departmentt extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function hods()
    {
        return $this->belongsToMany(User::class, 'department_user');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departmentt extends Model
{
    use HasFactory;
    protected $table = 'departmentts';

    protected $fillable = [
        'college_id',
        'name',
        'code',
    ];



    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function courses0()
    {
        return $this->hasMany(Course::class);
    }

    public function hods()
    {
        return $this->belongsToMany(User::class, 'department_user');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }



}

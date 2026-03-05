<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class College extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'colleges';

    // Mass assignable / guarded
    protected $guarded = [];

    /**
     * Get all students belonging to this college
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'campus_id');
    }
}
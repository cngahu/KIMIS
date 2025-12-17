<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStage extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'stage_type',
        'is_billable',
    ];

//    protected $fillable = [
//        'code',
//        'name',
//        'sequence_number',
//    ];

    /**
     * Fees defined for this stage (scoped by course in queries)
     */
    public function fees()
    {
        return $this->hasMany(
            CourseStageFee::class,
            'course_stage_id'
        );
    }
}

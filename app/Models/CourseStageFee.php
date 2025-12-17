<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
class CourseStageFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'course_stage_id',
        'amount',
        'is_billable',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'is_billable'    => 'boolean',
        'amount'         => 'decimal:2',
        'effective_from' => 'date',
        'effective_to'   => 'date',
    ];

    /* =========================
     | Relationships
     ========================= */

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function stage()
    {
        return $this->belongsTo(CourseStage::class, 'course_stage_id');
    }

    /* =========================
     | Scopes (VERY IMPORTANT)
     ========================= */

    /**
     * Get the fee active at a given date
     */
    public function scopeActiveAt(Builder $query, $date)
    {
        return $query
            ->where('effective_from', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', $date);
            });
    }

    /**
     * Only billable fees
     */
    public function scopeBillable(Builder $query)
    {
        return $query->where('is_billable', true);
    }

    public function fees()
    {
        return $this->hasMany(
            CourseStageFee::class,
            'course_stage_id'
        );
    }
}

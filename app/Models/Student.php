<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admission_id',
        'student_number',
        'course_id',
        'campus_id', // links to colleges.id
        'admitted_at',
        'status',
    ];

    protected $casts = [
        'admitted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Campus now references the College model
    public function campus(): BelongsTo
    {
        return $this->belongsTo(College::class, 'campus_id', 'id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function openingBalance(): HasOne
    {
        return $this->hasOne(StudentOpeningBalance::class);
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(StudentLedger::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Financial Logic
    |--------------------------------------------------------------------------
    */

    public function outstandingBalance(): float
    {
        $debits = $this->ledgers()
            ->where('entry_type', 'debit')
            ->sum('amount');

        $credits = $this->ledgers()
            ->where('entry_type', 'credit')
            ->sum('amount');

        return round($debits - $credits, 2);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // Latest enrollment
    public function latestEnrollment()
    {
        return $this->enrollments()->latest()->first();
    }

    // Current stage via latest enrollment or first stage of course
    public function currentStage()
    {
        $enrollment = $this->latestEnrollment();

        if ($enrollment && $enrollment->current_stage_id) {
            return $this->course?->stages()->where('id', $enrollment->current_stage_id)->first();
        }

        // fallback: first stage of course
        return $this->course?->stages()->orderBy('order', 'asc')->first();
    }

    // Course timeline (all stages)
    public function timeline()
    {
        return $this->course?->stages()->orderBy('order', 'asc')->get() ?? collect();
    }
}
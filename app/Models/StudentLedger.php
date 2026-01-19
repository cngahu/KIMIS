<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLedger extends Model
{
    protected $fillable = [
        'student_id',
        'masterdata_id',
        'enrollment_id',

        'entry_type',
        'category',
        'amount',
        'provisional',

        'cycle_term',
        'cycle_year',
        'course_id',
        'course_stage_id',

        'source',
        'reference_type',
        'reference_id',
        'description',

        'created_by',
    ];

    protected $casts = [
        'provisional' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // -----------------------------
    // Relationships
    // -----------------------------
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function masterdata()
    {
        return $this->belongsTo(Masterdata::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // -----------------------------
    // Scopes (VERY IMPORTANT)
    // -----------------------------
    public function scopeConfirmed($query)
    {
        return $query->where('provisional', false);
    }

    public function scopeProvisional($query)
    {
        return $query->where('provisional', true);
    }

    public function scopeDebits($query)
    {
        return $query->where('entry_type', 'debit');
    }

    public function scopeCredits($query)
    {
        return $query->where('entry_type', 'credit');
    }
}


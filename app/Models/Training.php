<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    // ✅ Allow mass assignment for these columns
    protected $fillable = [
        'course_id',
        'college_id',
        'start_date',
        'end_date',
        'cost',
        'status',
        'user_id',
        'series_code',
        'rejection_comment',
        'rejection_stage',
        'rejected_at',
    ];

    // ✅ Casts so ->format() works
    protected $casts = [
        'start_date'    => 'date',
        'end_date'      => 'date',
        'rejected_at'   => 'datetime',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];
    public function getFormattedCostAttribute()
    {
        return 'KSh ' . number_format($this->cost, 2);
    }
    // -----------------------------
    // STATUS CONSTANTS
    // -----------------------------
    public const STATUS_DRAFT                 = 'Draft';
    public const STATUS_PENDING_REGISTRAR     = 'Pending Registrar Approval';
    public const STATUS_REGISTRAR_APPROVED_HQ = 'Registrar Approved - Pending HQ Review';
    public const STATUS_HQ_REVIEWED           = 'HQ Reviewed';
    public const STATUS_APPROVED              = 'Approved';
    public const STATUS_REJECTED              = 'Rejected';

    // -----------------------------
    // RELATIONSHIPS (if not already)
    // -----------------------------
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -----------------------------
    // HELPER METHODS FOR PERMISSIONS
    // -----------------------------

    /**
     * HOD can edit only Draft or Rejected trainings.
     */
    public function isEditableByHod(): bool
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_REJECTED,
        ], true);
    }

    /**
     * HOD can send for approval only when status is Draft.
     */
    public function isSendableByHod(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * HOD can delete only Draft or Rejected trainings (if you want this rule).
     */
    public function isDeletableByHod(): bool
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_REJECTED,
        ], true);
    }

    /**
     * Campus / KIHBT Registrar can act only when Pending Registrar Approval.
     */
    public function isActionableByRegistrar(): bool
    {
        return $this->status === self::STATUS_PENDING_REGISTRAR;
    }

    public function rejections()
    {
        return $this->hasMany(\App\Models\TrainingRejection::class);
    }
}

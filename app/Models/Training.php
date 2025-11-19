<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;


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

    public const STATUS_DRAFT                     = 'Draft';
    public const STATUS_PENDING_REGISTRAR          = 'Pending Registrar Approval';
    public const STATUS_REGISTRAR_APPROVED_HQ      = 'Registrar Approved - Pending HQ Review';
    public const STATUS_HQ_REVIEWED                = 'HQ Reviewed';
    public const STATUS_APPROVED                   = 'Approved'; // Final Approval
    public const STATUS_REJECTED                   = 'Rejected';



    protected $fillable = [
        'course_id',
        'college_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'cost',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

}

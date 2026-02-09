<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelBooking extends Model
{
    protected $fillable = [
        'reference',
        'full_name',
        'id_number',
        'email',
        'phone',
        'course_id',
        'college_id',
        'boarding_type',
        'status',
        'payment_status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }
}


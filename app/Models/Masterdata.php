<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterdata extends Model
{
    use HasFactory;

    protected $table = 'masterdata';

    protected $fillable = [
        'admissionNo',
        'full_name',
        'campus',
        'campus_id',
        'department',
        'department_id',
        'course_name',
        'course_code',
        'course_id',
        'current',
        'intake',
        'balance',
        'phone',
        'email',
        'idno',
        'is_activated',
        'activated_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'campus_id' => 'integer',
        'department_id' => 'integer',
        'course_id' => 'integer',
    ];
}

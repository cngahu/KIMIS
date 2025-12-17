<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOpeningBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'amount',
        'as_of_date',
        'source',
    ];

    protected $casts = [
        'as_of_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

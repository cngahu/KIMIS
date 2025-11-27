<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRejection extends Model
{
    use HasFactory;
    protected $fillable = [
        'training_id',
        'rejected_by',
        'stage',
        'reason',
        'rejected_at',
    ];


    protected $dates = ['rejected_at'];
    protected $casts = [
        'rejected_at' => 'datetime',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function rejectedByUser()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }


}

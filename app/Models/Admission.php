<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id',
        'user_id',
        'status',
        'offer_accepted_at',
        'form_submitted_at',
        'documents_submitted_at',
        'fee_cleared_at',
        'verified_at',
        'verified_by',
        'admission_number',
    ];

}

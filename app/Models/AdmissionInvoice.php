<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_id',
        'invoice_number',
        'amount',
        'status',
        'gateway_reference',
        'paid_at',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}

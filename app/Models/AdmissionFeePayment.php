<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionFeePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_id','invoice_id','amount','payment_type','status',
        'sponsor_name','sponsor_letter','explanation','paid_at'
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

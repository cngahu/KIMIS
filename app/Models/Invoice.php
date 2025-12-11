<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id',
        'user_id',
        'course_id',
        'invoice_number',
        'category',
        'amount',
        'invoice_amount',
        'payment_channel',
        'ecitizen_invoice_number',
        'amount_paid',
        'status',
        'gateway_reference',
        'paid_at',
        'metadata',
        'ecitizen_notification',
        'billable_type',
        'billable_id',
    ];


    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'ecitizen_notification' => 'array',

    ];


    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function admissionPayment()
    {
        return $this->hasOne(AdmissionFeePayment::class, 'invoice_id');
    }

    public function admission()
    {
        return $this->hasOneThrough(
            Admission::class,           // final model we want
            AdmissionFeePayment::class, // intermediate
            'invoice_id',               // foreign key on AFP
            'id',                        // foreign key on Admission
            'id',                        // local key on Invoice
            'admission_id'               // local key on AFP
        );
    }
    public function billable()
    {
        return $this->morphTo();
    }


}

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
        'admitted_at',
        'required_fee'
    ];
    // link back to the application
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
    protected $casts = [
        'verification_issues' => 'array',
    ];

    // optional: user relationship
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function details()
    {
        return $this->hasOne(\App\Models\AdmissionDetail::class, 'admission_id');
    }
//    public function isFullyPaid(): bool
//    {
//        return $this->total_fee <= $this->feePayments->sum('amount');
//    }
    public function uploadedDocuments()
    {
        return $this->hasMany(\App\Models\AdmissionUploadedDocument::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }


    public function invoices()
    {
        return $this->hasMany(AdmissionInvoice::class);
    }

    public function latestInvoice()
    {
        return $this->hasOne(AdmissionInvoice::class)->latestOfMany();
    }

//    public function totalPaid()
//    {
//        return $this->invoices()->where('status', 'paid')->sum('amount');
//    }

    public function feeCleared()
    {
        return $this->totalPaid() >= $this->course_fee; // course_fee pulled from course
    }
    public function feePayments()
    {
        return $this->hasMany(\App\Models\AdmissionFeePayment::class);
    }

    public function totalPaid()
    {
        return $this->feePayments()
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function courseFee()
    {
        return optional($this->application->course)->cost ?? 0;
    }

    public function isFullyPaid()
    {
        return bccomp($this->totalPaid(), $this->courseFee(), 2) >= 0;
    }


}

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
    // link back to the application
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    // optional: user relationship
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function details()
    {
        return $this->hasOne(\App\Models\AdmissionDetail::class, 'admission_id');
    }
    public function isFullyPaid(): bool
    {
        return $this->total_fee <= $this->feePayments->sum('amount');
    }
    public function uploadedDocuments()
    {
        return $this->hasMany(\App\Models\AdmissionUploadedDocument::class);
    }

}

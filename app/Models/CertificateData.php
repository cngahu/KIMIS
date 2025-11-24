<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateData extends Model
{
    protected $table = 'certificate_data';

    protected $fillable = [
        'row_no',
        'admn_no',
        'course',
        'student_name',
        'gender',
        'id_no',
        'mobile_no',
        'county',
        'email',
        'sponsor',
        'receipt_number',
        'invoiced',
        'amount_paid',
        'due',
        'cert_no',
        'start_date',
        'end_date',
        'comment_signature',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}

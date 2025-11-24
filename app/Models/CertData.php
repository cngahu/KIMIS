<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertData extends Model
{
    use HasFactory;

    protected $table = 'cert_data';

    protected $fillable = [
        'No',
        'Admn_No',
        'COURSE',
        'Students_Name',
        'Gender',
        'ID_No',
        'Mobile_No',
        'COUNTY',
        'EMail',
        'SPONSOR',
        'RECEIPT_NUMBER',
        'INVOICED',
        'AMOUNT_PAID',
        'DUE',
        'CERT_NO',
        'START_DATE',
        'END_DATE',
        'COMMENT_SIGNATURE'
    ];

    // If you want to disable timestamps
    // public $timestamps = false;
}

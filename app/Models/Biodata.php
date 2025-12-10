<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $table = 'biodatas';

    protected $fillable = [
        'admissionno',
        'studentsname',
        'emailaddress',
        'dob',
        'accountactivated',
        'unlockkey',
        'studentpassword',
        'studentid',
        'mobileno',
        'nationalidno',
        'birthcertificateno',
        'guardiancell',
        'pobox',
        'indexno',
        'townname',
        'guardianname',
        'formerschool',
        'certificatetype',
        'certificateyear',
        'gender',
        'admlastpart',
        'relationship',
        'kcsemeangrade',
        'remarks',
        'nextofkinaddress',
        'series',
        'applno',
        'county',
        'dateandtime',
        'sponsorid',
        'enggrade',
        'mathgrade',
        'phygrade',
        'district',
        'officer',
        'company',
        'active',
        'cautionfeeamt',
        'lastupdateby',
        'lastupdate',
    ];

    protected $casts = [
        'dob'          => 'date',
        'dateandtime'  => 'datetime',
        'active'       => 'boolean',
        'cautionfeeamt'=> 'decimal:2',
        'lastupdate'   => 'datetime',
        'accountactivated' => 'boolean',
    ];

    public function admission()
    {
        // Link via studentid (adjust if you prefer admissionno/admissionid)
        return $this->hasOne(AdmissionRecord::class, 'studentid', 'studentid');
    }
}

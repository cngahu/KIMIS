<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionDocumentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','description','is_mandatory','file_types','max_size','status'
    ];

}

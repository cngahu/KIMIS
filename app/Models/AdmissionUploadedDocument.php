<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionUploadedDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_id','document_type_id','file_path',
        'verified','verified_by','verified_at'
    ];

    public function type()
    {
        return $this->belongsTo(AdmissionDocumentType::class, 'document_type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationRequirementAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id','requirement_id','value','original_name'
    ];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
}

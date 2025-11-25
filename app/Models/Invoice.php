<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id','invoice_number','amount',
        'status','gateway_reference','metadata','paid_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',

    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

}

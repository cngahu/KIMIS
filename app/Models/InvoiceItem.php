<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'user_id',
        'application_id',
        'admission_id',
        'course_id',
        'item_name',
        'unit_amount',
        'quantity',
        'total_amount',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

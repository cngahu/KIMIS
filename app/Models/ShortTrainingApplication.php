<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortTrainingApplication extends Model
{
    use HasFactory;
    protected $table = 'short_training_applications';

    protected $fillable = [
        'training_id',
        'financier',
        'employer_name',
        'employer_contact_person',
        'employer_phone',
        'employer_email',
        'employer_postal_address',
        'employer_postal_code_id',
        'employer_town',
        'employer_county_id',
        'reference',
        'total_participants',
        'status',
        'payment_status',
        'metadata',
    ];

    protected $casts = [
        'total_participants' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Boot - generate unique reference when creating if not supplied.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->reference)) {
                $model->reference = static::generateUniqueReference();
            }
        });
    }

    /**
     * Generate a reasonably short unique reference
     * Example: STAPP-7F4A9D2B
     */
    protected static function generateUniqueReference(): string
    {
        do {
            $ref = 'STAPP-' . strtoupper(Str::random(8));
        } while (static::where('reference', $ref)->exists());

        return $ref;
    }

    /* -------------------------
       Relationships
       ------------------------- */

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function participants()
    {
        // assumes your participant table will be short_training_participants
        return $this->hasMany(ShortTraining::class, 'application_id');
    }

//    public function invoices()
//    {
//        // invoices linked using application_id (same pattern as for long courses)
//        return $this->hasMany(\App\Models\Invoice::class, 'application_id');
//    }

    /* -------------------------
       Helper accessors
       ------------------------- */

    public function isEmployer(): bool
    {
        return $this->financier === 'employer';
    }

    public function isSelf(): bool
    {
        return $this->financier === 'self';
    }
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'billable');
    }


}

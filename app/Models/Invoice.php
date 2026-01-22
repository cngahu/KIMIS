<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id',
        'user_id',
        'course_id',
        'invoice_number',
        'category',
        'amount',
        'invoice_amount',
        'payment_channel',
        'ecitizen_invoice_number',
        'amount_paid',
        'status',
        'gateway_reference',
        'paid_at',
        'metadata',
        'ecitizen_notification',
        'billable_type',
        'billable_id',
    ];


    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'ecitizen_notification' => 'array',

    ];

//    public function getRouteKeyName()
//    {
//        return 'invoice_number';
//    }
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function admissionPayment()
    {
        return $this->hasOne(AdmissionFeePayment::class, 'invoice_id');
    }

    public function admission()
    {
        return $this->hasOneThrough(
            Admission::class,           // final model we want
            AdmissionFeePayment::class, // intermediate
            'invoice_id',               // foreign key on AFP
            'id',                        // foreign key on Admission
            'id',                        // local key on Invoice
            'admission_id'               // local key on AFP
        );
    }
    public function billable()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }


    public function getRaisedByAttribute(): string
    {
        if ($this->user) {
            return trim(
                "{$this->user->surname} {$this->user->firstname}"
            );
        }

        return 'System';
    }

    public function getBillableLabelAttribute(): string
    {
        if (! $this->billable) {
            return '—';
        }

        return match (true) {
            $this->billable instanceof \App\Models\ShortTrainingApplication
            => 'Short Course Application',

            $this->billable instanceof \App\Models\Application
            => 'Application',

            $this->billable instanceof \App\Models\Admission
            => 'Admission',

            default
            => class_basename($this->billable),
        };
    }

    public function getBillableDescriptionAttribute(): string
    {
        if (! $this->billable) {
            return '—';
        }

        // Short course
        if ($this->billable instanceof \App\Models\ShortTrainingApplication) {
            return optional(
                $this->billable->training?->course
            )->course_name ?? 'Short Course';
        }

        $meta = is_array($this->metadata) ? $this->metadata : [];

        if (in_array($this->category, ['tuition_fee', 'course_fee'])) {
            return trim(sprintf(
                'Course Registration – %s %s',
                $meta['cycle_term'] ?? 'Term',
                $meta['cycle_year'] ?? 'Year'
            ));
        }

        // Long course application
        if ($this->billable instanceof \App\Models\Application) {
            return optional($this->billable->course)->course_name ?? 'Application';
        }

        // Admission
        if ($this->billable instanceof \App\Models\Admission) {
            return optional($this->billable->course)->course_name ?? 'Admission';
        }

        return '—';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPayerDisplayAttribute(): string
    {
        $meta = $this->metadata ?? [];

        return match ($this->category) {

            // Short course
            'short_course' => match ($meta['financier'] ?? null) {
                'employer' => $meta['employer_name'] ?? 'Employer',
                'self'     =>  $meta['employer_name'] ?? 'Self',
                default    => 'Unknown',
            },

            // --------------------------------------
            // STUDENT FEES (user_id is the authority)
            // --------------------------------------
            'tuition_fee', 'course_fee', 'application_fee' =>
            $this->user
                ? trim("{$this->user->surname} {$this->user->firstname}")
                : 'Student',

            // -----------------------------
            // FALLBACK
            // -----------------------------
            default => '—',
        };
    }
    public function getBillableContextAttribute(): string
    {
        $meta = $this->metadata ?? [];

        return match ($this->category) {

            'short_course' => sprintf(
                'Short Course (Course #%s, %s participants)',
                $meta['course_id'] ?? 'N/A',
                $meta['total_participants'] ?? 'N/A'
            ),

            // --------------------------------
            // TUITION / COURSE FEES (CYCLES)
            // --------------------------------
            'tuition_fee', 'course_fee' => sprintf(
                'Course Registration – %s %s',
                $meta['cycle_term'] ?? 'Term',
                $meta['cycle_year'] ?? 'Year'
            ),

            // -----------------------------
            // APPLICATION FEE
            // -----------------------------
            'application_fee' => 'Student Application',

            // -----------------------------
            // FALLBACK
            // -----------------------------
            default => '—',
        };
    }
    public function getQuantitySummaryAttribute(): ?string
    {
        $meta = $this->metadata ?? [];

        if ($this->category === 'short_course') {
            return ($meta['total_participants'] ?? 1) . ' participant(s)';
        }

        return null;
    }
    public function getBillableDescriptionAttribute0(): string
    {
        $meta = is_array($this->metadata) ? $this->metadata : [];

        if (in_array($this->category, ['tuition_fee', 'course_fee'])) {
            return trim(sprintf(
                'Course Registration – %s %s',
                $meta['cycle_term'] ?? 'Term',
                $meta['cycle_year'] ?? 'Year'
            ));
        }

        if ($this->category === 'short_course') {
            return sprintf(
                'Short Course – %s participant%s',
                $meta['total_participants'] ?? 'N/A',
                isset($meta['total_participants']) && (int)$meta['total_participants'] === 1 ? '' : 's'
            );
        }

        return '—';
    }

}

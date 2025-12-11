<?php

namespace App\Services;
use App\Models\Course;
use App\Models\Invoice;
use App\Models\Application;
use App\Models\InvoiceItem;
use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Audit\AuditLogService;
class PaymentService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Create invoice for an application.
     */

    public function generateInvoice(Application $app, float $amount): Invoice
    {
        return DB::transaction(function () use ($app, $amount) {

            // 1. Create invoice
            $invoice = Invoice::create([
                'application_id' => $app->id,
                'user_id'        => null, // applicant may not be a registered system user yet
                'course_id'      => $app->course_id,
                'category'       => 'knec_application', // NEW CATEGORY
                'invoice_number' => $this->generateInvoiceNumber(),
                'amount'         => $amount,
                'status'         => 'pending',
            ]);

            // 2. Create invoice item
            InvoiceItem::create([
                'invoice_id'     => $invoice->id,
                'application_id' => $app->id,
                'user_id'        => null,
                'course_id'      => $app->course_id,
                'item_name'      => 'KNEC Application Fee - ' . $app->full_name,
                'unit_amount'    => $amount,
                'quantity'       => 1,
                'total_amount'   => $amount,
                'metadata'       => [
                    'type' => 'knec_application'
                ],
            ]);

            // 3. Audit log
            $this->audit->log('invoice_created', $invoice);

            return $invoice;
        });
    }
    public function generateShortCourseInvoice(\App\Models\ShortTrainingApplication $app)
    {
        return DB::transaction(function () use ($app) {

            $participants = $app->participants;
            $amountPerPerson = $app->metadata['amount_per_person'] ?? 0;
            $totalAmount = $app->metadata['total_amount'] ?? ($amountPerPerson * $app->total_participants);
            $training=Training::where('id',$app->training_id)->first();

            // 1. Create invoice
            $invoice = Invoice::create([
                'application_id' => $app->id,
                // not using long-course applications table
                'user_id'        => null,
                'course_id'      => $training->course_id,
                'category'       => 'short_course',
                'invoice_number' => $this->generateInvoiceNumber(),
                'amount'         => $totalAmount,
                'status'         => 'pending',
                'metadata'       => [
                    'short_training_application_id' => $app->id,
                    'total_participants' => $app->total_participants,
                    'amount_per_participant' => $amountPerPerson,
                    'financier' => $app->financier,
                    'employer_name' => $app->employer_name,
                ],
            ]);

            // 2. Create invoice items for each participant
            foreach ($participants as $person) {
                InvoiceItem::create([
                    'invoice_id'     => $invoice->id,
                    'application_id' => null,
                    'course_id'      => null,
                    'item_name'      => "Short Course Fee – {$person->full_name}",
                    'unit_amount'    => $amountPerPerson,
                    'quantity'       => 1,
                    'total_amount'   => $amountPerPerson,
                    'metadata'       => [
                        'participant_id' => $person->id,
                        'short_training_application_id' => $app->id,
                        'type' => 'short_course',
                    ],
                ]);
            }

            // 3. Audit
            $this->audit->log('invoice_created', $invoice);

            return $invoice;
        });
    }

    /**
     * When payment gateway sends callback.
     */
    public function markPaid(Invoice $invoice, string $gatewayRef)
    {
        $invoice->update([
            'status' => 'paid',
            'gateway_reference' => $gatewayRef,
            'paid_at' => now(),
        ]);

        $app = $invoice->application;

        // update application
        $app->update([
            'payment_status' => 'paid',
            'status' => 'submitted',
        ]);



        $this->audit->log('invoice_paid', $invoice);
        // notify applicant + admin
        app(\App\Services\ApplicationNotificationService::class)
            ->sendNotifications($invoice);
    }

    protected function generateInvoiceNumber()
    {
        $prefix = "INV-" . date('Ymd');

        return $prefix . "-" . strtoupper(Str::random(6));
    }
}

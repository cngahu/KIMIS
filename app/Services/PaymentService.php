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

            // 1. Create invoice (polymorphic + legacy fields)
            $invoice = Invoice::create([
                // Polymorphic linkage
                'billable_type' => Application::class,
                'billable_id'   => $app->id,

                // Legacy fields kept for backward compatibility
                'application_id' => $app->id,
                'course_id'      => $app->course_id,

                'user_id'        => null,
                'category'       => 'knec_application',
                'invoice_number' => $this->generateInvoiceNumber(),
                'amount'         => $amount,
                'status'         => 'pending',
                'metadata'       => [
                    'type' => 'knec_application',
                    'course_id' => $app->course_id,
                ],
            ]);

            // 2. Create invoice item
            InvoiceItem::create([
                'invoice_id'     => $invoice->id,

                // Polymorphic (optional for now)
                'billable_type'  => Application::class,
                'billable_id'    => $app->id,

                // Legacy
                'application_id' => $app->id,
                'course_id'      => $app->course_id,

                'user_id'        => null,
                'item_name'      => 'KNEC Application Fee - ' . $app->full_name,
                'unit_amount'    => $amount,
                'quantity'       => 1,
                'total_amount'   => $amount,
                'metadata'       => [
                    'type' => 'knec_application'
                ],
            ]);

            // 3. Audit
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

            $training = Training::find($app->training_id);
            $courseId = optional($training)->course_id;

            // 1. Create invoice (polymorphic + legacy safe fields)
            $invoice = Invoice::create([
                // Polymorphic linkage
                'billable_type' => \App\Models\ShortTrainingApplication::class,
                'billable_id'   => $app->id,

                // Legacy-safe fields (not used for short course logic)
                'application_id' => $app->id,  // keeping to avoid breaking old logic
                'course_id'      => $courseId,

                'user_id'        => null,
                'category'       => 'short_course',
                'invoice_number' => $this->generateInvoiceNumber(),
                'amount'         => $totalAmount,
                'status'         => 'pending',
                'metadata'       => [
                    'training_id'    => $app->training_id,
                    'course_id'      => $courseId,
                    'total_participants' => $app->total_participants,
                    'amount_per_participant' => $amountPerPerson,

                    'financier'      => $app->financier,
                    'employer_name'  => $app->employer_name,
                    'schedule_label' => optional($training)->schedule_label ?? null,
                ],
            ]);

            // 2. Create invoice items (per participant)
            foreach ($participants as $person) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,

                    // Polymorphic linkage
                    'billable_type' => \App\Models\ShortTrainingApplication::class,
                    'billable_id'   => $app->id,

                    // Legacy (kept but irrelevant for short courses)
                    'application_id' => null,
                    'course_id'      => null,

                    'item_name' => "Short Course Fee – {$person->full_name}",
                    'unit_amount' => $amountPerPerson,
                    'quantity' => 1,
                    'total_amount' => $amountPerPerson,
                    'metadata' => [
                        'participant_id' => $person->id,
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


//public function generateInvoice1A(Application $app, float $amount): Invoice
//{
//    return DB::transaction(function () use ($app, $amount) {
//
//        // 1. Create invoice
//        $invoice = Invoice::create([
//            'application_id' => $app->id,
//            'user_id'        => null, // applicant may not be a registered system user yet
//            'course_id'      => $app->course_id,
//            'category'       => 'knec_application', // NEW CATEGORY
//            'invoice_number' => $this->generateInvoiceNumber(),
//            'amount'         => $amount,
//            'status'         => 'pending',
//        ]);
//
//        // 2. Create invoice item
//        InvoiceItem::create([
//            'invoice_id'     => $invoice->id,
//            'application_id' => $app->id,
//            'user_id'        => null,
//            'course_id'      => $app->course_id,
//            'item_name'      => 'KNEC Application Fee - ' . $app->full_name,
//            'unit_amount'    => $amount,
//            'quantity'       => 1,
//            'total_amount'   => $amount,
//            'metadata'       => [
//                'type' => 'knec_application'
//            ],
//        ]);
//
//        // 3. Audit log
//        $this->audit->log('invoice_created', $invoice);
//
//        return $invoice;
//    });
//}
//public function generateShortCourseInvoice2A(\App\Models\ShortTrainingApplication $app)
//{
//    return DB::transaction(function () use ($app) {
//
//        $participants = $app->participants;
//        $amountPerPerson = $app->metadata['amount_per_person'] ?? 0;
//        $totalAmount = $app->metadata['total_amount'] ?? ($amountPerPerson * $app->total_participants);
//        $training=Training::where('id',$app->training_id)->first();
//
//        // 1. Create invoice
//        $invoice = Invoice::create([
//            'application_id' => $app->id,
//            // not using long-course applications table
//            'user_id'        => null,
//            'course_id'      => $training->course_id,
//            'category'       => 'short_course',
//            'invoice_number' => $this->generateInvoiceNumber(),
//            'amount'         => $totalAmount,
//            'status'         => 'pending',
//            'metadata'       => [
//                'short_training_application_id' => $app->id,
//                'total_participants' => $app->total_participants,
//                'amount_per_participant' => $amountPerPerson,
//                'financier' => $app->financier,
//                'employer_name' => $app->employer_name,
//            ],
//        ]);
//
//        // 2. Create invoice items for each participant
//        foreach ($participants as $person) {
//            InvoiceItem::create([
//                'invoice_id'     => $invoice->id,
//                'application_id' => null,
//                'course_id'      => null,
//                'item_name'      => "Short Course Fee – {$person->full_name}",
//                'unit_amount'    => $amountPerPerson,
//                'quantity'       => 1,
//                'total_amount'   => $amountPerPerson,
//                'metadata'       => [
//                    'participant_id' => $person->id,
//                    'short_training_application_id' => $app->id,
//                    'type' => 'short_course',
//                ],
//            ]);
//        }
//
//        // 3. Audit
//        $this->audit->log('invoice_created', $invoice);
//
//        return $invoice;
//    });
//}

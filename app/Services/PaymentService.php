<?php

namespace App\Services;
use App\Models\Invoice;
use App\Models\Application;
use App\Models\InvoiceItem;
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
    public function generateInvoice0(Application $app, float $amount): Invoice
    {
        return DB::transaction(function () use ($app, $amount) {

            $invoice = Invoice::create([
                'application_id' => $app->id,
                'invoice_number' => $this->generateInvoiceNumber(),
                'amount'         => $amount,
                'status'         => 'pending',
            ]);

            $this->audit->log('invoice_created', $invoice);

            return $invoice;
        });
    }
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
    public function markPaid1(Invoice $invoice, string $gatewayRef, ?float $amountPaid = null)
    {
        // If the gateway does not provide actual amount paid, default to invoice amount
        $amountPaid = $amountPaid ?? $invoice->amount;

        $invoice->update([
            'status'            => 'paid',
            'gateway_reference' => $gatewayRef,
            'paid_at'           => now(),
            'amount_paid'       => $amountPaid,    // ✅ NEW COLUMN SET HERE
        ]);

        // Update parent application
        $app = $invoice->application;

        $app->update([
            'payment_status' => 'paid',
            'status'         => 'submitted',
        ]);

        // Log action
        $this->audit->log('invoice_paid', $invoice);

        // Send notifications
        app(\App\Services\ApplicationNotificationService::class)
            ->sendNotifications($invoice);
    }

    protected function generateInvoiceNumber()
    {
        $prefix = "INV-" . date('Ymd');

        return $prefix . "-" . strtoupper(Str::random(6));
    }
}

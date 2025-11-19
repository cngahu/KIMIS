<?php

namespace App\Services;
use App\Models\Invoice;
use App\Models\Application;
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

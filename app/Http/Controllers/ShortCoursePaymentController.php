<?php

namespace App\Http\Controllers;

use App\Models\ShortTrainingApplication;
use App\Models\StudentLedger;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortCoursePaymentController extends Controller
{
    public function showPaymentPage(string $reference)
    {
        $application = ShortTrainingApplication::where('reference', $reference)
            ->with('training')
            ->firstOrFail();

        // Ledger balance
        $debits = StudentLedger::where([
            'ledger_owner_type' => ShortTrainingApplication::class,
            'ledger_owner_id'   => $application->id,
            'entry_type'        => 'debit',
        ])->sum('amount');

        $credits = StudentLedger::where([
            'ledger_owner_type' => ShortTrainingApplication::class,
            'ledger_owner_id'   => $application->id,
            'entry_type'        => 'credit',
        ])->sum('amount');

        $outstanding = round($debits - $credits, 2);

        return view('public.short_courses.payment_choice', compact(
            'application',
            'outstanding'
        ));
    }

    public function createInvoice(Request $request, string $reference)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $application = ShortTrainingApplication::where('reference', $reference)->firstOrFail();

        // Outstanding balance
        $outstanding = StudentLedger::where([
                'ledger_owner_type' => ShortTrainingApplication::class,
                'ledger_owner_id'   => $application->id,
                'entry_type'        => 'debit',
            ])->sum('amount')
            -
            StudentLedger::where([
                'ledger_owner_type' => ShortTrainingApplication::class,
                'ledger_owner_id'   => $application->id,
                'entry_type'        => 'credit',
            ])->sum('amount');

        if ($request->amount > $outstanding) {
            return back()->withErrors([
                'amount' => 'Amount cannot exceed outstanding balance.',
            ]);
        }

        // Create invoice (payment intent)
        $invoice = Invoice::create([
            'billable_type' => ShortTrainingApplication::class,
            'billable_id'   => $application->id,
            'category'      => 'short_course',
            'invoice_number'=> 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'amount'        => $request->amount,
            'status'        => 'pending',
            'metadata'      => [
                'application_reference' => $application->reference,
                'payment_type'          => 'partial',
            ],
        ]);

        InvoiceItem::create([
            'invoice_id'   => $invoice->id,
            'item_name'    => 'Short Course Fee Payment',
            'unit_amount'  => $request->amount,
            'quantity'     => 1,
            'total_amount' => $request->amount,
        ]);

        return redirect()->route('short_training.payment', $invoice->id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ShortTrainingApplication;
use App\Models\StudentLedger;
use Illuminate\Http\Request;

class PublicPaymentController extends Controller
{
    /**
     * Show lookup form
     */
    public function lookupForm()
    {
        return view('public.payments.lookup');
    }

    /**
     * Handle lookup submission
     */
    public function lookup0(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
        ]);

        $application = ShortTrainingApplication::where('reference', $request->reference)
            ->first();

        if (!$application) {
            return back()->withErrors([
                'reference' => 'No application found with that reference.',
            ]);
        }

        return redirect()->route('payments.application.show', $application->reference);
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        $application = ShortTrainingApplication::where(
            'reference',
            $request->reference
        )->first();

        if (! $application) {
            return back()->withErrors([
                'reference' => 'Application reference not found.'
            ]);
        }

        return redirect()->route(
            'short_training.application.payment',
            $application->reference
        );
    }

    /**
     * Show application & payment page
     */
    public function showApplication(string $reference)
    {
        $application = ShortTrainingApplication::where('reference', $reference)
            ->firstOrFail();

        $ledger = StudentLedger::where('ledger_owner_type', ShortTrainingApplication::class)
            ->where('ledger_owner_id', $application->id)
            ->orderBy('created_at')
            ->get();

        $balance = $ledger->reduce(fn ($carry, $row) =>
            $carry + ($row->entry_type === 'debit' ? $row->amount : -$row->amount),
            0
        );

        return view('public.payments.application', compact(
            'application',
            'ledger',
            'balance'
        ));
    }
}


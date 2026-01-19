<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Services\Finance\InvoiceReconciliationService;
use Illuminate\Http\Request;

class InvoiceReconciliationController extends Controller
{
    public function index()
    {
        // Preview numbers only (safe)
        return view('finance.reconciliation.index');
    }

    public function run(InvoiceReconciliationService $service)
    {
        // Extra safety: only finance role
        if (!auth()->user()->hasAnyRole(['accounts', 'cash_office', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $summary = $service->reconcile(false);

        return back()->with('success', 'Reconciliation completed successfully.')
            ->with('summary', $summary);
    }
}


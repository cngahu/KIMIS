<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admission;
use App\Models\AdmissionFeePayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
class FeeStatementController extends Controller
{
    //

    public function index()
    {
        // Get the student's admission record
        $admission = Admission::where('user_id', Auth::id())->firstOrFail();

        $requiredFee = $admission->required_fee;

        // Sum all paid ledger items for this admission
        $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->sum('amount');

        $balance = $requiredFee - $paidTotal;

        // Fetch all payment transactions (invoices)
        $payments = AdmissionFeePayment::with('invoice')
            ->where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->orderBy('paid_at', 'asc')
            ->get();

        return view('student.fee_statement.index', compact(
            'admission',
            'requiredFee',
            'paidTotal',
            'balance',
            'payments'
        ));
    }

    public function downloadPdf()
    {
        $admission = Admission::where('user_id', Auth::id())->firstOrFail();

        $requiredFee = $admission->required_fee;

        $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->sum('amount');

        $balance = $requiredFee - $paidTotal;

        $payments = AdmissionFeePayment::with('invoice')
            ->where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->get();

        $pdf = Pdf::loadView('student.fee_statement.pdf', compact(
            'admission',
            'requiredFee',
            'paidTotal',
            'balance',
            'payments'
        ));

        return $pdf->download('fee_statement_'.$admission->id.'.pdf');
    }
}

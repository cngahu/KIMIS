<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Services\Finance\FeeStatementService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceFeeStatementController extends Controller
{
    public function preview(Request $request, FeeStatementService $service)
    {
        $data = $service->build(
            $request->student_id,
            $request->masterdata_id
        );

        return view('finance.statements.fee_statement', $data);
    }

    public function download(Request $request, FeeStatementService $service)
    {
        $data = $service->build(
            $request->student_id,
            $request->masterdata_id
        );

        $pdf = Pdf::loadView('finance.statements.fee_statement_pdf', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('KIHBT_Fee_Statement.pdf');
    }
}


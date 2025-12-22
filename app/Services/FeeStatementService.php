<?php

namespace App\Services;
use App\Models\Student;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
class FeeStatementService
{
    public function buildStatement(Student $student): array
    {
        $openingBalance = $student->openingBalance?->amount ?? 0;

        $invoices = Invoice::where('user_id', $student->user_id)
            ->orderBy('created_at')
            ->get();

        $rows = [];
        $runningBalance = $openingBalance;

        if ($openingBalance > 0) {
            $rows[] = [
                'date' => null,
                'description' => 'Opening Balance',
                'debit' => $openingBalance,
                'credit' => null,
                'balance' => $runningBalance,
            ];
        }

        foreach ($invoices as $invoice) {

            // Invoice raised
            $runningBalance += $invoice->amount;

            $rows[] = [
                'date' => $invoice->created_at,
                'description' => 'Invoice: ' . $invoice->invoice_number,
                'debit' => $invoice->amount,
                'credit' => null,
                'balance' => $runningBalance,
            ];

            // Payment made
            if ($invoice->status === 'paid') {
                $runningBalance -= $invoice->amount;

                $rows[] = [
                    'date' => $invoice->paid_at,
                    'description' => 'Payment: ' . $invoice->invoice_number,
                    'debit' => null,
                    'credit' => $invoice->amount,
                    'balance' => $runningBalance,
                ];
            }
        }

        return [
            'student' => $student,
            'rows' => $rows,
            'opening_balance' => $openingBalance,
            'outstanding_balance' => $runningBalance,
        ];
    }

    public function renderStudentStatement(Student $student)
    {
        $data = $this->buildStatement($student);

        $pdf = Pdf::loadView('student.fees.pdf.statement', $data)
            ->setPaper('a4');

//        return $pdf->download(
//            'Fee_Statement_' . $student->student_number . '.pdf'
//        );

        $filename = 'Fee_Statement_' . str_replace(['/', '\\'], '-', $student->student_number) . '.pdf';

        return $pdf->download($filename);

    }
}

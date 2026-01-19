<?php

namespace App\Services\Finance;

use App\Models\Student;
use App\Models\Masterdata;
use App\Models\StudentLedger;

class FeeStatementService
{
    public function build(?int $studentId, ?int $masterdataId): array
    {
        if (!$studentId && !$masterdataId) {
            throw new \Exception('Invalid fee statement request.');
        }

        // Resolve identity
        $student = $studentId ? Student::find($studentId) : null;
        $master = $masterdataId ? Masterdata::find($masterdataId) : null;

        if (!$student && !$master) {
            throw new \Exception('Learner not found.');
        }

        // Pull ledger
        $ledger = StudentLedger::where(function ($q) use ($studentId, $masterdataId) {
            if ($studentId) {
                $q->where('student_id', $studentId);
            }
            if ($masterdataId) {
                $q->orWhere('masterdata_id', $masterdataId);
            }
        })
            ->orderBy('created_at')
            ->get();

        // Running balance
        $balance = 0;
        $ledger = $ledger->map(function ($row) use (&$balance) {
            if ($row->entry_type === 'debit') {
                $balance += $row->amount;
            } else {
                $balance -= $row->amount;
            }
            $row->running_balance = $balance;
            return $row;
        });

        return [
            'student' => $student,
            'master'  => $master,
            'ledger'  => $ledger,
            'balance' => $balance,
            'statement_date' => now(),
        ];
    }
}


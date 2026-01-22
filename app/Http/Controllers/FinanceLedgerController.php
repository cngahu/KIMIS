<?php

namespace App\Http\Controllers;

use App\Models\StudentLedger;
use Illuminate\Http\Request;

class FinanceLedgerController extends Controller
{
    //
    public function viewByOwner(string $type, int $id)
    {
        $type = urldecode($type);

        $ledger = StudentLedger::where('ledger_owner_type', $type)
            ->where('ledger_owner_id', $id)
            ->orderBy('created_at')
            ->get();

        $balance = $ledger->reduce(fn ($carry, $row) =>
            $carry + ($row->entry_type === 'debit' ? $row->amount : -$row->amount),
            0
        );

        // Resolve display label
        $accountLabel = match ($type) {
            \App\Models\Student::class =>
            optional(\App\Models\Student::find($id))->student_number,
            \App\Models\Masterdata::class =>
            optional(\App\Models\Masterdata::find($id))->admissionNo,
            \App\Models\ShortTrainingApplication::class =>
            optional(\App\Models\ShortTrainingApplication::find($id))->reference,
            default => 'Unknown',
        };

        return view('finance.students.ledger', [
            'ledger'         => $ledger,
            'balance'        => $balance,
            'ownerType'      => $type,
            'ownerId'        => $id,
            'accountLabel'   => $accountLabel,
            'isProvisional'  => $ledger->where('provisional', true)->count() > 0,

            // student-only compatibility
            'studentId'      => $type === \App\Models\Student::class ? $id : null,
            'masterdataId'   => $type === \App\Models\Masterdata::class ? $id : null,
        ]);
    }

}

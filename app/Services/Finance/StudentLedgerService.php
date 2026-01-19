<?php

namespace App\Services\Finance;

use App\Models\Student;
use App\Models\StudentLedger;
use Illuminate\Support\Facades\DB;

class StudentLedgerService
{
    /**
     * Get full ledger for a student
     */
    public function getLedger(Student $student, array $filters = [])
    {
        $query = StudentLedger::where(function ($q) use ($student) {
            $q->where('student_id', $student->id);

            if ($student->admission_id) {
                $q->orWhere('masterdata_id', $student->admission_id);
            }
        })->orderBy('created_at');

        if (!empty($filters['cycle_year'])) {
            $query->where('cycle_year', $filters['cycle_year']);
        }

        if (!empty($filters['cycle_term'])) {
            $query->where('cycle_term', $filters['cycle_term']);
        }

        return $query->get();
    }

    /**
     * Compute running balance
     */
    public function computeBalance(Student $student): float
    {
        $baseQuery = StudentLedger::where(function ($q) use ($student) {
            $q->where('student_id', $student->id);

            if ($student->admission_id) {
                $q->orWhere('masterdata_id', $student->admission_id);
            }
        });

        $debits = (clone $baseQuery)
            ->where('entry_type', 'debit')
            ->sum('amount');

        $credits = (clone $baseQuery)
            ->where('entry_type', 'credit')
            ->sum('amount');

        return $debits - $credits;
    }

    /**
     * Post manual debit
     */
    public function postDebit(Student $student, array $data)
    {
        return DB::transaction(function () use ($student, $data) {

            return StudentLedger::create([
                'student_id'  => $student->id,
                'enrollment_id' => $data['enrollment_id'] ?? null,

                'entry_type'  => 'debit',
                'category'    => $data['category'],
                'amount'      => $data['amount'],

                'provisional' => false,

                'cycle_year'  => $data['cycle_year'] ?? null,
                'cycle_term'  => $data['cycle_term'] ?? null,

                'source'      => 'manual',
                'description' => $data['description'],
                'created_by'  => auth()->id(),
            ]);
        });
    }

    /**
     * Post manual credit
     */
    public function postCredit(Student $student, array $data)
    {
        return DB::transaction(function () use ($student, $data) {

            return StudentLedger::create([
                'student_id'  => $student->id,

                'entry_type'  => 'credit',
                'category'    => $data['category'],
                'amount'      => $data['amount'],

                'provisional' => false,

                'source'      => $data['source'] ?? 'manual',
                'description' => $data['description'],
                'created_by'  => auth()->id(),
            ]);
        });
    }

    /**
     * Determine clearance status
     */
    public function isCleared(Student $student): bool
    {
        return $this->computeBalance($student) <= 0;
    }
}

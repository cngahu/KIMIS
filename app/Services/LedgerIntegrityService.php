<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentLedger;

class LedgerIntegrityService
{
    /**
     * Ensure all legacy ledger rows are linked to this student.
     * Safe, idempotent, and fast.
     */
    public function ensureStudentLedgerLinked(Student $student): void
    {
        if (!$student->admission_id) {
            return;
        }

        // Only update if there are unlinked rows
        $exists = StudentLedger::where('masterdata_id', $student->admission_id)
            ->whereNull('student_id')
            ->exists();

        if (!$exists) {
            return;
        }

        StudentLedger::where('masterdata_id', $student->admission_id)
            ->whereNull('student_id')
            ->update([
                'student_id' => $student->id,
            ]);
    }
}


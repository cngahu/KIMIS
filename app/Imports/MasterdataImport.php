<?php

namespace App\Imports;

use App\Models\Masterdata;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterdataImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Prevent duplicates using admissionNo
            Masterdata::updateOrCreate(
                [
                    'admissionNo' => $row['admissionno'] ?? null,
                ],
                [
                    'full_name' => $row['full_name'] ?? null,

                    'campus' => $row['campus'] ?? null,
                    'campus_id' => null,

                    'department' => $row['department'] ?? null,
                    'department_id' => null,

                    'course_name' => $row['course_name'] ?? null,
                    'course_code' => $row['course_code'] ?? null,
                    'course_id' => null,

                    'current' => $row['current'] ?? null,
                    'intake' => $row['intake'] ?? null,

                    'balance' => $row['balance'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'email' => $row['email'] ?? null,
                    'idno' => $row['idno'] ?? null,
                ]
            );
        }
    }

    /** Validate rows */
    public function rules(): array
    {
        return [
            '*.admissionno' => ['required'],
            '*.email' => ['nullable', 'email'],
            '*.balance' => ['nullable', 'numeric'],
        ];
    }

    /** Speed optimizations */
    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}

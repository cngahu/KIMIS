<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CertificateData;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportCertificateData extends Command
{
    protected $signature = 'certificates:import {file=storage/app/import/certificates.xlsx}';

    protected $description = 'Import certificate data from the training Excel file';

    public function handle()
    {
        $filePath = base_path($this->argument('file'));

        if (! file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Reading file: {$filePath}");

        $spreadsheet = IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();

        // --- COURSE-LEVEL META (from top rows of sheet) ---
        // According to your file:
        // Row2: "VENUE" | "KIHBT NAIROBI"
        // Row3: "COURSE" | "REFRESHER AND DEFENSIVE"
        // Row4: "FROM" | date
        // Row5: "TO" | date
        // Row6: "COURSE NUMBER" | "REF/2025/014"
        $venue       = $sheet->getCell('B2')->getValue();
        $courseName  = $sheet->getCell('B3')->getValue();
        $fromRaw     = $sheet->getCell('B4')->getValue();
        $toRaw       = $sheet->getCell('B5')->getValue();
        $courseNo    = $sheet->getCell('B6')->getValue();

        $startDate = $this->convertExcelDate($fromRaw);
        $endDate   = $this->convertExcelDate($toRaw);

        // Participant table header row is row 7 (1-based) => columns:
        // A: No
        // B: Admn. No
        // C: SURNAME
        // D: OTHER NAMES
        // E: SEX
        // F: AGE
        // G: HIGHEST LEVEL OF EDUCATION
        // H: OCCUPATION
        // I: DEPARTMENT
        // J: ORGANIZATION & POSTAL ADDRESS
        // K: COUNTY
        // L: EMail
        // M: SPONSOR
        // N: RECEIPT NUMBER
        // O: INVOICED
        // P: AMOUNT PAID
        // Q: DUE
        // R: CERT NO.
        // S: COMMENT / SIGNATURE

        $firstDataRow = 8; // row 8 is first participant row
        $lastRow      = $sheet->getHighestDataRow();

        $imported = 0;

        for ($row = $firstDataRow; $row <= $lastRow; $row++) {

            $serial = $sheet->getCell("A{$row}")->getValue();

            // Skip totally empty rows
            if ($serial === null || $serial === '') {
                continue;
            }

            $admnNo     = $sheet->getCell("B{$row}")->getValue();
            $surname    = $sheet->getCell("C{$row}")->getValue();
            $otherNames = $sheet->getCell("D{$row}")->getValue();
            $sex        = $sheet->getCell("E{$row}")->getValue();
            $age        = $sheet->getCell("F{$row}")->getValue();
            $education  = $sheet->getCell("G{$row}")->getValue();
            $occupation = $sheet->getCell("H{$row}")->getValue();
            $department = $sheet->getCell("I{$row}")->getValue();
            $orgAddr    = $sheet->getCell("J{$row}")->getValue();
            $county     = $sheet->getCell("K{$row}")->getValue();
            $email      = $sheet->getCell("L{$row}")->getValue();
            $sponsor    = $sheet->getCell("M{$row}")->getValue();
            $receiptNo  = $sheet->getCell("N{$row}")->getValue();
            $invoiced   = $sheet->getCell("O{$row}")->getValue();
            $paid       = $sheet->getCell("P{$row}")->getValue();
            $due        = $sheet->getCell("Q{$row}")->getValue();
            $certNo     = $sheet->getCell("R{$row}")->getValue();
            $comment    = $sheet->getCell("S{$row}")->getValue();

            CertificateData::create([
                'venue'                     => $venue,
                'course_name'               => $courseName,
                'course_number'             => $courseNo,
                'start_date'                => $startDate,
                'end_date'                  => $endDate,

                'serial_no'                 => is_numeric($serial) ? (int) $serial : null,
                'admn_no'                   => $admnNo,
                'surname'                   => $surname,
                'other_names'               => $otherNames,
                'sex'                       => $sex,
                'age'                       => is_numeric($age) ? (int) $age : null,
                'highest_level_of_education'=> $education,
                'occupation'                => $occupation,
                'department'                => $department,
                'organization_postal_address'=> $orgAddr,
                'county'                    => $county,
                'email'                     => $email,
                'sponsor'                   => $sponsor,
                'receipt_number'            => $receiptNo,
                'invoiced_amount'           => $this->toDecimal($invoiced),
                'amount_paid'               => $this->toDecimal($paid),
                'amount_due'                => $this->toDecimal($due),
                'certificate_no'            => $certNo,
                'comment'                   => $comment,
            ]);

            $imported++;
        }

        $this->info("Imported {$imported} certificate rows.");

        return 0;
    }

    /**
     * Convert Excel date or plain string to Y-m-d or null.
     */
    protected function convertExcelDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // If numeric, treat as Excel date serial
        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        // Try normal PHP strtotime
        $time = strtotime($value);
        return $time ? date('Y-m-d', $time) : null;
    }

    /**
     * Safely cast numeric-ish values to decimal.
     */
    protected function toDecimal($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (is_numeric($value)) {
            return (float) $value;
        }
        // Try to clean commas etc.
        $clean = str_replace([',', ' '], '', $value);
        return is_numeric($clean) ? (float) $clean : null;
    }
}

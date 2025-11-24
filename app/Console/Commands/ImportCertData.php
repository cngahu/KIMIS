<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ImportCertData extends Command
{
    protected $signature = 'import:cert-data {file}';
    protected $description = 'Import certificate data from Excel file to cert_data table';

    public function handle()
    {
        $originalFilePath = $this->argument('file');
        $filePath = $originalFilePath;

        // If the file doesn't exist, try the storage/app/import directory
        if (!file_exists($filePath)) {
            $filePath = storage_path('app/import/' . $originalFilePath);
        }

        if (!file_exists($filePath)) {
            $this->error("File not found: {$originalFilePath} (also tried: {$filePath})");
            return Command::FAILURE;
        }

        $this->info("Loading Excel file: {$filePath}");

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            $importedCount = 0;
            $skippedHeader = false;

            DB::transaction(function () use ($rows, &$importedCount, &$skippedHeader) {
                foreach ($rows as $rowIndex => $row) {
                    // Skip the header row (first row)
                    if (!$skippedHeader) {
                        $skippedHeader = true;
                        $this->info("Skipping header row...");
                        continue;
                    }

                    // Skip empty rows (no admission number)
                    if (empty($row['B']) || $row['B'] === 'Admn. No') {
                        continue;
                    }

                    // Prepare the data for insertion
                    $data = [
                        'No' => $this->cleanValue($row['A']),
                        'Admn_No' => $this->cleanValue($row['B']),
                        'COURSE' => $this->cleanValue($row['C']),
                        'Students_Name' => $this->cleanValue($row['D']),
                        'Gender' => $this->cleanValue($row['E']),
                        'ID_No' => $this->cleanValue($row['F']),
                        'Mobile_No' => $this->cleanValue($row['G']),
                        'COUNTY' => $this->cleanValue($row['H']),
                        'EMail' => $this->cleanValue($row['I']),
                        'SPONSOR' => $this->cleanValue($row['J']),
                        'RECEIPT_NUMBER' => $this->cleanValue($row['K']),
                        'INVOICED' => $this->parseNumber($row['L']),
                        'AMOUNT_PAID' => $this->parseNumber($row['M']),
                        'DUE' => $this->parseNumber($row['N']),
                        'CERT_NO' => $this->cleanValue($row['O']),
                        'START_DATE' => $this->parseDateTime($row['P']),
                        'END_DATE' => $this->parseDateTime($row['Q']),
                        'COMMENT_SIGNATURE' => $this->cleanValue($row['R']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Insert into database
                    DB::table('cert_data')->insert($data);
                    $importedCount++;

                    // Show progress for large files
                    if ($importedCount % 10 === 0) {
                        $this->info("Imported {$importedCount} records...");
                    }
                }
            });

            $this->info("Successfully imported {$importedCount} records.");
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Import failed: " . $e->getMessage());
            $this->error("File: " . $e->getFile());
            $this->error("Line: " . $e->getLine());
            return Command::FAILURE;
        }
    }

    /**
     * Clean string values (remove leading apostrophes, trim whitespace)
     */
    private function cleanValue($value): ?string
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }

        // Handle numeric values that might be strings
        if (is_numeric($value)) {
            return (string)$value;
        }

        $cleaned = trim(ltrim((string)$value, "'"));
        return $cleaned === '' ? null : $cleaned;
    }

    /**
     * Parse numeric values
     */
    private function parseNumber($value): ?float
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }

        // If it's already a float or int, return it
        if (is_float($value) || is_int($value)) {
            return (float)$value;
        }

        // Remove any non-numeric characters except decimal point and minus
        $clean = preg_replace('/[^\d.-]/', '', (string)$value);

        if ($clean === '' || $clean === '-') {
            return null;
        }

        return is_numeric($clean) ? (float)$clean : null;
    }

    /**
     * Parse date/time values
     */
    private function parseDateTime($value): ?string
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }

        try {
            // If it's already a DateTime object (from Excel)
            if ($value instanceof \DateTime) {
                return $value->format('Y-m-d H:i:s');
            }

            // If it's an Excel serial date (numeric)
            if (is_numeric($value)) {
                $date = Date::excelToDateTimeObject($value);
                return $date->format('Y-m-d H:i:s');
            }

            // If it's a date string (like "2025-11-10 00:00:00")
            $dateString = trim((string)$value);
            if (!empty($dateString)) {
                // Extract just the date part if it has time
                if (preg_match('/^(\d{4}-\d{2}-\d{2})/', $dateString, $matches)) {
                    return $matches[1] . ' 00:00:00';
                }

                // Try to parse as carbon date
                return Carbon::parse($dateString)->format('Y-m-d H:i:s');
            }

            return null;
        } catch (\Exception $e) {
            $this->warn("Failed to parse date: '{$value}' - " . $e->getMessage());
            return null;
        }
    }
}

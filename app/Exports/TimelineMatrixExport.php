<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class TimelineMatrixExport implements FromArray, WithStyles
{
    public function __construct(private array $matrix) {}

    public function array(): array
    {
        $rows = [];

        // Header
        $header = ['Course / Intake'];
        foreach ($this->matrix['columns'] as $col) {
            $header[] = \Carbon\Carbon::createFromFormat('Y-m', $col)->format('M Y');
        }
        $rows[] = $header;

        // Data
        foreach ($this->matrix['rows'] ?? [] as $row) {
            $line = [$row['label']];
            foreach ($this->matrix['columns'] as $col) {
                $line[] = $row['cells'][$col]['code'] ?? '';
            }
            $rows[] = $line;
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        foreach ($sheet->getRowIterator(2) as $row) {
            foreach ($row->getCellIterator(2) as $cell) {
                $value = $cell->getValue();

                $color = match ($value) {
                    'VACATION' => 'EEEEEE',
                    'ATTACHMENT' => 'FFE5CC',
                    'INTERNSHIP' => 'EADCFF',
                    default => $value ? 'D9ECFF' : null,
                };

                if ($color) {
                    $sheet->getStyle($cell->getCoordinate())
                        ->getFill()
                        ->setFillType('solid')
                        ->getStartColor()
                        ->setARGB($color);
                }
            }
        }

        return [];
    }
}

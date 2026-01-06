<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ErrorLogService
{
    protected string $logPath;

    public function __construct()
    {
        // Laravel default log file
        $this->logPath = storage_path('logs/laravel.log');
    }

    /**
     * Get paginated ERROR-level logs from laravel.log
     */
    public function getPaginated(int $perPage = 50): LengthAwarePaginator
    {
        // Always return a paginator
        if (!file_exists($this->logPath)) {
            return new LengthAwarePaginator(
                collect(),
                0,
                $perPage,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        $lines = collect(file($this->logPath, FILE_IGNORE_NEW_LINES))
            ->filter(fn($line) => str_contains($line, '.ERROR:'))
            ->reverse()
            ->map(fn($line) => $this->parseLine($line))
            ->values();

        return $this->paginate($lines, $perPage);
    }

    /**
     * Clear laravel.log safely
     */
    public function clear(): void
    {
        if (file_exists($this->logPath)) {
            // Truncate file but keep permissions intact
            file_put_contents($this->logPath, '');
        }
    }

    /**
     * Parse a single Laravel log line
     */
    protected function parseLine(string $line): array
    {
        preg_match(
            '/\[(.*?)\]\s+(\w+)\.(\w+):\s+(.*)/',
            $line,
            $matches
        );

        return [
            'time' => $matches[1] ?? '-',
            'env' => $matches[2] ?? '-',
            'level' => strtoupper($matches[3] ?? '-'),
            'message' => $matches[4] ?? $line,
        ];
    }

    /**
     * Manual paginator for collections
     */
    protected function paginate(Collection $items, int $perPage): LengthAwarePaginator
    {
        $page = (int)request()->get('page', 1);

        $slice = $items->slice(
            ($page - 1) * $perPage,
            $perPage
        );

        return new LengthAwarePaginator(
            $slice,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\Errors;

use App\Http\Controllers\Controller;
use App\Services\ErrorLogService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
class ErrorLogController extends Controller
{


    public function index()
    {
        $logFile = storage_path('logs/laravel.log');

        $logs = collect();

        if (file_exists($logFile)) {
            $logs = collect(file($logFile, FILE_IGNORE_NEW_LINES))
                ->filter(fn ($line) => str_contains($line, '.ERROR:'))
                ->reverse()
                ->map(function ($line) {
                    preg_match(
                        '/\[(.*?)\]\s+(\w+)\.(\w+):\s+(.*)/',
                        $line,
                        $matches
                    );

                    return [
                        'time'    => $matches[1] ?? '-',
                        'env'     => $matches[2] ?? '-',
                        'level'   => $matches[3] ?? '-',
                        'message' => $matches[4] ?? $line,
                    ];
                });
        }

        $perPage = 50;
        $page = request()->get('page', 1);

        $paginator = new LengthAwarePaginator(
            $logs->slice(($page - 1) * $perPage, $perPage),
            $logs->count(),
            $perPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('admin.logs.index', [
            'logs' => $paginator
        ]);
    }


    public function clear(ErrorLogService $service)
    {
        $service->clear();

        return back()->with('success', 'Error logs cleared successfully.');
    }
}

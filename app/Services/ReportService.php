<?php

namespace App\Services;

use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportService0
{
    public function applications($request)
    {
        return Application::with(['course','reviewer','homeCounty','currentCounty'])
            ->filter(request()->all()) // optional custom filter scope
            ->orderBy('created_at','DESC')
            ->get();
    }

    public function decisions($request)
    {
        return Application::with(['course','reviewer'])
            ->whereIn('status', ['approved','rejected'])
            ->filter(request()->all())
            ->get()
            ->map(function($app){
                $app->processing_hours =
                    $app->updated_at->diffInHours($app->created_at);
                return $app;
            });
    }

    public function reviewer($request)
    {
        return Application::with(['course','reviewer'])
            ->whereNotNull('reviewer_id')
            ->filter(request()->all())
            ->orderBy('reviewer_id')
            ->get()
            ->groupBy('reviewer_id');
    }

    public function generatePdf($view, $data, $filename)
    {
        $pdf = Pdf::loadView($view, compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->download($filename);
    }
}

class ReportService
{
    public function applications($request)
    {
        $query = Application::with(['course']);

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return $query->get();
    }

    public function generatePdf($view, $data, $filename)
    {
        $pdf = Pdf::loadView($view, compact('data'))->setPaper('A4', 'portrait');
        return $pdf->download($filename);
    }
}

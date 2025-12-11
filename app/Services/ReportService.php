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
    public function applications0($request)
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
    public function applications($request, $limitPreview = true)
    {
        $query = Application::with([
            'course',
            'homeCounty',
            'currentCounty',
            'currentSubcounty',
            'postalCode'
        ]);

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

        // ⚡ PREVIEW SHOULD NOT HANG: LIMIT RESULTS
        if ($limitPreview) {
            return $query->orderBy('id', 'desc')->limit(2000)->get();
        }

        // PDF export (no limit)
        return $query->orderBy('id', 'desc')->get();
    }

//    public function generatePdf($view, $data, $filename)
//    {
//        $pdf = Pdf::loadView($view, compact('data'))->setPaper('A4', 'portrait');
//        return $pdf->download($filename);
//    }
    public function generatePdf($view, $data, $filename)
    {
        $pdf = Pdf::loadView($view, compact('data'))
            ->setPaper('A4', 'landscape');   // 👈 LANDSCAPE MODE

        return $pdf->download($filename);
    }
    public function rejectedApplications($request)
    {
        $query = Application::with(['course', 'reviewer'])
            ->where('status', 'rejected');

        if ($request->from_date) {
            $query->whereDate('updated_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('updated_at', '<=', $request->to_date);
        }

        if ($request->reviewer_id) {
            $query->where('reviewer_id', $request->reviewer_id);
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        return $query->orderBy('updated_at', 'desc')->get();
    }

}

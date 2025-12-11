<?php

namespace App\Services;
use App\Models\ShortTrainingApplication;
use App\Models\ShortTraining;
use App\Models\Training;
use Illuminate\Support\Facades\DB;
class ShortCourseReportService
{
    public function applications($filters)
    {
        $query = ShortTrainingApplication::with(['training.course', 'participants']);

        if (!empty($filters['training_id'])) {
            $query->where('training_id', $filters['training_id']);
        }

        if (!empty($filters['financier'])) {
            $query->where('financier', $filters['financier']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        return $query->orderBy('id', 'desc')->get();
    }


    /**
     * PDF export wrapper
     */
    public function generatePdf($view, $data, $filename)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, $data)
            ->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }

    public function trainingSummary($filters = [])
    {
        // Base training query
        $trainings = \App\Models\Training::with('course')
            ->orderBy('start_date', 'desc');

        // Optional filters
        if (!empty($filters['course_id'])) {
            $trainings->where('course_id', $filters['course_id']);
        }

        if (!empty($filters['from_date'])) {
            $trainings->whereDate('start_date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $trainings->whereDate('start_date', '<=', $filters['to_date']);
        }

        $trainings = $trainings->get();

        // Build computed stats per training schedule
        $summary = [];

        foreach ($trainings as $t) {

            // Applications for this schedule
            $apps = \App\Models\ShortTrainingApplication::where('training_id', $t->id)
                ->with('participants', 'invoice')
                ->get();

            $totalApplications = $apps->count();
            $totalParticipants = $apps->sum('total_participants');

            $expectedRevenue = $apps->sum(fn ($a) => $a->metadata['total_amount'] ?? 0);
            $paidRevenue = $apps->where('payment_status', 'paid')
                ->sum(fn ($a) => $a->metadata['total_amount'] ?? 0);

            $pendingRevenue = $expectedRevenue - $paidRevenue;

            $selfSponsored = $apps->where('financier', 'self')->count();
            $employerSponsored = $apps->where('financier', 'employer')->count();

            $summary[] = [
                'training' => $t,
                'course_name' => $t->course->course_name,
                'start_date' => $t->start_date,
                'end_date' => $t->end_date,
                'total_applications' => $totalApplications,
                'total_participants' => $totalParticipants,
                'expected_revenue' => $expectedRevenue,
                'paid_revenue' => $paidRevenue,
                'pending_revenue' => $pendingRevenue,
                'self_sponsored' => $selfSponsored,
                'employer_sponsored' => $employerSponsored,
            ];
        }

        return $summary;
    }
    public function participantsReport($filters = [])
    {
        $query = ShortTraining::with([
            'application',
            'application.invoice',
            'application.training.course',
            'homeCounty',
            'currentCounty',
            'currentSubcounty'
        ]);

        // Optional Filters
        if (!empty($filters['course_id'])) {
            $query->whereHas('application.training', function ($q) use ($filters) {
                $q->where('course_id', $filters['course_id']);
            });
        }

        if (!empty($filters['training_id'])) {
            $query->where('training_id', $filters['training_id']);
        }

        if (!empty($filters['from_date'])) {
            $query->whereHas('application.training', function ($q) use ($filters) {
                $q->whereDate('start_date', '>=', $filters['from_date']);
            });
        }

        if (!empty($filters['to_date'])) {
            $query->whereHas('application.training', function ($q) use ($filters) {
                $q->whereDate('start_date', '<=', $filters['to_date']);
            });
        }

        return $query->get();
    }

}

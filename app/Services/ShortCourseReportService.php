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
    public function participantsReport0($filters = [])
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
    public function participantsReport($filters = [])
    {
        $query = ShortTraining::with([
            'application',
            'application.invoice',
            'application.training.course',
            'homeCounty',
            'currentCounty',
            'currentSubcounty',
            'postalCode'
        ]);

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

        return $query->get()->map(function ($record) {

            $invoice = $record->application->invoice ?? null;

            $record->payment_status = $invoice?->status ?? 'pending';
            $record->payment_amount = $invoice?->amount ?? 0;
            $record->invoice_number = $invoice?->invoice_number ?? null;

            return $record;
        });
    }
    public function employerReport($filters = [])
    {
        $query = ShortTrainingApplication::with([
            'participants',
            'training.course',
            'invoice'
        ])->where('financier', 'employer'); // Only employer-sponsored

        // Optional filtering
        if (!empty($filters['course_id'])) {
            $query->whereHas('training', function ($q) use ($filters) {
                $q->where('course_id', $filters['course_id']);
            });
        }

        if (!empty($filters['training_id'])) {
            $query->where('training_id', $filters['training_id']);
        }

        if (!empty($filters['from_date'])) {
            $query->whereHas('training', function ($q) use ($filters) {
                $q->whereDate('start_date', '>=', $filters['from_date']);
            });
        }

        if (!empty($filters['to_date'])) {
            $query->whereHas('training', function ($q) use ($filters) {
                $q->whereDate('start_date', '<=', $filters['to_date']);
            });
        }

        $records = $query->get();

        // Group by employer
        $grouped = [];

        foreach ($records as $app) {

            $key = $app->employer_name ?? 'UNKNOWN';

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'employer_name'      => $app->employer_name,
                    'contact_person'     => $app->employer_contact_person,
                    'email'              => $app->employer_email,
                    'phone'              => $app->employer_phone,
                    'applications'       => 0,
                    'participants'       => 0,
                    'expected_revenue'   => 0,
                    'paid_revenue'       => 0,
                    'pending_revenue'    => 0,
                    'trainings'          => [],
                ];
            }

            $inv = $app->invoice ?? null;
            $totalAmount = $app->metadata['total_amount'] ?? 0;

            $grouped[$key]['applications'] += 1;
            $grouped[$key]['participants'] += $app->total_participants;
            $grouped[$key]['expected_revenue'] += $totalAmount;

            if ($inv && $inv->status === 'paid') {
                $grouped[$key]['paid_revenue'] += $totalAmount;
            } else {
                $grouped[$key]['pending_revenue'] += $totalAmount;
            }

            $grouped[$key]['trainings'][] = [
                'course_name' => $app->training->course->course_name,
                'start_date'  => $app->training->start_date,
                'end_date'    => $app->training->end_date,
                'participants'=> $app->total_participants,
                'invoice_no'  => $inv?->invoice_number,
                'amount'      => $totalAmount,
                'status'      => $inv?->status ?? 'pending',
            ];
        }

        return $grouped;
    }


    public function employerStatement($employerName)
    {
        $apps = ShortTrainingApplication::with([
            'participants',
            'training.course',
            'invoice'
        ])
            ->where('financier', 'employer')
            ->where('employer_name', $employerName)
            ->get();

        if ($apps->isEmpty()) {
            return null;
        }

        $statement = [
            'employer_name' => $employerName,
            'contact_person' => $apps->first()->employer_contact_person,
            'email' => $apps->first()->employer_email,
            'phone' => $apps->first()->employer_phone,
            'address' => $apps->first()->employer_postal_address,
            'town' => $apps->first()->employer_town,
            'county' => optional($apps->first()->employerCounty)->name ?? null,
            'trainings' => [],
            'totals' => [
                'expected' => 0,
                'paid' => 0,
                'pending' => 0,
            ]
        ];

        foreach ($apps as $app) {

            $invoice = $app->invoice;
            $amount = $app->metadata['total_amount'] ?? 0;
            $paid = ($invoice && $invoice->status === 'paid') ? $amount : 0;

            $statement['trainings'][] = [
                'course_name'    => $app->training->course->course_name,
                'start_date'     => $app->training->start_date,
                'end_date'       => $app->training->end_date,
                'participants'   => $app->participants,
                'participants_count' => $app->total_participants,
                'invoice_number' => $invoice?->invoice_number,
                'amount'         => $amount,
                'paid'           => $paid,
                'balance'        => $amount - $paid,
                'status'         => $invoice?->status ?? 'pending',
            ];

            // Accumulate totals
            $statement['totals']['expected'] += $amount;
            $statement['totals']['paid'] += $paid;
            $statement['totals']['pending'] += ($amount - $paid);
        }

        return $statement;
    }
    public function revenueReport($filters = [])
    {
        $trainings = \App\Models\Training::with(['course'])
            ->orderBy('start_date', 'desc');

        // Optional Filters
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

        $summary = [];

        foreach ($trainings as $t) {

            $apps = \App\Models\ShortTrainingApplication::where('training_id', $t->id)
                ->with(['invoice', 'participants'])
                ->get();

            $totalParticipants = $apps->sum('total_participants');

            // Revenue (from metadata)
            $expected = $apps->sum(fn($a) => $a->metadata['total_amount'] ?? 0);

            // Paid revenue (based on invoice->status)
            $paid = $apps->filter(function ($a) {
                return optional($a->invoice)->status === 'paid';
            })->sum(fn($a) => $a->metadata['total_amount'] ?? 0);

            $pending = $expected - $paid;

            $paymentRate = $expected > 0
                ? round(($paid / $expected) * 100, 1)
                : 0;

            $summary[] = [
                'training'           => $t,
                'course'             => $t->course->course_name,
                'start_date'         => $t->start_date,
                'end_date'           => $t->end_date,
                'participants'       => $totalParticipants,
                'expected'           => $expected,
                'paid'               => $paid,
                'pending'            => $pending,
                'payment_rate'       => $paymentRate,
            ];
        }

        return $summary;
    }

}

<?php

namespace App\Services;
use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;
class ApplicationReportService
{
    public function getFilteredApplications(array $filters)
    {
        $query = Application::query()
            ->with(['course', 'homeCounty', 'currentCounty', 'currentSubcounty', 'postalCode'])
            ->orderBy('id', 'desc');

        // FILTER: Date Range
        if (!empty($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        // FILTER: Course
        if (!empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        // FILTER: Status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // ⚡ PERFORMANCE TRICK:
        // return a CHUNKED result for large datasets
        return $query->limit(5000)->get();
    }
}

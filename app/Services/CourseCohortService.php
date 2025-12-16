<?php

namespace App\Services;

use App\Models\CourseCohort;
use Illuminate\Support\Facades\DB;

class CourseCohortService
{
    public function create(array $data): CourseCohort
    {
        return DB::transaction(function () use ($data) {
            return CourseCohort::create([
                'course_id'    => $data['course_id'],
                'intake_year'  => $data['intake_year'],
                'intake_month' => $data['intake_month'],
                'status'       => 'active',
            ]);
        });
    }

    public function list(array $filters = [])
    {
        return CourseCohort::with('course.college')
            ->when($filters['course_id'] ?? null, fn ($q, $v) => $q->where('course_id', $v))
            ->when($filters['year'] ?? null, fn ($q, $v) => $q->where('intake_year', $v))
            ->latest()
            ->paginate($filters['per_page'] ?? 10);
    }
}


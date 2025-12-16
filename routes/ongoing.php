<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseCohortController;
use App\Http\Controllers\Admin\CourseStageController;
use App\Http\Controllers\Admin\CohortStageTimelineController;
use App\Http\Controllers\Admin\AcademicTimelineController;
use App\Http\Controllers\Admin\AcademicTimelineExportController;


Route::middleware(['role:superadmin|registrar'])->group(function () {


    // Course Cohorts
    Route::get('/course-cohorts', [CourseCohortController::class, 'index'])->name('course_cohorts.index');
    Route::get('/course-cohorts/create', [CourseCohortController::class, 'create'])->name('course_cohorts.create');
    Route::post('/course-cohorts/store', [CourseCohortController::class, 'store'])->name('course_cohorts.store');
    Route::get('/course-cohorts/{cohort}', [CourseCohortController::class, 'show'])->name('course_cohorts.show');



    // Course Stages
    Route::get('/course-stages', [CourseStageController::class, 'index'])->name('course_stages.index');
    Route::get('/course-stages/create', [CourseStageController::class, 'create'])->name('course_stages.create');
    Route::post('/course-stages/store', [CourseStageController::class, 'store'])->name('course_stages.store');
    Route::get('/course-stages/{stage}', [CourseStageController::class, 'show'])->name('course_stages.show');

    Route::get('/course-cohorts/{cohort}/timelines',
        [CohortStageTimelineController::class, 'index']
    )->name('cohort_timelines.index');

    Route::get(
        '/course-cohorts/{cohort}/timelines/create',
        [CohortStageTimelineController::class, 'create']
    )->name('cohort_timelines.create');

    Route::post(
        '/course-cohorts/{cohort}/timelines',
        [CohortStageTimelineController::class, 'store']
    )->name('cohort_timelines.store');


    // INDIVIDUAL COHORT TIMELINE (Horizontal)
    Route::get(
        '/course-cohorts/{cohort}/timeline-horizontal',
        [AcademicTimelineController::class, 'cohort']
    )->name('timeline.cohort');

// GLOBAL TIMELINE (All cohorts, grouped by campus)
    Route::get(
        '/academic-timeline-horizontal',
        [AcademicTimelineController::class, 'global']
    )->name('timeline.global');

    // Individual cohort PDF
    Route::get(
        '/course-cohorts/{cohort}/timeline-horizontal/pdf',
        [AcademicTimelineExportController::class, 'cohortPdf']
    )->name('timeline.cohort.pdf');

// Global PDF
    Route::get(
        '/academic-timeline-horizontal/pdf',
        [AcademicTimelineExportController::class, 'globalPdf']
    )->name('timeline.global.pdf');

});

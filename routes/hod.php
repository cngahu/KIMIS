<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Hod\HodDashboardController;
use App\Http\Controllers\Hod\HodParticipantController;
use App\Http\Controllers\Admin\AdminClassListController;
use App\Http\Controllers\Admin\AdminClassListParticipantController;
use App\Http\Controllers\Hod\HodShortCourseController;
use App\Http\Controllers\Hod\HodShortCourseApplicationController;
use App\Http\Controllers\Hod\HodShortCourseParticipantController;

Route::middleware(['auth', 'role:hod'])->prefix('hod')->group(function () {

        Route::get('/dashboard', [HodDashboardController::class, 'index'])
            ->name('hod.dashboard');

        Route::get('/nominal-roll/{course}/{cohort}', [HodDashboardController::class, 'nominalRoll'])
            ->name('hod.nominal.roll');

        Route::get(
            '/nominal-roll/{course}/{cohort}',
            [HodDashboardController::class, 'nominalRoll']
        )->name('hod.nominal.roll');
        Route::get(
            '/hod/quality-check/{course}/{cohort}',
            [HodDashboardController::class, 'qualityCheck']
        )->name('hod.quality.check');



        Route::get(
            '/-master-dashboard',
            [HodDashboardController::class, 'indexMaster']
        )->name('hod.master.dashboard');





    });




Route::middleware(['auth', 'role:hod'])->group(function () {

    Route::get(
        '/hod/courses/{course}/cohorts/{cohort}/participants',
        [HodParticipantController::class, 'index']
    )->name('hod.participants.index');

    Route::get(
        '/hod/courses/{course}/cohorts/{cohort}/participants/print',
        [HodParticipantController::class, 'print']
    )->name('hod.participants.print');

});



Route::middleware(['auth', 'role:registrar|superadmin|admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {






        Route::get(
            '/class-lists',
            [AdminClassListController::class, 'indexMaster']
        )->name('class-lists.index');


        Route::get(
            '/hod/courses/{course}/cohorts/{cohort}/participants/print',
            [AdminClassListController::class, 'print']
        )->name('hod.participants.print');


    });


// routes/web.php

Route::middleware(['auth', 'role:hod'])
    ->prefix('hod/short-courses')
    ->name('hod.short_courses.')
    ->group(function () {

        // Dashboard: list short courses
        Route::get('/', [HodShortCourseController::class, 'index'])
            ->name('index');

        // View schedules for a specific course
        Route::get('{course}', [HodShortCourseController::class, 'schedules'])
            ->name('schedules');

        // 🔥 NEW — Applications per schedule
        Route::get(
            'schedules/{training}/applications',
            [HodShortCourseApplicationController::class, 'index']
        )->name('applications');

        // 🔥 NEW — Revenue dashboard per schedule
        Route::get(
            'schedules/{training}/revenue',
            [HodShortCourseApplicationController::class, 'revenue']
        )->name('revenue');

        Route::get(
            'schedules/{training}/participants',
            [HodShortCourseParticipantController::class, 'index']
        )->name('participants');

    });


// routes/web.php


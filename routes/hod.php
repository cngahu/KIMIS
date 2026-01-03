<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Hod\HodDashboardController;
use App\Http\Controllers\Hod\HodParticipantController;
use App\Http\Controllers\Admin\AdminClassListController;
use App\Http\Controllers\Admin\AdminClassListParticipantController;

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

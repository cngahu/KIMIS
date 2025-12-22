<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Hod\HodDashboardController;

Route::middleware(['auth', 'role:hod'])
    ->prefix('hod')
    ->group(function () {

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


    });

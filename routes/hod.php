<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORTS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\HOD\HodDashboardController;
use App\Http\Controllers\HOD\HodParticipantController;
use App\Http\Controllers\HOD\HodShortCourseController;
use App\Http\Controllers\HOD\HodShortCourseApplicationController;
use App\Http\Controllers\HOD\HodShortCourseParticipantController;
use App\Http\Controllers\Admin\AdminClassListController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\Student\StudentPaymentController;
use App\Http\Controllers\Student\StudentAuthController;

/*
|--------------------------------------------------------------------------
| HOD ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hod'])
    ->prefix('hod')
    ->name('hod.')
    ->group(function () {

        Route::get('/dashboard', [HodDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/master-dashboard', [HodDashboardController::class, 'indexMaster'])
            ->name('master.dashboard');

        Route::get('/nominal-roll/{course}/{cohort}', [HodDashboardController::class, 'nominalRoll'])
            ->name('nominal.roll');

        Route::get('/quality-check/{course}/{cohort}', [HodDashboardController::class, 'qualityCheck'])
            ->name('quality.check');

        Route::get('/courses/{course}/cohorts/{cohort}/participants', [HodParticipantController::class, 'index'])
            ->name('participants.index');

        Route::get('/courses/{course}/cohorts/{cohort}/participants/print', [HodParticipantController::class, 'print'])
            ->name('participants.print');
    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:registrar|superadmin|admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/class-lists', [AdminClassListController::class, 'indexMaster'])
            ->name('class-lists.index');

        Route::get('/class-lists/{course}/{cohort}/print', [AdminClassListController::class, 'print'])
            ->name('class-lists.print');
    });

/*
|--------------------------------------------------------------------------
| HOD SHORT COURSES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hod'])
    ->prefix('hod/short-courses')
    ->name('hod.short_courses.')
    ->group(function () {

        Route::get('/', [HodShortCourseController::class, 'index'])
            ->name('index');

        Route::get('{course}', [HodShortCourseController::class, 'schedules'])
            ->name('schedules');

        Route::get('schedules/{training}/applications', [HodShortCourseApplicationController::class, 'index'])
            ->name('applications');

        Route::get('schedules/{training}/revenue', [HodShortCourseApplicationController::class, 'revenue'])
            ->name('revenue');

        Route::get('schedules/{training}/participants', [HodShortCourseParticipantController::class, 'index'])
            ->name('participants');
    });

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');

        // ✅ Fixed: 'showProfile' matches the method in StudentProfileController
        Route::get('/profile', [StudentProfileController::class, 'showProfile'])
            ->name('profile.show');

        Route::post('/profile/update', [StudentProfileController::class, 'update'])
            ->name('profile.update');

        Route::post('/profile/photo', [StudentProfileController::class, 'updatePhoto'])
            ->name('profile.photo');

        Route::get('/courses', [StudentCourseController::class, 'index'])
            ->name('courses');

        Route::get('/payments', [StudentPaymentController::class, 'index'])
            ->name('payments');

        Route::post('/logout', [StudentAuthController::class, 'logout'])
            ->name('logout');
    });

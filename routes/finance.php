<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\FinanceReportController;

// DAILY COLLECTIONS REPORT
Route::get('/reports/daily-collections',[FinanceReportController::class, 'dailyCollectionsIndex'])
    ->name('reports.daily.collections');

Route::get('/reports/daily-collections/pdf', [FinanceReportController::class, 'dailyCollectionsPdf'])
    ->name('reports.daily.collections.pdf');

// OUTSTANDING PAYMENTS REPORT
Route::get('/reports/outstanding', [FinanceReportController::class, 'outstandingIndex'])
    ->name('reports.outstanding');

Route::get('/reports/outstanding/pdf', [FinanceReportController::class, 'outstandingPdf'])
    ->name('reports.outstanding.pdf');

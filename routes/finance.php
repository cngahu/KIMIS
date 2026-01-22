<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\FinanceReportController;
use App\Http\Controllers\Finance\StudentFinanceController;
use App\Http\Controllers\Finance\InvoiceReconciliationController;
use App\Http\Controllers\Finance\FinanceFeeStatementController;
use App\Http\Controllers\PublicPaymentController;
use App\Http\Controllers\Admin\FinanceDashboardController;

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



Route::prefix('finance')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/students', [StudentFinanceController::class, 'index'])
            ->name('finance.students.index');

        Route::get('/students/{student}/ledger', [StudentFinanceController::class, 'show'])
            ->name('finance.students.ledger');
//
//        Route::post('/students/{student}/debit', [StudentFinanceController::class, 'debit'])
//            ->name('finance.students.debit');
//
//        Route::post('/students/{student}/credit', [StudentFinanceController::class, 'credit'])
//            ->name('finance.students.credit');
        Route::post('/finance/ledger/debit', [StudentFinanceController::class, 'debit'])
            ->name('finance.ledger.debit');

        Route::post('/finance/ledger/credit', [StudentFinanceController::class, 'credit'])
            ->name('finance.ledger.credit');


        Route::get('/finance/ledger', [StudentFinanceController::class, 'showLedger'])
            ->name('finance.ledger.view');

    });


Route::prefix('finance')
    ->middleware([
        'auth',
        'role:accounts|cash_office|superadmin'
    ])
    ->group(function () {

        Route::get('/reconciliation', [InvoiceReconciliationController::class, 'index'])
            ->name('finance.reconciliation.index');

        Route::post('/reconciliation/run', [InvoiceReconciliationController::class, 'run'])
            ->name('finance.reconciliation.run');


        Route::get('/fee-statement', [FinanceFeeStatementController::class, 'preview'])
            ->name('finance.fee-statement.preview');

        Route::get('/fee-statement/download', [FinanceFeeStatementController::class, 'download'])
            ->name('finance.fee-statement.download');
    });



Route::get('/finance/ledgers/{type}/{id}',
    [\App\Http\Controllers\FinanceLedgerController::class, 'viewByOwner']
)->name('finance.ledger.view.owner');


// Public payment lookup
Route::get('/payments/lookup', [PublicPaymentController::class, 'lookupForm'])
    ->name('payments.lookup.form');

Route::post('/payments/lookup', [PublicPaymentController::class, 'lookup'])
    ->name('payments.lookup');

// Pay page after lookup
Route::get('/payments/application/{reference}', [PublicPaymentController::class, 'showApplication'])
    ->name('payments.application.show');

Route::get(
    '/admin/finance/dashboard',
    [FinanceDashboardController::class, 'index']
)->name('finance.dashboard')
    ->middleware(['auth', 'role:accounts|superadmin|cash_office']);

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORTS
|--------------------------------------------------------------------------
*/

// Root namespace controllers
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\FeeStatementController;

// Student namespace controllers
use App\Http\Controllers\Student\StudentActivationController;
use App\Http\Controllers\Student\StudentCycleRegistrationController;
use App\Http\Controllers\Student\StudentPaymentController;
use App\Http\Controllers\Student\StudentFeesController;
use App\Http\Controllers\Student\StudentAuthController;
use App\Http\Controllers\Student\StudentCourseController;

// Application namespace
use App\Http\Controllers\Application\PaymentController;


/*
|--------------------------------------------------------------------------
| DEVELOPMENT ROUTES (PROTECT THESE)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/simulate-payment', function () {
        return view('dev.simulate_payment_form');
    })->name('dev.simulate.payment.form');

    Route::post('/simulate-payment', [AdmissionController::class, 'simulateAdmissionPayment'])
        ->name('dev.simulate.payment');

});


/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        // Dashboard
        Route::get('/student_dashboard', [StudentDashboardController::class, 'index'])
            ->name('student_dashboard');

        // ✅ Password Change (inside group → route: student.change.password)
        Route::get('/change-password', [StudentAuthController::class, 'showChangePassword'])->name('change.password');
        Route::post('/change-password', [StudentAuthController::class, 'updatePassword'])->name('update.password');

        /*
        |--------------------------------------------------------------------------
        | Fees (Student namespace)
        |--------------------------------------------------------------------------
        */
        Route::prefix('fees')->name('fees.')->group(function () {
            Route::get('/', [StudentFeesController::class, 'index'])->name('index');
            Route::get('/download', [StudentFeesController::class, 'download'])->name('download');
            Route::get('/invoice/{invoice}', [StudentFeesController::class, 'showInvoice'])->name('invoice.show');
            Route::get('/invoice/{invoice}/pdf', [StudentFeesController::class, 'downloadInvoice'])->name('invoice.pdf');
            Route::get('/receipt/{invoice}', [StudentFeesController::class, 'downloadReceipt'])->name('receipt.pdf');
            Route::get('/statement', [StudentFeesController::class, 'statement'])->name('statement');
        });

        /*
        |--------------------------------------------------------------------------
        | Fee Statement (root namespace)
        |--------------------------------------------------------------------------
        */
        Route::get('/fee-statement', [FeeStatementController::class, 'index'])->name('fee.statement');
        Route::get('/fee-statement/pdf', [FeeStatementController::class, 'downloadPdf'])->name('fee.statement.pdf');

        /*
        |--------------------------------------------------------------------------
        | Payments (Student namespace)
        |--------------------------------------------------------------------------
        */
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/initiate', [StudentPaymentController::class, 'initiate'])->name('initiate');
            Route::get('/{invoice}/iframe', [StudentPaymentController::class, 'paymentIframe'])->name('iframe');
            Route::post('/create', [StudentPaymentController::class, 'create'])->name('create');
        });

        /*
        |--------------------------------------------------------------------------
        | Cycle Registration (Student namespace)
        |--------------------------------------------------------------------------
        */
        Route::post('/cycle/register', [StudentCycleRegistrationController::class, 'register'])->name('cycle.register');

        /*
        |--------------------------------------------------------------------------
        | Admission (root namespace)
        |--------------------------------------------------------------------------
        */
        Route::prefix('admission')->name('admission.')->group(function () {
            Route::get('/form', [AdmissionController::class, 'showAdmissionForm'])->name('form');
            Route::post('/form', [AdmissionController::class, 'submitAdmissionForm'])->name('form.submit');
            Route::get('/documents', [AdmissionController::class, 'showDocumentsPage'])->name('documents');
            Route::post('/documents', [AdmissionController::class, 'uploadDocuments'])->name('documents.upload');
            Route::get('/payment', [AdmissionController::class, 'paymentPage'])->name('payment');
            Route::post('/payment/create', [AdmissionController::class, 'createPayment'])->name('payment.create');
            Route::get('/payment/invoice/{invoice}', [AdmissionController::class, 'paymentIframe'])->name('payment.iframe');
            Route::get('/payment/sponsor', [AdmissionController::class, 'sponsorForm'])->name('payment.sponsor');
            Route::post('/payment/sponsor', [AdmissionController::class, 'sponsorSubmit'])->name('payment.sponsor.submit');
            Route::get('/payment/pay-later', [AdmissionController::class, 'payLaterForm'])->name('payment.later');
            Route::post('/payment/pay-later', [AdmissionController::class, 'payLaterSubmit'])->name('payment.later.submit');
            Route::post('/payment/callback', [AdmissionController::class, 'paymentCallback'])->name('payment.callback');
        });

        /*
        |--------------------------------------------------------------------------
        | Accept Offer (root namespace)
        |--------------------------------------------------------------------------
        */
        Route::post('/accept-offer', [AdmissionController::class, 'acceptOffer'])->name('accept.offer');

    });


/*
|--------------------------------------------------------------------------
| STUDENT ACTIVATION (NO role:student)
|--------------------------------------------------------------------------
*/

Route::prefix('student-activation')
    ->name('student.activation.')
    ->group(function () {
        Route::get('/', [StudentActivationController::class, 'start'])->name('start');
        Route::post('/verify', [StudentActivationController::class, 'verifyAdmission'])->name('verify');
        Route::post('/complete', [StudentActivationController::class, 'complete'])->name('complete');
        Route::get('/success', function () {
            return view('student.activation.success');
        })->name('success');
    });


/*
|--------------------------------------------------------------------------
| GLOBAL PAYMENT SUCCESS
|--------------------------------------------------------------------------
*/

Route::match(['GET', 'POST'], '/payments/success', [PaymentController::class, 'success'])
    ->name('payments.success');
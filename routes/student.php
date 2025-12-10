<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\AdmissionController;

// DEVELOPMENT PAYMENT SIMULATION ENDPOINT
// ----------- SIMPLE PAYMENT SIMULATOR (DEV ONLY) ----------
Route::get('/simulate-payment', function() {
    return view('dev.simulate_payment_form');
});

Route::post('/simulate-payment', [App\Http\Controllers\Student\AdmissionController::class, 'simulateAdmissionPayment'])
    ->name('simulate.payment');


Route::group(['middleware' => ['role:student','auth','history','verified']], function () {
    //


    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->name('student.dashboard');

    Route::post('/student/accept-offer', [AdmissionController::class, 'acceptOffer'])
        ->name('student.accept.offer');

    /*
   |--------------------------------------------------------------------------
   | Admission Form
   |--------------------------------------------------------------------------
   */
    Route::get('/admission/form', [AdmissionController::class, 'showAdmissionForm'])
        ->name('student.admission.form');

    Route::post('/admission/form', [AdmissionController::class, 'submitAdmissionForm'])
        ->name('student.admission.form.submit');


    /*
    |--------------------------------------------------------------------------
    | Documents Upload
    |--------------------------------------------------------------------------
    */
    Route::get('/admission/documents', [AdmissionController::class, 'showDocumentsPage'])
        ->name('student.admission.documents');

    Route::post('/admission/documents', [AdmissionController::class, 'uploadDocuments'])
        ->name('student.admission.documents.upload');


    /*
    |--------------------------------------------------------------------------
    | Fee Payment Page
    |--------------------------------------------------------------------------
    */
// payment index + create invoice
    Route::get('/admission/payment', [App\Http\Controllers\Student\AdmissionController::class, 'paymentPage'])
        ->name('student.admission.payment');

    Route::post('/admission/payment/create', [App\Http\Controllers\Student\AdmissionController::class, 'createPayment'])
        ->name('student.admission.payment.create');

    Route::get('/admission/payment/invoice/{invoice}', [App\Http\Controllers\Student\AdmissionController::class, 'paymentIframe'])
        ->name('student.admission.payment.iframe');

// sponsor & pay later
    Route::get('/admission/payment/sponsor', [App\Http\Controllers\Student\AdmissionController::class, 'sponsorForm'])
        ->name('student.admission.payment.sponsor');

    Route::post('/admission/payment/sponsor', [App\Http\Controllers\Student\AdmissionController::class, 'sponsorSubmit'])
        ->name('student.admission.payment.sponsor.submit');

    Route::get('/admission/payment/pay-later', [App\Http\Controllers\Student\AdmissionController::class, 'payLaterForm'])
        ->name('student.admission.payment.later');

    Route::post('/admission/payment/pay-later', [App\Http\Controllers\Student\AdmissionController::class, 'payLaterSubmit'])
        ->name('student.admission.payment.later.submit');

// callback / simulate (protect in production)
    Route::post('/admission/payment/callback', [App\Http\Controllers\Student\AdmissionController::class, 'paymentCallback'])
        ->name('student.admission.payment.callback');


});

//
//
//Route::post('/payments/success', [\App\Http\Controllers\Application\PaymentController::class, 'success'])
//    ->name('payments.success');

Route::match(['GET', 'POST'], '/payments/success', [
    \App\Http\Controllers\Application\PaymentController::class,
    'success'
])->name('payments.success');


Route::post('/payments/notify', [\App\Http\Controllers\Application\PaymentController::class, 'notify'])
    ->name('payments.notify');

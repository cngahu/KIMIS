<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\AdmissionController;


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
    Route::get('/admission/payment', [AdmissionController::class, 'paymentPage'])
        ->name('student.admission.payment');

    Route::post('/admission/payment/simulate', [AdmissionController::class, 'simulatePayment'])
        ->middleware('localOnly') // optional
        ->name('student.admission.payment.simulate');


});

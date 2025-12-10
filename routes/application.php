<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Application\PaymentController;
use App\Http\Controllers\public\CertificateLookupController;

//Route::get('/apply/{course}', [ApplicationController::class, 'showForm'])->name('applications.form');
//Route::post('/apply/store', [ApplicationController::class, 'store'])->name('applications.store');
//
//Route::get('/apply/{id}/payment', [ApplicationController::class, 'payment'])->name('applications.payment');
//Route::get('/apply/{id}/pay-now', [PaymentController::class, 'pay'])->name('applications.pay.now');
//
//// callback route for Mpesa/gateway
//Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
//

Route::get('/counties/{county}/subcounties', function ($county) {
    return \App\Models\Subcounty::where('county_id', $county)
        ->orderBy('name')
        ->select('id','name')
        ->get();
});

Route::get('/apply/{course}', [ApplicationController::class, 'showForm'])->name('applications.form');
Route::post('/short-trainings/{training}', [ApplicationController::class, 'storeShort'])
    ->name('short_trainings.store');

Route::post('/apply/store', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/apply/{application}/payment', [ApplicationController::class, 'payment'])->name('applications.payment');

Route::get('/apply/{application}/pay-now', [PaymentController::class, 'pay'])->name('applications.pay.now');
Route::get('/ecitizen/payment/-{application}-pay-now', [PaymentController::class, 'payEcitizen'])->name('applications.pay.now.ecitizen');


Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/apply/{course}/requirements', [ApplicationController::class, 'requirements']
)->name('applications.requirementss');


Route::get('/payment/simulate/{invoice}', [PaymentController::class, 'simulate'])
    ->name('payment.simulate');

Route::get('/certificates/verify', [CertificateLookupController::class, 'verify'])
    ->name('certificates.verify');

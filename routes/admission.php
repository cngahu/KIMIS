<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AdmissionController;



Route::middleware(['auth', 'admission'])->group(function () {
    Route::get('/admission', [AdmissionController::class, 'dashboard'])->name('admission.dashboard');
});

Route::post('/admission/accept-offer', [AdmissionController::class, 'acceptOffer'])
    ->name('admission.accept');

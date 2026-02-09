<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\public\HostelBookingController;
use App\Http\Controllers\public\HostelBookingPaymentController;
use App\Http\Controllers\public\HostelInvoiceController;



Route::prefix('hostel')->group(function () {

    // Show booking form
    Route::get('/book', [HostelBookingController::class, 'create'])
        ->name('hostel.book');

    // Submit booking
    Route::post('/book', [HostelBookingController::class, 'store'])
        ->name('hostel.book.store');

    // 👉 PAYMENT PAGE
    Route::get('/payment/{reference}', [HostelBookingController::class, 'showPaymentPage'])
        ->name('hostel.booking.payment');

    Route::post('/hostel/payment/{reference}', [HostelBookingPaymentController::class, 'createInvoice'])
        ->name('hostel.booking.payment.create');

    Route::get('/hostel/pay/{invoice}',
        [HostelBookingPaymentController::class, 'show']
    )->name('hostel.payment');

});
Route::prefix('hostel')->group(function () {

    Route::get('/invoice/{invoice}/pdf',
        [HostelInvoiceController::class, 'pdf']
    )->name('hostel.invoice.pdf');

    Route::get('/invoice/{invoice}/pay',
        [HostelInvoiceController::class, 'payByInvoice']
    )->name('hostel.invoice.pay');

});

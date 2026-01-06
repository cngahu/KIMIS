<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Errors\ErrorLogController;


Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/admin/logs/errors', [ErrorLogController::class, 'index'])
        ->name('admin.logs.errors');

    Route::post('/logs/errors/clear', [ErrorLogController::class, 'clear'])
        ->name('admin.logs.errors.clear');
});

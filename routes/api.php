<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payments\PesaFlowConfirmationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/counties/{county}/subcounties', function ($county) {
    return \App\Models\Subcounty::where('county_id', $county)
        ->orderBy('name')
        ->select('id','name')
        ->get();
});

Route::get('/apply/{course}/requirements',
    [\App\Http\Controllers\Application\ApplicationController::class, 'requirements']
)->name('applications.requirements');

Route::group(['prefix' => 'pesaflow'], function () {
    Route::post('/confirm', [PesaFlowConfirmationController::class,'index'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});


Route::group(['prefix' => 'pesaflow'], function () {
    Route::post(
        '/confirm',
        [PesaFlowConfirmationController::class, 'index']
    )
        ->name('payments.notify')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});

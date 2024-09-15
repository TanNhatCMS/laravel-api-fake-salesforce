<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesForceController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('services')->group(function () {
    /**
     * post servicesOauth2TokenPOST
     * Summary: Lấy JWT access_token và instance_url test.salesforce.com
     * Notes:
     * Output-Formats: [application/json]
     */
    Route::post('/oauth2/token', [SalesForceController::class, 'getToken']);
    Route::post('/apexrest/hkt/v1.0/bookings', [SalesForceController::class, 'bookings']);
});


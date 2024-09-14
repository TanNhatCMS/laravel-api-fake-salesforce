<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesForceController;

Route::get('/', function () {
    return view('welcome');
});
/**
 * post servicesOauth2TokenPOST
 * Summary: Lấy JWT access_token và instance_url test.salesforce.com
 * Notes:
 * Output-Formats: [application/json]
 */
Route::post('/services/oauth2/token', [SalesForceController::class, 'getToken']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\PricingController;

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

Route::get('/projects', [App\Http\Controllers\Api\ProjectsController::class, 'index']);

// Pricing API routes
Route::get('/pricing', [PricingController::class, 'getPricingData']);

// Currency API routes
Route::prefix('currency')->name('currency.')->group(function () {
    Route::get('/', [CurrencyController::class, 'index']);
    Route::post('/switch', [CurrencyController::class, 'switch']);
    Route::get('/service/{service}/price', [CurrencyController::class, 'servicePrice']);
    Route::post('/convert', [CurrencyController::class, 'convert']);
    Route::get('/{currency}/rates', [CurrencyController::class, 'exchangeRates']);
});
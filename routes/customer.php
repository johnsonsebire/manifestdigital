<?php

use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\Customer\OrderChangeRequestController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProjectController;
use App\Http\Controllers\Customer\SubscriptionController;
use App\Http\Controllers\SubscriptionRenewalController;
use Illuminate\Support\Facades\Route;

// Customer routes - protected by auth
Route::middleware(['web', 'auth'])
    ->prefix('my')
    ->name('customer.')
    ->group(function () {
        
        // Orders
        Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order}', 'show')->name('show');
        });

        // Order Change Requests
        Route::get('orders/{order}/change-request', [OrderChangeRequestController::class, 'create'])->name('orders.change-request.create');
        Route::post('orders/{order}/change-request', [OrderChangeRequestController::class, 'store'])->name('orders.change-request.store');
        Route::get('orders/{order}/change-request/{changeRequest}', [OrderChangeRequestController::class, 'show'])->name('orders.change-request.show');

        // Invoices
        Route::controller(InvoiceController::class)->prefix('invoices')->name('invoices.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{invoice}', 'show')->name('show');
            Route::get('/{invoice}/download', 'download')->name('download');
        });

        // Projects
        Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{project}', 'show')->name('show');
        });

        // Subscriptions
        Route::controller(SubscriptionController::class)->prefix('subscriptions')->name('subscriptions.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{subscription}', 'show')->name('show');
            Route::get('/{subscription}/cancel', 'requestCancellation')->name('request-cancellation');
            Route::post('/{subscription}/cancel', 'submitCancellationRequest')->name('submit-cancellation');
            Route::post('/{subscription}/toggle-auto-renewal', 'toggleAutoRenewal')->name('toggle-auto-renewal');
        });
    });

// Subscription Renewal routes - separate from customer prefix for cleaner URLs
Route::middleware(['web', 'auth'])
    ->name('renewal.')
    ->group(function () {
        Route::controller(SubscriptionRenewalController::class)->group(function () {
            Route::get('/subscriptions/{subscription}/renew', 'index')->name('index');
            Route::post('/subscriptions/{subscription}/renew', 'store')->name('store');
            Route::get('/subscriptions/renew/payment/{uuid}', 'payment')->name('payment');
            Route::get('/subscriptions/renew/success/{uuid}', 'success')->name('success');
        });
    });

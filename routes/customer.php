<?php

use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\Customer\OrderChangeRequestController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProjectController;
use Illuminate\Support\Facades\Route;

// Customer routes - protected by auth and verified
Route::middleware(['web', 'auth', 'verified'])
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
    });

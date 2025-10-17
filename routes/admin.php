<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ServiceManagementController;
use Illuminate\Support\Facades\Route;

// Admin routes - protected by auth and admin access
Route::middleware(['web', 'auth', 'verified', 'can:access-admin-panel'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Order Management
        Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order}', 'show')->name('show');
            
            // Order actions
            Route::post('/{order}/approve', 'approve')->name('approve');
            Route::post('/{order}/reject', 'reject')->name('reject');
            Route::post('/{order}/complete', 'complete')->name('complete');
            Route::post('/{order}/mark-paid', 'markAsPaid')->name('mark-paid');
            Route::patch('/{order}/status', 'updateStatus')->name('update-status');
        });

        // Category Management
        Route::resource('categories', CategoryController::class);

        // Service Management
        Route::resource('services', ServiceManagementController::class);
    });

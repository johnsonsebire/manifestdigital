<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\OrderChangeRequestController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\ServiceManagementController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TaskController;
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

        // Project Management
        Route::resource('projects', ProjectController::class);
        Route::post('projects/{project}/team', [ProjectController::class, 'addTeamMember'])->name('projects.team.add');
        Route::delete('projects/{project}/team/{teamMember}', [ProjectController::class, 'removeTeamMember'])->name('projects.team.remove');
        Route::patch('projects/{project}/progress', [ProjectController::class, 'updateProgress'])->name('projects.progress.update');

        // Task Management
        Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
        Route::put('projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');
        Route::delete('projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');
        Route::patch('projects/{project}/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('projects.tasks.toggle');

        // File Management
        Route::post('projects/{project}/files', [FileController::class, 'store'])->name('projects.files.store');
        Route::delete('projects/{project}/files/{file}', [FileController::class, 'destroy'])->name('projects.files.destroy');
        Route::patch('projects/{project}/files/{file}/description', [FileController::class, 'updateDescription'])->name('projects.files.update-description');

        // Message Management
        Route::post('projects/{project}/messages', [MessageController::class, 'store'])->name('projects.messages.store');
        Route::put('projects/{project}/messages/{message}', [MessageController::class, 'update'])->name('projects.messages.update');
        Route::delete('projects/{project}/messages/{message}', [MessageController::class, 'destroy'])->name('projects.messages.destroy');
        Route::post('projects/{project}/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('projects.messages.mark-read');
        Route::post('projects/{project}/messages/read-all', [MessageController::class, 'markAllAsRead'])->name('projects.messages.mark-all-read');

        // Order Change Requests
        Route::get('change-requests', [OrderChangeRequestController::class, 'index'])->name('change-requests.index');
        Route::get('change-requests/{changeRequest}', [OrderChangeRequestController::class, 'show'])->name('change-requests.show');
        Route::post('change-requests/{changeRequest}/approve', [OrderChangeRequestController::class, 'approve'])->name('change-requests.approve');
        Route::post('change-requests/{changeRequest}/reject', [OrderChangeRequestController::class, 'reject'])->name('change-requests.reject');
        Route::post('change-requests/{changeRequest}/apply', [OrderChangeRequestController::class, 'apply'])->name('change-requests.apply');

        // Invoice Management
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('orders/{order}/invoices/create', [InvoiceController::class, 'create'])->name('orders.invoices.create');
        Route::post('orders/{order}/invoices', [InvoiceController::class, 'store'])->name('orders.invoices.store');
        Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
        Route::post('invoices/{invoice}/payment', [InvoiceController::class, 'recordPayment'])->name('invoices.payment');
        Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
        Route::post('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel'])->name('invoices.cancel');
        Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'exportPdf'])->name('invoices.pdf');

        // Category Management
        Route::resource('categories', CategoryController::class);

        // Customer Management
        Route::resource('customers', CustomerController::class);

        // Service Management
        Route::resource('services', ServiceManagementController::class);

        // Currency Management
        Route::resource('currencies', CurrencyController::class);
        Route::post('currencies/update-rates', [CurrencyController::class, 'updateRates'])->name('currencies.update-rates');

        // Reports & Analytics
        Route::controller(ReportsController::class)->prefix('reports')->name('reports.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/data', 'getData')->name('data');
            Route::get('/export/revenue', 'exportRevenue')->name('export.revenue');
            Route::get('/export/orders', 'exportOrders')->name('export.orders');
        });

        // Settings
        Route::controller(SettingsController::class)->prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/company', 'updateCompany')->name('company.update');
            Route::post('/invoice', 'updateInvoice')->name('invoice.update');
        });
    });

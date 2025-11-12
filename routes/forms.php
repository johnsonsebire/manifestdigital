<?php

use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\FormSubmissionController as AdminFormSubmissionController;
use App\Http\Controllers\FormSubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Forms Module Routes
|--------------------------------------------------------------------------
*/

// Public form routes
Route::middleware(['web'])->group(function () {
    Route::get('/forms/{slug}', [FormSubmissionController::class, 'showForm'])->name('forms.show');
    Route::post('/forms/{slug}/submit', [FormSubmissionController::class, 'submitForm'])->name('forms.submit');
});

// Admin form management routes
Route::middleware(['web', 'auth', 'can:access-admin-panel'])->prefix('admin')->name('admin.')->group(function () {
    // Form management
    Route::resource('forms', FormController::class);
    Route::post('forms/{id}/fields', [FormController::class, 'addField'])->name('forms.fields.store');
    Route::post('forms/{id}/update-fields', [FormController::class, 'updateFields'])->name('forms.update-fields');
    Route::put('forms/{id}/fields/{fieldId}', [FormController::class, 'updateField'])->name('forms.fields.update');
    Route::delete('forms/{id}/fields/{fieldId}', [FormController::class, 'deleteField'])->name('forms.fields.destroy');
    Route::put('forms/{id}/fields/reorder', [FormController::class, 'reorderFields'])->name('forms.fields.reorder');
    
    // Form submissions
    Route::resource('form-submissions', AdminFormSubmissionController::class)->except(['create', 'store', 'edit', 'update']);
    Route::get('form-submissions/{id}/export/pdf', [AdminFormSubmissionController::class, 'exportSubmissionToPdf'])->name('form-submissions.export-pdf');
    Route::get('form-submissions/{id}/export/excel', [AdminFormSubmissionController::class, 'exportSubmissionToExcel'])->name('form-submissions.export-excel');
    Route::get('forms/{formId}/export/excel', [AdminFormSubmissionController::class, 'exportToExcel'])->name('form-submissions.export.excel');
    Route::get('forms/{formId}/export/pdf', [AdminFormSubmissionController::class, 'exportToPdf'])->name('form-submissions.export.pdf');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ChatController;


Route::prefix('ai')->name('ai.')->group(function () {
    // Routes for Frontend Website Pages
    Route::get('/ai-sensei', [PagesController::class, 'index'])->name('ai-sensei');
    Route::get('/projects', [PagesController::class, 'projects'])->name('projects');
    Route::get('/book-a-call', [PagesController::class, 'bookACall'])->name('book-a-call');
    Route::get('/request-quote', [PagesController::class, 'requestQuote'])->name('request-quote');
});
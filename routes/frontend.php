<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ChatController;



// Routes for Frontend Website Pages

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/ai-sensei', [PagesController::class, 'index'])->name('ai-sensei');
Route::get('/projects', [PagesController::class, 'projects'])->name('projects');
Route::get('/projects/{slug}', [PagesController::class, 'projectDetail'])->name('project.detail');
Route::get('/book-a-call', [PagesController::class, 'bookACall'])->name('book-a-call');
Route::get('/request-quote', [PagesController::class, 'requestQuote'])->name('request-quote');
Route::get('/about', [PagesController::class, 'about'])->name('about');

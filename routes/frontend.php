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
Route::get('/about-us', [PagesController::class, 'about'])->name('about');
Route::get('/opportunities', [PagesController::class, 'opportunities'])->name('opportunities');
Route::get('/application-success', [PagesController::class, 'applicationSuccess'])->name('application.success');
Route::get('/solutions', [PagesController::class, 'solutions'])->name('solutions');
Route::get('/policies', [PagesController::class, 'policies'])->name('policies');
Route::get('/blog', [PagesController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PagesController::class, 'blogDetail'])->name('blog.show');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

// Team Profile Form Routes
Route::get('/team-profile/create', [App\Http\Controllers\TeamProfileController::class, 'create'])->name('team-profile.create');
Route::post('/team-profile/store', [App\Http\Controllers\TeamProfileController::class, 'store'])->name('team-profile.store');
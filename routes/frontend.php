<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FormSubmissionController;



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

// Service Catalog Routes (Public Product Browsing)
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');
Route::post('/services/{slug}/price', [App\Http\Controllers\ServiceController::class, 'getPrice'])->name('services.price');

// Category Routes (Product Categories)
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

// Team Profile Form Routes
Route::get('/team-profile/create', [App\Http\Controllers\TeamProfileController::class, 'create'])->name('team-profile.create');
Route::post('/team-profile/store', [App\Http\Controllers\TeamProfileController::class, 'store'])->name('team-profile.store');

// Form Builder Routes - Public form submission
Route::post('/forms/{slug}/submit', [FormSubmissionController::class, 'submitForm'])->name('forms.submit');
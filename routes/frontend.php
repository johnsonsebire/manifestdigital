<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FormSubmissionController;



// Routes for Frontend Website Pages

Route::middleware('web')->group(function () {

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

// Shopping Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{cartKey}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartKey}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/summary', [App\Http\Controllers\CartController::class, 'summary'])->name('cart.summary');

// Checkout Routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{uuid}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// Payment Routes
Route::post('/payment/initiate/{uuid}', [App\Http\Controllers\PaymentController::class, 'initiate'])->name('payment.initiate');
Route::get('/payment/callback/{gateway}', [App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/webhook/{gateway}', [App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/payment/bank-transfer/{uuid}', [App\Http\Controllers\PaymentController::class, 'bankTransfer'])->name('payment.bank-transfer');

// Team Profile Form Routes
Route::get('/team-profile/create', [App\Http\Controllers\TeamProfileController::class, 'create'])->name('team-profile.create');
Route::post('/team-profile/store', [App\Http\Controllers\TeamProfileController::class, 'store'])->name('team-profile.store');

// Form Builder Routes - Public form submission
Route::post('/forms/{slug}/submit', [FormSubmissionController::class, 'submitForm'])->name('forms.submit');

});
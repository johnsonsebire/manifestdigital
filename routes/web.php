<?php

use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// File downloads (authenticated users only - authorization checked in controller)
Route::get('files/{file}/download', [FileController::class, 'download'])
    ->middleware(['auth'])
    ->name('files.download');

// Notifications
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Debug routes for session/CSRF issues (REMOVE IN PRODUCTION AFTER FIXING)
Route::get('/debug-session', function() {
    return response()->json([
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'session_http_only' => config('session.http_only'),
        'session_same_site' => config('session.same_site'),
        'app_url' => config('app.url'),
        'app_env' => config('app.env'),
        'has_csrf_meta' => !empty(request()->header('X-CSRF-TOKEN')),
        'user_agent' => request()->userAgent(),
        'ip' => request()->ip(),
        'session_data_count' => count(session()->all()),
    ]);
})->middleware('web');

Route::get('/debug-csrf', function() {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'request_host' => request()->getHost(),
        'request_secure' => request()->isSecure(),
        'cookies' => request()->cookies->all(),
        'headers' => [
            'x-csrf-token' => request()->header('X-CSRF-TOKEN'),
            'x-requested-with' => request()->header('X-Requested-With'),
        ],
    ]);
})->middleware('web');

Route::get('/debug-login-page', function() {
    return view('livewire.auth.login');
})->middleware('guest');

Route::post('/test-auth', function(\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info('Manual auth test', [
        'email' => $request->input('email'),
        'has_password' => !empty($request->input('password')),
        'csrf_token_sent' => $request->input('_token'),
        'csrf_token_expected' => csrf_token(),
        'session_id' => session()->getId(),
        'ip' => $request->ip(),
    ]);
    
    try {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'user' => \Illuminate\Support\Facades\Auth::user()->only(['id', 'name', 'email']),
                'redirect_url' => route('dashboard'),
            ]);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Auth test error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware('web');

require __DIR__.'/auth.php';
require __DIR__.'/auth-backup.php';
require __DIR__.'/ai.php';
require __DIR__.'/frontend.php';
require __DIR__.'/admin.php';
require __DIR__.'/customer.php';

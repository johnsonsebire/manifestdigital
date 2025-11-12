<?php

// Temporary debugging routes - ADD TO routes/web.php for production debugging
// REMOVE THESE AFTER FIXING THE ISSUE

// Test CSRF token generation and validation
Route::get('/debug-csrf', function() {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'request_host' => request()->getHost(),
        'request_secure' => request()->isSecure(),
        'user_agent' => request()->userAgent(),
        'cookies' => request()->cookies->all(),
    ]);
})->middleware('web');

// Test session functionality
Route::get('/debug-session', function() {
    session(['test_key' => 'test_value_' . time()]);
    return response()->json([
        'session_data' => session()->all(),
        'test_value' => session('test_key'),
        'flash_data' => session()->getFlashBag()->all(),
    ]);
})->middleware('web');

// Test authentication attempt with detailed logging
Route::post('/debug-auth', function(\Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    
    // Log the attempt
    \Illuminate\Support\Facades\Log::info('Debug auth attempt', [
        'email' => $credentials['email'],
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'session_id' => session()->getId(),
        'csrf_token' => $request->input('_token'),
        'expected_csrf' => csrf_token(),
    ]);
    
    try {
        // Check if user exists
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        // Check password
        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }
        
        // Attempt login
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'user' => \Illuminate\Support\Facades\Auth::user(),
                'session_id' => session()->getId(),
            ]);
        } else {
            return response()->json(['error' => 'Auth::attempt failed'], 401);
        }
        
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Debug auth error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return response()->json([
            'error' => 'Exception occurred',
            'message' => $e->getMessage(),
        ], 500);
    }
})->middleware('web');

// Test form to use with debug auth
Route::get('/debug-login-form', function() {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Debug Login</title>
        <meta name="csrf-token" content="' . csrf_token() . '">
    </head>
    <body>
        <h1>Debug Login Form</h1>
        <form method="POST" action="/debug-auth">
            ' . csrf_field() . '
            <div>
                <label>Email: <input type="email" name="email" required></label>
            </div>
            <div>
                <label>Password: <input type="password" name="password" required></label>
            </div>
            <button type="submit">Test Login</button>
        </form>
        
        <h2>Debug Info</h2>
        <p><a href="/debug-csrf">Check CSRF Token</a></p>
        <p><a href="/debug-session">Check Session</a></p>
        
        <script>
            // Log any JavaScript errors
            window.addEventListener("error", function(e) {
                console.error("JavaScript Error:", e.error);
            });
        </script>
    </body>
    </html>
    ';
})->middleware('web');
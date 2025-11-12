# Production Login Fix - Comprehensive Solution

## Issue: Persistent "Page Expired" Errors

Even after fixing the environment configuration, login still fails. This requires a multi-layered approach.

## Step-by-Step Solution

### 1. Verify Environment Changes Are Applied

```bash
# On production server, check current config:
php artisan config:show session
php artisan config:show app

# Clear all caches:
php artisan config:clear
php artisan cache:clear  
php artisan view:clear
php artisan route:clear

# Restart web server (if using PHP-FPM):
sudo systemctl reload php8.2-fpm
# OR for Apache:
sudo systemctl reload apache2
```

### 2. Enhanced CSRF Token Handling

The issue might be that CSRF tokens aren't refreshing properly. Let's add explicit CSRF handling.

**Update the login form with explicit CSRF token:**

Add this to the login form in `resources/views/livewire/auth/login.blade.php`:

```blade
<form method="POST" wire:submit="login" class="flex flex-col gap-6">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Add CSRF refresh mechanism -->
    <script>
        // Refresh CSRF token before form submission
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', () => {
                const token = document.querySelector('meta[name="csrf-token"]');
                if (token) {
                    token.content = document.querySelector('input[name="_token"]')?.value || token.content;
                }
            });
        });
    </script>
    
    <!-- Rest of form... -->
```

### 3. Alternative Login Method

Create a traditional non-Livewire login as backup:

**Create: `routes/auth-backup.php`**
```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login-backup', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->middleware('web');
```

### 4. Session Debug Route

Add temporary debugging route:

**Add to `routes/web.php`:**
```php
Route::get('/debug-session', function() {
    return response()->json([
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'app_url' => config('app.url'),
        'cookies' => request()->cookies->all(),
    ]);
})->middleware('web');
```

### 5. Database Session Table Verification

Check if sessions are being stored properly:

```sql
-- Check sessions table structure
DESCRIBE sessions;

-- Check if sessions are being created
SELECT COUNT(*) as session_count FROM sessions;
SELECT * FROM sessions ORDER BY last_activity DESC LIMIT 5;

-- Clean old sessions
DELETE FROM sessions WHERE last_activity < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 HOUR));
```

### 6. Enhanced Environment Configuration

**Additional settings to add to .env:**
```bash
# Force session regeneration
SESSION_PARTITIONED_COOKIE=false

# Ensure proper app key
# Run: php artisan key:generate --force

# Add explicit trusted proxies if behind load balancer
TRUSTED_PROXIES="*"
TRUSTED_HOSTS="manifestghana.com,www.manifestghana.com"
```

### 7. Middleware Check

Ensure CSRF middleware isn't blocking Livewire:

**In `bootstrap/app.php`, verify:**
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        'payment/webhook/*',
        // Don't exclude livewire routes
    ]);
})
```

## Testing Steps

1. **Apply environment changes and clear caches**
2. **Test with debug route**: Visit `/debug-session` to verify config
3. **Test login with browser dev tools open** (check Network tab for errors)
4. **Check server logs** for any PHP errors during login attempts
5. **Try different browsers/incognito mode** to rule out cache issues

## Emergency Fallback

If Livewire login continues to fail, implement traditional login form:

**Create: `resources/views/auth/login-backup.blade.php`**
```blade
<x-layouts.auth.simple title="Login (Backup)">
    <form method="POST" action="/login-backup">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <input type="checkbox" name="remember">
            <label>Remember Me</label>
        </div>
        <button type="submit">Login</button>
    </form>
</x-layouts.auth.simple>
```

This comprehensive approach should resolve the login issues by addressing CSRF, session storage, and configuration problems.
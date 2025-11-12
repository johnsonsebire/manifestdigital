# Authentication Debugging Guide

## 🔧 Debug Tools Added

### 1. Enhanced Logging in Authentication Components

**Login Component** (`resources/views/livewire/auth/login.blade.php`):
- Logs every step of the login process
- Tracks validation, rate limiting, credential checking, and authentication
- Logs errors with full stack traces

**Register Component** (`resources/views/livewire/auth/register.blade.php`):  
- Logs every step of the registration process
- Tracks validation, user creation, authentication, and redirects
- Logs errors with full stack traces

### 2. Livewire Request Monitoring

**Middleware** (`app/Http/Middleware/LogLivewireRequests.php`):
- Logs all Livewire requests with headers and data
- Tracks CSRF tokens and authentication state
- Monitors before/after authentication status

### 3. Real-time Log Monitoring

**Command** (`php artisan auth:monitor`):
- Shows recent authentication activity
- Can follow logs in real-time with `--follow` flag
- Filters and highlights auth-related log entries

## 🚀 How to Debug Production Login Issues

### Step 1: Enable Real-time Monitoring
Run this command on your production server:
```bash
# Monitor authentication logs in real-time
php artisan auth:monitor --follow
```

### Step 2: Attempt Login/Registration
While the monitor is running, try to:
1. Login with valid credentials
2. Login with invalid credentials  
3. Register a new account

### Step 3: Analyze Log Output
The monitor will show color-coded log entries:
- 🔴 **RED**: Critical errors
- 🟡 **YELLOW**: Warnings (rate limiting, validation issues)
- 🔑 **BLUE**: Login process steps
- 📝 **GREEN**: Registration process steps
- ⚡ **CYAN**: Livewire request details

### Step 4: Look for Common Issues

#### **CSRF Token Problems**:
```
LIVEWIRE_REQUEST_START: x-csrf-token: null
```
**Solution**: CSRF meta tag missing or not being read by JavaScript

#### **Validation Failures**:
```
LOGIN_VALIDATION_ERROR: {"email": ["The email field is required"]}
```
**Solution**: Form data not being submitted properly

#### **Database Issues**:
```
CREDENTIALS_USER_NOT_FOUND: email: user@example.com
```
**Solution**: User doesn't exist or database connection issues

#### **Authentication Failures**:
```
CREDENTIALS_PASSWORD_INVALID: user_id: 1
```
**Solution**: Wrong password or password hash mismatch

#### **Session Issues**:
```
LOGIN_SESSION_REGENERATE_START
[No LOGIN_SESSION_REGENERATE_SUCCESS]
```
**Solution**: Session storage problems (permissions, database)

#### **Redirect Issues**:
```
LOGIN_REDIRECT_START
[No redirect occurring]
```
**Solution**: JavaScript/Livewire navigation issues

## 📊 Alternative Debugging Methods

### Check Recent Auth Activity (No Real-time)
```bash
php artisan auth:monitor
```

### Manual Log Inspection
```bash
# View recent logs
tail -100 storage/logs/laravel.log | grep -E "(LOGIN_|REGISTER_|ERROR)"

# Follow all logs
tail -f storage/logs/laravel.log
```

### Check Specific User Authentication
```bash
php artisan diagnose:login-advanced --test-user=email@domain.com
```

### Test Debug Routes
Visit these URLs to check system status:
- `https://manifestghana.com/debug-session`
- `https://manifestghana.com/debug-csrf`

## 🎯 Common Production Issues & Solutions

### 1. No Log Entries Appear
**Problem**: Livewire component methods aren't being called
**Solution**: 
- Check browser Network tab for failed requests
- Verify Vite assets are built: `npm run build`
- Check for JavaScript errors in browser console

### 2. LIVEWIRE_REQUEST_START but No Component Logs
**Problem**: Request reaches server but component method fails before logging
**Solution**:
- Check for middleware blocking requests
- Verify CSRF token validation
- Check for early validation failures

### 3. Authentication Succeeds but No Redirect
**Problem**: Login works but user stays on login page
**Solution**:
- Check for JavaScript errors preventing navigation
- Verify dashboard route exists and is accessible
- Check for middleware blocking dashboard access

### 4. Rate Limiting Issues
**Problem**: Too many attempts blocking login
**Solution**:
```bash
php artisan cache:clear
# Or manually clear rate limiter
php artisan tinker
>>> RateLimiter::clear('email@domain.com|IP_ADDRESS')
```

## 🔥 Emergency Debugging

If you need immediate debugging, add this temporary route:
```php
// Add to routes/web.php temporarily
Route::post('/debug-direct-auth', function(\Illuminate\Http\Request $request) {
    \Log::info('DIRECT_AUTH_TEST', $request->all());
    
    if (\Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['success' => true, 'user' => \Auth::user()]);
    }
    
    return response()->json(['error' => 'Auth failed'], 401);
})->middleware('web');
```

Then test with:
```bash
curl -X POST https://manifestghana.com/debug-direct-auth \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'
```

## 📝 Log File Locations

- **Laravel Logs**: `storage/logs/laravel.log`
- **Web Server Logs**: 
  - Nginx: `/var/log/nginx/error.log`
  - Apache: `/var/log/apache2/error.log`
- **PHP-FPM Logs**: `/var/log/php8.2-fpm.log`

## 🧹 Cleanup After Debugging

Once you've identified and fixed the issue:

1. **Remove debug routes** from `routes/web.php`
2. **Remove logging middleware** from `bootstrap/app.php`  
3. **Simplify component logging** (keep only error logging)
4. **Clear caches**: `php artisan optimize:clear`

The extensive logging will help pinpoint exactly where the authentication process is failing in production.
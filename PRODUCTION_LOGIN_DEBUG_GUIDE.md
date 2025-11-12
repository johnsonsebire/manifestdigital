# Production Login Failure Troubleshooting

Your configuration shows everything appears correct:
- ✅ APP_ENV: production
- ✅ SESSION_DOMAIN: .manifestghana.com  
- ✅ SESSION_SECURE: true
- ✅ Database connection works
- ✅ Sessions table exists

Since basic configuration is correct but login still fails, here are the advanced troubleshooting steps:

## Immediate Debugging Steps

### 1. Add Debug Routes (Temporarily)

Add these routes to your `routes/web.php` file for debugging:

```php
// TEMPORARY DEBUG ROUTES - REMOVE AFTER FIXING
Route::get('/debug-csrf', function() {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'request_host' => request()->getHost(),
        'request_secure' => request()->isSecure(),
        'cookies' => request()->cookies->all(),
    ]);
})->middleware('web');

Route::get('/debug-session', function() {
    session(['test_key' => 'test_value_' . time()]);
    return response()->json([
        'session_data' => session()->all(),
        'test_value' => session('test_key'),
    ]);
})->middleware('web');
```

### 2. Test These URLs
- `https://manifestghana.com/debug-csrf` - Check CSRF token generation
- `https://manifestghana.com/debug-session` - Test session functionality

### 3. Check Browser Developer Tools
1. Open Network tab
2. Try to login
3. Look for:
   - Failed requests (red status codes)
   - Missing or wrong CSRF tokens
   - Cookie issues
   - JavaScript errors in Console tab

## Most Likely Production Issues

### Issue 1: Livewire Assets Not Published
**Symptoms**: Form submits but nothing happens, no errors visible

**Check**: 
```bash
ls -la public/vendor/livewire/
```

**Fix**:
```bash
php artisan livewire:publish --assets --force
php artisan optimize:clear
```

### Issue 2: Trusted Proxies Configuration
**Symptoms**: Sessions don't persist, CSRF mismatches

If behind a load balancer/CDN, add to `config/trustedproxy.php`:
```php
'proxies' => '*', // or specific proxy IPs
'headers' => Request::HEADER_X_FORWARDED_ALL,
```

### Issue 3: Web Server Configuration
**Nginx**: Ensure proper PHP-FPM configuration:
```nginx
location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
    
    # Important for sessions
    fastcgi_param HTTPS on;
    fastcgi_param SERVER_PORT 443;
}
```

### Issue 4: Session Directory Permissions
Even though diagnostic shows writable, check specific directories:
```bash
# Check session storage permissions
ls -la storage/framework/sessions/
chmod -R 755 storage/
chown -R www-data:www-data storage/
```

### Issue 5: Rate Limiting Blocking Requests
**Check**: Clear rate limiters:
```bash
php artisan cache:clear
redis-cli flushall  # if using Redis
```

## Advanced Debugging Commands

### Run Advanced Diagnostics
```bash
php artisan diagnose:login-advanced --test-user=your-email@domain.com
```

### Check Recent Errors
```bash
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

### Test Database Sessions
```bash
php artisan tinker
>>> DB::table('sessions')->latest()->take(5)->get()
>>> DB::table('sessions')->where('user_id', 1)->get()
```

## Step-by-Step Login Debug

### 1. Test CSRF Token
Visit: `https://manifestghana.com/debug-csrf`
Should return valid token and session data.

### 2. Test Session Persistence  
Visit: `https://manifestghana.com/debug-session` twice
Should show same session_id and test data.

### 3. Check Livewire Component
Look at browser Network tab when submitting login form:
- Should see POST to `/livewire/update`
- Response should be JSON with `effects` array
- No 405, 419, or 500 errors

### 4. Test Authentication Manually
```bash
php artisan tinker
>>> $user = App\\Models\\User::first()
>>> Auth::attempt(['email' => $user->email, 'password' => 'known-password'])
>>> Auth::check()
>>> Auth::user()
```

## Common Production Gotchas

### 1. CDN/CloudFlare Issues
If using CloudFlare:
- Disable "Always Online"
- Set SSL to "Full (Strict)"
- Disable "Rocket Loader" for login pages

### 2. Session Domain Mismatch
Your config shows `.manifestghana.com` (with dot)
This should work for both `www.manifestghana.com` and `manifestghana.com`

If issues persist, try:
```env
SESSION_DOMAIN=manifestghana.com  # without dot
```

### 3. HTTPS Redirect Issues
Ensure your web server redirects HTTP to HTTPS properly:
```nginx
server {
    listen 80;
    server_name manifestghana.com www.manifestghana.com;
    return 301 https://$server_name$request_uri;
}
```

## Emergency Fixes

### If All Else Fails:

1. **Switch to File Sessions Temporarily**:
```env
SESSION_DRIVER=file
```

2. **Disable Rate Limiting**:
Comment out rate limiters in `FortifyServiceProvider.php`

3. **Enable Debug Mode Temporarily**:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

4. **Clear Everything**:
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Next Steps

1. Add the debug routes
2. Test the debug URLs
3. Check browser developer tools during login
4. Run the advanced diagnostic command
5. Check web server and application logs
6. Report back with specific error messages or behavior

The key is identifying exactly WHERE the login process fails - is it:
- Form submission not reaching server?
- Server processing but authentication failing? 
- Authentication succeeding but redirect failing?
- JavaScript/Livewire communication issues?
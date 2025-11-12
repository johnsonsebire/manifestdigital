# Production Login Troubleshooting Guide

## Common Issues and Solutions

### 1. Session Configuration Issues

**Problem**: Sessions not persisting between requests in production.

**Solution**: Update these environment variables for production:

```env
# Production Environment Settings
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Session Configuration (Critical for Production)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=yourdomain.com
SESSION_SECURE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Cache Configuration
CACHE_STORE=database
```

### 2. HTTPS/SSL Issues

**Problem**: Mixed content or insecure cookies in HTTPS environment.

**Solution**: Ensure these settings in production:

```env
# Force HTTPS in production
APP_URL=https://yourdomain.com
SESSION_SECURE=true
SESSION_HTTP_ONLY=true
```

**Also add to `app/Providers/AppServiceProvider.php`:**

```php
public function boot(): void
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

### 3. CSRF Token Issues

**Problem**: CSRF token mismatches causing login failures.

**Verification**: Check if CSRF meta tag is present in `<head>`:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

**Solution**: Already implemented in `resources/views/partials/head.blade.php`

### 4. Rate Limiting Issues

**Problem**: Too many login attempts blocking users.

**Solution**: Clear rate limiters if needed:
```bash
php artisan cache:clear
```

### 5. File Permissions

**Problem**: Session files not writable.

**Solution**: Ensure proper permissions:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 6. Database Session Table

**Problem**: Sessions table not properly configured.

**Verification**: Check if sessions table exists:
```bash
php artisan migrate:status
```

**Solution**: Create sessions table if missing:
```bash
php artisan session:table
php artisan migrate
```

## Production Environment Checklist

### Environment Variables to Update:

1. **APP_ENV**: Change from `local` to `production`
2. **APP_DEBUG**: Change from `true` to `false`  
3. **APP_URL**: Update to your production domain with HTTPS
4. **SESSION_DOMAIN**: Set to your production domain (without protocol)
5. **SESSION_SECURE**: Set to `true` for HTTPS
6. **DB_***: Update database credentials for production
7. **MAIL_***: Configure production mail settings

### Commands to Run After Environment Changes:

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if needed
php artisan migrate --force
```

## Debugging Steps

### 1. Check Current Configuration:
```bash
# Verify environment
php artisan env

# Check session configuration
php artisan tinker
>>> config('session')

# Check app configuration  
>>> config('app.url')
>>> config('app.env')
```

### 2. Test Session Functionality:
```bash
# Create test route to check sessions
# Add to routes/web.php temporarily:
Route::get('/test-session', function() {
    session(['test' => 'working']);
    return response()->json([
        'session_id' => session()->getId(),
        'test_value' => session('test'),
        'csrf_token' => csrf_token()
    ]);
});
```

### 3. Check Logs:
```bash
# View recent errors
tail -f storage/logs/laravel.log

# Check web server error logs
tail -f /var/log/nginx/error.log
# OR
tail -f /var/log/apache2/error.log
```

## Production Environment Template

Create a `.env.production` file with these settings:

```env
APP_NAME="Manifest Digital"
APP_ENV=production
APP_KEY=base64:YOUR_PRODUCTION_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=daily
LOG_LEVEL=error

# Production Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_production_db
DB_USERNAME=your_production_user
DB_PASSWORD=your_production_password

# Production Session Settings
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=yourdomain.com
SESSION_SECURE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Production Cache
CACHE_STORE=database
QUEUE_CONNECTION=database

# Production Mail
MAIL_MAILER=smtp
MAIL_HOST=your_mail_server
MAIL_PORT=587
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```
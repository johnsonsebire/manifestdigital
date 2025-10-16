# Deployment Fix for View Cache Issues

## Problem
The `php artisan view:cache` command is failing in production due to missing Flux UI components.

## Solution Options

### Option 1: Skip View Caching (Recommended for Now)
In your deployment script (deploy.php), comment out or remove the view caching step:

```php
// task('artisan:view:cache', artisan('view:cache'));
```

Views will be compiled on-demand, which has minimal performance impact.

### Option 2: Ensure Flux is Properly Installed
Make sure these commands run during deployment:

```bash
composer install --no-dev --optimize-autoloader
php artisan vendor:publish --tag=flux-config
php artisan vendor:publish --tag=flux-views
```

### Option 3: Use Config Cache Instead
Replace view caching with config caching which is safer:

```php
task('artisan:config:cache', artisan('config:cache'));
task('artisan:route:cache', artisan('route:cache'));
// Skip: task('artisan:view:cache', artisan('view:cache'));
```

## Files Fixed
- ✅ Removed `flux:section` components (replaced with div)
- ✅ Removed `x-forms.form` component (replaced with include)
- ✅ Removed heroicon dependencies (removed icons)
- ✅ Fixed `x-app-layout` to `x-layouts.app`

## Remaining Issue
Some Flux components (flux:card, flux:table, etc.) are still in use. These should work if Flux is properly installed in production.

## Quick Fix for Immediate Deployment
Run these commands after deployment:

```bash
cd /var/www/manifestdigital/current
php artisan view:clear
php artisan config:cache
php artisan route:cache
# Skip view:cache for now
```

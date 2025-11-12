# Production Configuration Guide

## Critical Environment Variables for Production

### App Configuration
```bash
APP_NAME="Manifest Digital"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com  # MUST match your actual domain
APP_KEY=base64:your-32-character-key  # Generate with: php artisan key:generate
```

### Session Configuration (Critical for Login Issues)
```bash
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.your-domain.com  # Include subdomain support with dot prefix
SESSION_SECURE_COOKIE=true       # MUST be true for HTTPS
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### Database Configuration
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Common Production Issues & Solutions

### 1. "Page Expired" Login Errors

**Causes:**
- Missing CSRF meta tag (✅ FIXED)
- Incorrect SESSION_DOMAIN setting
- SESSION_SECURE_COOKIE=false on HTTPS sites
- Mismatched APP_URL

**Solutions:**
1. Ensure SESSION_DOMAIN matches your domain:
   ```bash
   # For single domain
   SESSION_DOMAIN=your-domain.com
   
   # For subdomains support
   SESSION_DOMAIN=.your-domain.com
   ```

2. Set secure cookies for HTTPS:
   ```bash
   SESSION_SECURE_COOKIE=true
   ```

3. Verify APP_URL matches exactly:
   ```bash
   APP_URL=https://your-domain.com
   ```

### 2. API Endpoints Not Loading

**Common Causes:**
- File permissions on storage/app directory
- Missing JSON data files
- Web server configuration blocking API routes
- Authentication middleware on public APIs

**Solutions:**
1. Check file permissions:
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

2. Verify JSON files exist:
   ```bash
   ls -la storage/app/projects-data.json
   ```

3. Check web server configuration (Apache/Nginx)

### 3. JavaScript Errors

**Note:** Browser extension conflicts are common and typically show:
- `Cannot read properties of undefined (reading 'onChanged')`
- `Cannot read properties of undefined (reading 'onClicked')`

These are usually not application issues but browser extension conflicts.

## Production Deployment Checklist

- [ ] Set correct APP_URL
- [ ] Configure SESSION_DOMAIN 
- [ ] Enable SESSION_SECURE_COOKIE for HTTPS
- [ ] Set APP_ENV=production
- [ ] Set APP_DEBUG=false
- [ ] Generate APP_KEY
- [ ] Run migrations: `php artisan migrate`
- [ ] Clear caches: `php artisan config:cache`
- [ ] Clear views: `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Configure web server (Apache/Nginx)

## Testing Production Settings Locally

To test production-like settings locally:

1. Temporarily set in .env:
   ```bash
   SESSION_SECURE_COOKIE=false  # Keep false for local HTTP
   SESSION_DOMAIN=localhost
   APP_URL=http://localhost:8000
   ```

2. Test login functionality

3. Revert to production settings for deployment

## Web Server Configuration

### Apache (.htaccess)
Ensure mod_rewrite is enabled and .htaccess contains:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Nginx
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
```

## Debugging Commands

```bash
# Check current configuration
php artisan config:show session
php artisan config:show app

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Verify routes
php artisan route:list | grep api

# Check file permissions
ls -la storage/app/
```
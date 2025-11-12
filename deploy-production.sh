#!/bin/bash

# Production Deployment and Login Fix Script
# This script addresses common production login issues

echo "🚀 Starting production deployment and login fixes..."

# Check if we're in the correct directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this script from the Laravel root directory."
    exit 1
fi

# Backup current .env file
echo "📋 Creating backup of current .env file..."
cp .env .env.backup.$(date +%Y%m%d_%H%M%S)

# Check if production environment variables are set
echo "🔍 Checking environment configuration..."

# Function to check if a value exists in .env
check_env_var() {
    local var_name=$1
    local current_value=$(grep "^${var_name}=" .env | cut -d '=' -f2- | tr -d '"')
    echo "   $var_name: $current_value"
}

echo "Current environment settings:"
check_env_var "APP_ENV"
check_env_var "APP_DEBUG"
check_env_var "APP_URL"
check_env_var "SESSION_DOMAIN"
check_env_var "SESSION_SECURE"
check_env_var "SESSION_DRIVER"

# Prompt for production settings if not already set
read -p "🌐 Enter your production domain (e.g., manifestghana.com): " PRODUCTION_DOMAIN
read -p "🔐 Is this an HTTPS site? (y/n): " HTTPS_ENABLED

if [[ $HTTPS_ENABLED =~ ^[Yy]$ ]]; then
    APP_URL="https://$PRODUCTION_DOMAIN"
    SESSION_SECURE="true"
else
    APP_URL="http://$PRODUCTION_DOMAIN"
    SESSION_SECURE="false"
fi

# Update production environment settings
echo "⚙️ Updating environment configuration for production..."

# Function to update or add environment variable
update_env_var() {
    local var_name=$1
    local var_value=$2
    
    if grep -q "^${var_name}=" .env; then
        # Variable exists, update it
        sed -i "s|^${var_name}=.*|${var_name}=${var_value}|" .env
    else
        # Variable doesn't exist, add it
        echo "${var_name}=${var_value}" >> .env
    fi
}

# Update critical production settings
update_env_var "APP_ENV" "production"
update_env_var "APP_DEBUG" "false"
update_env_var "APP_URL" "$APP_URL"
update_env_var "SESSION_DOMAIN" "$PRODUCTION_DOMAIN"
update_env_var "SESSION_SECURE" "$SESSION_SECURE"
update_env_var "SESSION_HTTP_ONLY" "true"
update_env_var "SESSION_SAME_SITE" "lax"

# Ensure session driver is set to database for production
update_env_var "SESSION_DRIVER" "database"

echo "✅ Environment configuration updated"

# Clear all caches
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Check if sessions table exists
echo "🗄️ Checking sessions table..."
if ! php artisan migrate:status | grep -q "sessions"; then
    echo "📝 Creating sessions table..."
    php artisan session:table
fi

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force

# Set proper file permissions
echo "🔒 Setting file permissions..."
find storage -type d -exec chmod 755 {} \;
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type d -exec chmod 755 {} \;
find bootstrap/cache -type f -exec chmod 644 {} \;

# Change ownership if running as root
if [ "$EUID" -eq 0 ]; then
    echo "👤 Setting ownership to www-data..."
    chown -R www-data:www-data storage/
    chown -R www-data:www-data bootstrap/cache/
fi

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Test configuration
echo "🧪 Testing configuration..."
echo "Environment: $(php artisan env)"

# Create test route for debugging (remove after testing)
echo "🔍 Adding temporary debug route at /debug-login..."
cat >> routes/web.php << 'EOF'

// Temporary debug route - REMOVE AFTER TESTING
Route::get('/debug-login', function() {
    return response()->json([
        'app_env' => config('app.env'),
        'app_url' => config('app.url'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'session_driver' => config('session.driver'),
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'https' => request()->isSecure(),
        'host' => request()->getHost(),
        'user_agent' => request()->userAgent(),
    ]);
})->middleware('web');
EOF

echo "✅ Production deployment complete!"
echo ""
echo "🔗 Test URLs:"
echo "   Main site: $APP_URL"
echo "   Debug info: $APP_URL/debug-login"
echo ""
echo "📝 Next steps:"
echo "1. Test login functionality on your production site"
echo "2. Check the debug URL to verify configuration"
echo "3. Remove the debug route from routes/web.php when done"
echo "4. Monitor logs: tail -f storage/logs/laravel.log"
echo ""
echo "🚨 If login still fails, check:"
echo "1. Web server configuration (nginx/apache)"
echo "2. SSL certificate if using HTTPS"
echo "3. Database connectivity"
echo "4. File permissions"

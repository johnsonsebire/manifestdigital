# Fix Projects API 404 Error - Production Deployment Guide

## Issue Summary
The projects page is not loading because the `projects-data.json` file is missing from the production server's storage directory.

**Error:** `Projects data file not found at /var/www/manifestdigital/releases/27/storage/app/projects-data.json`

## Quick Fix (Immediate)

### Option 1: Use Artisan Command (Recommended)
```bash
# On production server, run:
cd /var/www/manifestdigital/current
php artisan projects:initialize
```

This will:
- Create the missing `storage/app/projects-data.json` file
- Initialize it with default project data
- Confirm the file was created successfully

### Option 2: Manual File Copy
If the artisan command doesn't work, manually copy the file:

```bash
# On production server:
cd /var/www/manifestdigital/current

# Create the file with sample data:
cat > storage/app/projects-data.json << 'EOF'
[
    {"id": 1, "title": "My Help Your Help Foundation", "slug": "my-help-your-help-foundation", "category": "nonprofit", "displayCategory": "Nonprofit", "excerpt": "A non-profit organization dedicated to community development and education.", "image": "/images/projects/myhelpyourhelp.png", "url": "https://myhelpyourhelp.org", "featured": true},
    {"id": 2, "title": "L-Time Properties", "slug": "ltime-properties", "category": "business", "displayCategory": "Real Estate", "excerpt": "Real estate platform connecting buyers with premium properties.", "image": "/images/ltimeproperties.png", "url": "https://ltimepropertiesltd.com", "featured": true},
    {"id": 3, "title": "Koko Plus Foundation", "slug": "koko-plus-foundation", "category": "nonprofit", "displayCategory": "Nonprofit", "excerpt": "Foundation supporting underprivileged communities through education.", "image": "/images/kokoplus.png", "url": "https://kokoplusfoundation.org", "featured": true}
]
EOF

# Set proper permissions:
chmod 644 storage/app/projects-data.json
chown www-data:www-data storage/app/projects-data.json
```

## Verification Steps

### 1. Test the API Directly
```bash
curl https://manifestghana.com/api/projects
```

Should return JSON with projects data, not an error.

### 2. Test the Debug API
```bash
curl https://manifestghana.com/api/projects/debug
```

Should show file exists and is readable.

### 3. Test the Projects Page
Visit: https://manifestghana.com/projects

Projects should load without infinite scroll errors.

## Long-term Solution

### Update Deployment Process
Add this to your deployment script (after the `artisan:migrate` step):

```bash
# In your deployment configuration (like Deployer or similar)
task('projects:initialize', function () {
    run('cd {{release_path}} && php artisan projects:initialize');
})->desc('Initialize projects data if missing');

# Add it to your deployment flow
after('artisan:migrate', 'projects:initialize');
```

### Files Created/Modified

#### ✅ New Files:
1. `app/Console/Commands/InitializeProjectsData.php` - Artisan command to initialize projects data

#### ✅ Modified Files:
1. `app/Http/Controllers/Api/ProjectsController.php` - Better error handling (returns 200 instead of 404)
2. `resources/views/components/projects/grid-section.blade.php` - Stop infinite scroll on errors

## Testing

After implementing the fix:

1. **Projects should load immediately**
2. **No more infinite scroll errors**
3. **API returns proper JSON data**
4. **Debug endpoint shows file exists**

## Error Prevention

### For Future Deployments:
1. Always run `php artisan projects:initialize` after deployment
2. Include storage files in your deployment checklist
3. Consider storing projects data in database instead of JSON files for better reliability

### Alternative Approach (Database Storage):
If JSON file issues persist, consider moving projects data to database:
1. Create a `projects` migration and model
2. Seed projects data during deployment
3. Update API to read from database instead of JSON

This eliminates file system dependencies and makes data management easier.

## Status Check Commands

```bash
# Check if file exists
ls -la storage/app/projects-data.json

# Check file contents
head -5 storage/app/projects-data.json

# Test API endpoint
curl -s https://manifestghana.com/api/projects | jq '.'

# Check Laravel logs for any errors
tail -f storage/logs/laravel.log
```

After running the artisan command or manually creating the file, the projects page should load correctly!
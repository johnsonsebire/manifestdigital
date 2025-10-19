#!/bin/bash

# Production Seeding Script for Services & Categories
# Run this script to seed all services, categories, currencies, and regional pricing

echo "🚀 Starting production seeding for Services & Categories..."
echo "=================================================="

# Set error handling
set -e

# Check if we're in the correct directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this script from the Laravel root directory."
    exit 1
fi

echo "📋 Step 1: Seeding currencies (USD & GHS)..."
php artisan db:seed --class=CurrencySeeder
echo "✅ Currencies seeded successfully"

echo "📂 Step 2: Seeding service categories..."
php artisan db:seed --class=CategorySeeder
echo "✅ Categories seeded successfully"

echo "🛍️  Step 3: Seeding services..."
php artisan db:seed --class=ServiceSeeder
echo "✅ Services seeded successfully"

echo "🌍 Step 4: Seeding regional pricing..."
php artisan db:seed --class=RegionalPricingSeeder
echo "✅ Regional pricing seeded successfully"

echo "🔄 Step 5: Clearing and rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Caches rebuilt successfully"

echo "=================================================="
echo "🎉 Production seeding completed successfully!"
echo ""
echo "📊 Summary:"
echo "   - 7 service categories created"
echo "   - 21 services with full metadata created" 
echo "   - USD & GHS currencies configured"
echo "   - West Africa regional pricing established"
echo "   - All pricing table buttons now functional"
echo ""
echo "🔗 Test the integration:"
echo "   Visit your pricing page and click any service button"
echo "   Services are available at: /services/{slug}"
echo ""
echo "📖 For more details, see PRODUCTION_SEEDING_GUIDE.md"
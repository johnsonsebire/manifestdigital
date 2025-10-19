# Production Seeding Guide - Services & Categories

This guide explains how to seed the services and categories system in production environments.

## Overview

The pricing table integration includes comprehensive seeders for:
- **7 Service Categories** (Website Development, UI/UX Design, Web Hosting, etc.)
- **21 Services** with full metadata and features
- **Currency System** (USD base + GHS regional pricing)
- **Regional Pricing** for West Africa (Ghana)

## Seeder Files Created

### 1. CategorySeeder.php
- Creates 7 main service categories
- Includes descriptions, ordering, and visibility settings
- Uses `updateOrCreate` for safe re-running

### 2. ServiceSeeder.php  
- Creates 21 services across all categories
- Complete metadata including features, delivery times, pricing tiers
- Proper service types: subscription, one_time, custom, consulting, package
- Links services to categories automatically

### 3. CurrencySeeder.php
- Sets up USD as base currency (exchange_rate_to_usd = 1.00)
- Adds GHS (Ghana Cedi) with exchange rate 0.074
- Includes proper formatting and decimal places

### 4. RegionalPricingSeeder.php
- Creates GHS pricing for all paid services
- Maintains original Ghana pricing structure
- Sets West Africa region targeting

## Production Deployment Commands

### Option 1: Run Individual Seeders (Recommended)
```bash
# Run in order - dependencies matter!
php artisan db:seed --class=CurrencySeeder
php artisan db:seed --class=CategorySeeder  
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=RegionalPricingSeeder
```

### Option 2: Run All Seeders
```bash
# This will run all seeders including the new ones
php artisan db:seed
```

### Option 3: Fresh Database Setup
```bash
# For completely fresh environments
php artisan migrate:fresh --seed
```

## Service & Pricing Structure

### Website Development
- **Website Essentials**: $18.52/month (GH₵250)
- **Website Professional**: $37.04/month (GH₵500) *Most Popular*
- **Website Enterprise**: $111.11/month (GH₵1,500)

### UI/UX Design  
- **Basic UI/UX Design**: $185.19/project (GH₵2,500)
- **Professional UI/UX Design**: $444.44/project (GH₵6,000) *Most Popular*
- **Enterprise UI/UX Design**: $740.74/project (GH₵10,000)

### Web Hosting
- **Starter Web Hosting**: $3.70/month (GH₵50)
- **Business Web Hosting**: $11.11/month (GH₵150) *Most Popular*
- **Premium Web Hosting**: $29.63/month (GH₵400)

### Domain Names
- **.com Domain Registration**: $22.22/year (GH₵300)
- **.gh Domain Registration**: $44.44/year (GH₵600) *Most Popular*
- **Premium Domain Acquisition**: Custom pricing

### Mobile App Development
- **Simple Mobile App**: $370.37/project (GH₵5,000)
- **Professional Mobile App**: $1,851.85/project (GH₵25,000) *Most Popular*
- **Enterprise Mobile App**: $3,703.70/project (GH₵50,000)

### Consulting Services
- **Hourly Technical Consulting**: $37.04/hour (GH₵500)
- **Monthly Consulting Retainer**: $370.37/month (GH₵5,000) *Most Popular*
- **Project-Based Consulting**: Custom pricing

### Training Services
- **Individual Technical Training**: $222.22/session (GH₵3,000)
- **Team Technical Training**: $148.15/workshop (GH₵2,000) *Most Popular*
- **Corporate Training Program**: Custom pricing

## Verification Commands

After seeding, verify the data:

```bash
# Check categories
php artisan tinker
>>> App\Models\Category::count()
>>> App\Models\Category::pluck('title')

# Check services  
>>> App\Models\Service::count()
>>> App\Models\Service::with('categories')->get()->pluck('title', 'slug')

# Check regional pricing
>>> App\Models\RegionalPricing::with(['service', 'currency'])->count()
>>> App\Models\Currency::pluck('name', 'code')
```

## Features Included

✅ **Complete Service Catalog**: All 21 services from pricing table
✅ **Category Organization**: 7 logical service categories  
✅ **Multi-Currency Support**: USD base + GHS regional pricing
✅ **Rich Metadata**: Features, delivery times, popular flags
✅ **SEO-Friendly URLs**: Clean slugs for all services and categories
✅ **Production Ready**: Uses updateOrCreate for safe re-running
✅ **Regional Pricing**: Automatic Ghana pricing display

## Pricing Table Integration

All pricing table buttons now link to actual services:
- `/services/website-essentials`
- `/services/professional-mobile-app`  
- `/services/hourly-technical-consulting`
- etc.

Each service page includes:
- Complete feature listings
- Order forms with cart integration
- Related services suggestions
- Regional pricing display

## Notes

- **Safe Re-running**: All seeders use `updateOrCreate()` so they can be run multiple times
- **Dependency Order**: Currency → Categories → Services → Regional Pricing  
- **Regional Pricing**: Currently set for "West Africa" region with GHS currency
- **Custom Pricing**: Services with $0.00 price show "Contact Us" for quotes
- **Most Popular**: Services marked with `most_popular: true` in metadata

## Rollback

If you need to remove the seeded data:

```bash
# Remove in reverse order
php artisan tinker
>>> App\Models\RegionalPricing::truncate()
>>> App\Models\Service::truncate()  
>>> App\Models\Category::truncate()
>>> App\Models\Currency::whereIn('code', ['USD', 'GHS'])->delete()
```

## Support

For issues or questions about the seeding process, check:
1. Database migrations are up to date
2. Required models exist and are properly configured
3. Service enum values match (package, subscription, custom, one_time, ai_enhanced, consulting, add_on)
4. Currency and RegionalPricing table structures match expected columns
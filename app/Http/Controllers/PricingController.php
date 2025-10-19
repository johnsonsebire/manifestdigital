<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Get pricing data for the homepage pricing component
     */
    public function getPricingData(Request $request)
    {
        try {
            // Get user's currency preference or from request parameter
            $requestedCurrency = $request->get('currency');
            
            if ($requestedCurrency) {
                // Validate and get the requested currency
                $userCurrency = \App\Models\Currency::where('code', $requestedCurrency)
                    ->where('is_active', true)
                    ->first();
                    
                if (!$userCurrency) {
                    // Fall back to detected currency if requested currency is invalid
                    $userCurrency = $this->currencyService->detectUserCurrency();
                }
            } else {
                $userCurrency = $this->currencyService->detectUserCurrency();
            }
            
            // Get all services with their categories
            $services = Service::with('categories')
                ->where('visible', true)
                ->where('available', true)
                ->get();

            $servicesData = [];

            foreach ($services as $service) {
                $servicePrice = $this->currencyService->getServicePrice($service, $userCurrency);
                
                $servicesData[] = [
                    'id' => $service->id,
                    'name' => $service->title,
                    'slug' => $service->slug,
                    'price' => $servicePrice['price'],
                    'formatted_price' => $servicePrice['formatted'],
                    'currency' => $userCurrency->symbol,
                    'is_regional' => $servicePrice['is_regional'],
                    'original_price' => $servicePrice['original_price'] ?? null,
                    'savings' => $servicePrice['savings'] ?? null,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'currency' => [
                        'code' => $userCurrency->code,
                        'symbol' => $userCurrency->symbol,
                        'name' => $userCurrency->name,
                    ],
                    'services' => $servicesData,
                    'hasRegionalPricing' => $this->hasRegionalPricing($userCurrency),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load pricing data',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Extract plan name from service title
     */
    private function extractPlanName($title): string
    {
        // Remove category prefixes to get plan names
        $prefixes = ['Website ', 'Basic ', 'Professional ', 'Enterprise ', 'Starter ', 'Business ', 'Premium ', '.com ', '.gh ', 'Simple ', 'Hourly ', 'Monthly ', 'Project-Based ', 'Individual ', 'Team ', 'Corporate '];
        
        foreach ($prefixes as $prefix) {
            if (str_starts_with($title, $prefix)) {
                return trim(str_replace($prefix, '', $title));
            }
        }
        
        return $title;
    }

    /**
     * Get billing period display text
     */
    private function getBillingPeriod(?string $interval): string
    {
        return match($interval) {
            'monthly' => '/month',
            'yearly' => '/year',
            'hourly' => '/hour',
            'project' => '/project',
            'session' => '/session',
            'program' => '/program',
            default => '',
        };
    }

    /**
     * Get cancel text based on service type
     */
    private function getCancelText(Service $service): string
    {
        if ($service->price == 0) {
            return 'Contact for pricing';
        }

        return match($service->type) {
            'subscription' => 'Cancel anytime • 14-day guarantee',
            'one_time' => $service->metadata['delivery_time'] ?? 'Project-based pricing',
            'consulting' => $service->metadata['minimum_hours'] ? 'Minimum ' . $service->metadata['minimum_hours'] . ' hours' : 'Flexible scheduling',
            'package' => $service->metadata['delivery_time'] ?? 'Package deal',
            'custom' => 'Custom terms available',
            default => 'Flexible terms',
        };
    }

    /**
     * Get CTA text based on service type and price
     */
    private function getCtaText(Service $service): string
    {
        if ($service->price == 0) {
            return 'Contact Us';
        }

        return match($service->type) {
            'subscription' => 'Get Started',
            'one_time' => 'Order Now',
            'consulting' => 'Book Session',
            'package' => 'Get Package',
            'custom' => 'Request Quote',
            default => 'Get Started',
        };
    }

    /**
     * Map category slugs to pricing component keys
     */
    private function getCategoryKey(string $slug): string
    {
        return match($slug) {
            'website-development' => 'websites',
            'ui-ux-design' => 'uiux',
            'web-hosting' => 'hosting',
            'domain-names' => 'domains',
            'mobile-app-development' => 'apps',
            'consulting-services' => 'consulting',
            'training-services' => 'training',
            default => str_replace('-', '_', $slug),
        };
    }

    /**
     * Check if user has regional pricing available
     */
    private function hasRegionalPricing($currency): bool
    {
        return $currency->code !== 'USD';
    }
}
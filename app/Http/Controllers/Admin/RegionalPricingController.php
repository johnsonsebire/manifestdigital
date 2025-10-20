<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\RegionalPricing;
use App\Models\Service;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegionalPricingController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of regional pricing.
     */
    public function index(Request $request)
    {
        $query = RegionalPricing::with(['service', 'currency'])
            ->orderBy('service_id')
            ->orderBy('currency_id');

        // Filter by service if provided
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by currency if provided
        if ($request->filled('currency_code')) {
            $query->whereHas('currency', function ($q) use ($request) {
                $q->where('code', $request->currency_code);
            });
        }

        // Filter by region if provided
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // Filter by active status if provided
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $regionalPricing = $query->paginate(20);

        // Get filter options
        $services = Service::select('id', 'title')->orderBy('title')->get();
        $currencies = Currency::where('is_active', true)->select('code', 'name', 'symbol')->orderBy('code')->get();
        $regions = RegionalPricing::distinct()->pluck('region')->filter()->sort()->values();

        return view('admin.regional-pricing.index', compact(
            'regionalPricing',
            'services',
            'currencies',
            'regions'
        ));
    }

    /**
     * Show the form for creating new regional pricing.
     */
    public function create(Request $request)
    {
        $services = Service::select('id', 'title', 'price', 'currency')->orderBy('title')->get();
        $currencies = Currency::where('is_active', true)->orderBy('code')->get();

        // Pre-select service if provided
        $selectedService = null;
        if ($request->filled('service_id')) {
            $selectedService = Service::find($request->service_id);
        }

        return view('admin.regional-pricing.create', compact(
            'services',
            'currencies',
            'selectedService'
        ));
    }

    /**
     * Store a newly created regional pricing.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'currency_id' => 'required|exists:currencies,id',
            'country_code' => 'nullable|string|max:3',
            'region' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'markup_percentage' => 'nullable|numeric|min:-100|max:1000',
            'is_active' => 'boolean',
            'metadata' => 'nullable|array',
        ]);

        // Get the service and currency for calculations
        $service = Service::findOrFail($validated['service_id']);
        $currency = Currency::findOrFail($validated['currency_id']);

        // Calculate original price in the target currency
        $originalPrice = $this->currencyService->convertPrice(
            $service->price,
            $service->currency,
            $currency->code
        );

        // Create the regional pricing
        $regionalPricing = RegionalPricing::create([
            'service_id' => $validated['service_id'],
            'currency_id' => $validated['currency_id'],
            'country_code' => $validated['country_code'],
            'region' => $validated['region'],
            'price' => $validated['price'],
            'original_price' => $originalPrice,
            'markup_percentage' => $validated['markup_percentage'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'metadata' => $validated['metadata'] ?? [],
        ]);

        return redirect()
            ->route('admin.regional-pricing.show', $regionalPricing)
            ->with('success', 'Regional pricing created successfully.');
    }

    /**
     * Display the specified regional pricing.
     */
    public function show(RegionalPricing $regionalPricing)
    {
        $regionalPricing->load(['service', 'currency']);

        // Get pricing history for this service/currency combination
        $pricingHistory = RegionalPricing::where('service_id', $regionalPricing->service_id)
            ->where('currency_id', $regionalPricing->currency_id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.regional-pricing.show', compact(
            'regionalPricing',
            'pricingHistory'
        ));
    }

    /**
     * Show the form for editing regional pricing.
     */
    public function edit(RegionalPricing $regionalPricing)
    {
        $regionalPricing->load(['service', 'currency']);
        $services = Service::select('id', 'title', 'price', 'currency')->orderBy('title')->get();
        $currencies = Currency::where('is_active', true)->orderBy('code')->get();

        return view('admin.regional-pricing.edit', compact(
            'regionalPricing',
            'services',
            'currencies'
        ));
    }

    /**
     * Update the specified regional pricing.
     */
    public function update(Request $request, RegionalPricing $regionalPricing)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'currency_id' => 'required|exists:currencies,id',
            'country_code' => 'nullable|string|max:3',
            'region' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'markup_percentage' => 'nullable|numeric|min:-100|max:1000',
            'is_active' => 'boolean',
            'metadata' => 'nullable|array',
        ]);

        // Recalculate original price if service or currency changed
        if ($regionalPricing->service_id != $validated['service_id'] || 
            $regionalPricing->currency_id != $validated['currency_id']) {
            
            $service = Service::findOrFail($validated['service_id']);
            $currency = Currency::findOrFail($validated['currency_id']);

            $originalPrice = $this->currencyService->convertPrice(
                $service->price,
                $service->currency,
                $currency->code
            );

            $validated['original_price'] = $originalPrice;
        }

        $regionalPricing->update($validated);

        return redirect()
            ->route('admin.regional-pricing.show', $regionalPricing)
            ->with('success', 'Regional pricing updated successfully.');
    }

    /**
     * Remove the specified regional pricing.
     */
    public function destroy(RegionalPricing $regionalPricing)
    {
        $serviceName = $regionalPricing->service->title;
        $currencyCode = $regionalPricing->currency->code;

        $regionalPricing->delete();

        return redirect()
            ->route('admin.regional-pricing.index')
            ->with('success', "Regional pricing for {$serviceName} in {$currencyCode} deleted successfully.");
    }

    /**
     * Bulk create regional pricing for a service across multiple currencies.
     */
    public function bulkCreate(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'currencies' => 'required|array|min:1',
            'currencies.*' => 'exists:currencies,id',
            'region' => 'nullable|string|max:100',
            'markup_percentage' => 'nullable|numeric|min:-100|max:1000',
            'is_active' => 'boolean',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $currencies = Currency::whereIn('id', $validated['currencies'])->get();
        $markupPercentage = $validated['markup_percentage'] ?? 0;

        $created = 0;
        $skipped = 0;

        DB::transaction(function () use ($service, $currencies, $validated, $markupPercentage, &$created, &$skipped) {
            foreach ($currencies as $currency) {
                // Check if regional pricing already exists
                if (RegionalPricing::where('service_id', $service->id)
                    ->where('currency_id', $currency->id)
                    ->exists()) {
                    $skipped++;
                    continue;
                }

                // Calculate prices
                $originalPrice = $this->currencyService->convertPrice(
                    $service->price,
                    $service->currency,
                    $currency->code
                );

                $adjustedPrice = $originalPrice * (1 + ($markupPercentage / 100));

                RegionalPricing::create([
                    'service_id' => $service->id,
                    'currency_id' => $currency->id,
                    'region' => $validated['region'],
                    'price' => $adjustedPrice,
                    'original_price' => $originalPrice,
                    'markup_percentage' => $markupPercentage,
                    'is_active' => $validated['is_active'] ?? true,
                    'metadata' => [],
                ]);

                $created++;
            }
        });

        $message = "Bulk creation completed: {$created} regional pricing entries created";
        if ($skipped > 0) {
            $message .= ", {$skipped} skipped (already exist)";
        }

        return redirect()
            ->route('admin.regional-pricing.index', ['service_id' => $service->id])
            ->with('success', $message);
    }

    /**
     * Get pricing suggestions based on market data.
     */
    public function getPricingSuggestions(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'currency_code' => 'required|exists:currencies,code',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $currency = Currency::where('code', $validated['currency_code'])->firstOrFail();

        // Get base converted price
        $basePrice = $this->currencyService->convertPrice(
            $service->price,
            $service->currency,
            $currency->code
        );

        // Provide pricing suggestions based on region/market
        $suggestions = [
            'conservative' => [
                'price' => $basePrice * 0.9, // 10% discount
                'description' => 'Conservative pricing (10% below base rate)',
                'markup_percentage' => -10,
            ],
            'standard' => [
                'price' => $basePrice,
                'description' => 'Standard pricing (base rate)',
                'markup_percentage' => 0,
            ],
            'premium' => [
                'price' => $basePrice * 1.2, // 20% markup
                'description' => 'Premium pricing (20% above base rate)',
                'markup_percentage' => 20,
            ],
            'luxury' => [
                'price' => $basePrice * 1.5, // 50% markup
                'description' => 'Luxury pricing (50% above base rate)',
                'markup_percentage' => 50,
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'service' => $service->title,
                'currency' => $currency->code,
                'base_price' => $basePrice,
                'suggestions' => $suggestions,
            ]
        ]);
    }

    /**
     * Sync regional pricing for all services in a currency.
     */
    public function syncCurrency(Request $request)
    {
        $validated = $request->validate([
            'currency_code' => 'required|exists:currencies,code',
            'markup_percentage' => 'nullable|numeric|min:-100|max:1000',
            'force_update' => 'boolean',
        ]);

        $currency = Currency::where('code', $validated['currency_code'])->firstOrFail();
        $markupPercentage = $validated['markup_percentage'] ?? 0;
        $forceUpdate = $validated['force_update'] ?? false;

        $services = Service::where('visible', true)->where('available', true)->get();
        $updated = 0;
        $created = 0;

        DB::transaction(function () use ($services, $currency, $markupPercentage, $forceUpdate, &$updated, &$created) {
            foreach ($services as $service) {
                $existingPricing = RegionalPricing::where('service_id', $service->id)
                    ->where('currency_id', $currency->id)
                    ->first();

                // Calculate prices
                $originalPrice = $this->currencyService->convertPrice(
                    $service->price,
                    $service->currency,
                    $currency->code
                );

                $adjustedPrice = $originalPrice * (1 + ($markupPercentage / 100));

                if ($existingPricing) {
                    if ($forceUpdate) {
                        $existingPricing->update([
                            'price' => $adjustedPrice,
                            'original_price' => $originalPrice,
                            'markup_percentage' => $markupPercentage,
                        ]);
                        $updated++;
                    }
                } else {
                    RegionalPricing::create([
                        'service_id' => $service->id,
                        'currency_id' => $currency->id,
                        'price' => $adjustedPrice,
                        'original_price' => $originalPrice,
                        'markup_percentage' => $markupPercentage,
                        'is_active' => true,
                        'metadata' => [],
                    ]);
                    $created++;
                }
            }
        });

        $message = "Currency sync completed for {$currency->code}: {$created} entries created";
        if ($updated > 0) {
            $message .= ", {$updated} entries updated";
        }

        return redirect()
            ->route('admin.regional-pricing.index', ['currency_code' => $currency->code])
            ->with('success', $message);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::orderBy('is_base_currency', 'desc')
            ->orderBy('is_active', 'desc')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate_to_usd' => 'required|numeric|min:0.000001',
            'decimal_places' => 'required|integer|min:0|max:6',
            'format' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['exchange_rate_updated_at'] = now();

        Currency::create($validated);

        return redirect()
            ->route('admin.currencies.index')
            ->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        $currency->load(['countries', 'regionalPricing']);
        
        return view('admin.currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:3', Rule::unique('currencies')->ignore($currency)],
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate_to_usd' => 'required|numeric|min:0.000001',
            'decimal_places' => 'required|integer|min:0|max:6',
            'format' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        // Update exchange rate timestamp if rate changed
        if ($currency->exchange_rate_to_usd != $validated['exchange_rate_to_usd']) {
            $validated['exchange_rate_updated_at'] = now();
        }

        $currency->update($validated);

        return redirect()
            ->route('admin.currencies.index')
            ->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        // Prevent deletion of base currency
        if ($currency->is_base_currency) {
            return redirect()
                ->route('admin.currencies.index')
                ->with('error', 'Cannot delete the base currency.');
        }

        // Check if currency is being used
        if ($currency->countries()->exists() || $currency->regionalPricing()->exists()) {
            return redirect()
                ->route('admin.currencies.index')
                ->with('error', 'Cannot delete currency that is being used by countries or regional pricing.');
        }

        $currency->delete();

        return redirect()
            ->route('admin.currencies.index')
            ->with('success', 'Currency deleted successfully.');
    }

    /**
     * Update exchange rates from external API.
     */
    public function updateRates()
    {
        if ($this->currencyService->updateExchangeRates()) {
            return redirect()
                ->route('admin.currencies.index')
                ->with('success', 'Exchange rates updated successfully!');
        } else {
            return redirect()
                ->route('admin.currencies.index')
                ->with('error', 'Failed to update exchange rates. Check logs for details.');
        }
    }
}

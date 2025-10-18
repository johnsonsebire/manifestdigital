<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use App\Models\Currency;
use App\Models\RegionalTax;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaxController extends Controller
{
    /**
     * Display a listing of the taxes.
     */
    public function index()
    {
        $taxes = Tax::with(['regionalTaxes.currency'])
            ->ordered()
            ->paginate(20);

        return view('admin.taxes.index', compact('taxes'));
    }

    /**
     * Show the form for creating a new tax.
     */
    public function create()
    {
        $currencies = Currency::active()->get();
        return view('admin.taxes.create', compact('currencies'));
    }

    /**
     * Store a newly created tax in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:taxes,code',
            'rate' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:percentage,fixed',
            'fixed_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'is_inclusive' => 'boolean',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $tax = Tax::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'rate' => $request->rate,
            'type' => $request->type,
            'fixed_amount' => $request->type === 'fixed' ? $request->fixed_amount : null,
            'description' => $request->description,
            'is_inclusive' => $request->boolean('is_inclusive'),
            'is_active' => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.taxes.index')
            ->with('success', 'Tax created successfully.');
    }

    /**
     * Display the specified tax.
     */
    public function show(Tax $tax)
    {
        $tax->load(['regionalTaxes.currency']);
        return view('admin.taxes.show', compact('tax'));
    }

    /**
     * Show the form for editing the specified tax.
     */
    public function edit(Tax $tax)
    {
        $currencies = Currency::active()->get();
        $tax->load(['regionalTaxes.currency']);
        return view('admin.taxes.edit', compact('tax', 'currencies'));
    }

    /**
     * Update the specified tax in storage.
     */
    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:10', Rule::unique('taxes', 'code')->ignore($tax->id)],
            'rate' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:percentage,fixed',
            'fixed_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'is_inclusive' => 'boolean',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $tax->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'rate' => $request->rate,
            'type' => $request->type,
            'fixed_amount' => $request->type === 'fixed' ? $request->fixed_amount : null,
            'description' => $request->description,
            'is_inclusive' => $request->boolean('is_inclusive'),
            'is_active' => $request->boolean('is_active'),
            'is_default' => $request->boolean('is_default'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.taxes.index')
            ->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified tax from storage.
     */
    public function destroy(Tax $tax)
    {
        // Check if tax is used in any invoices
        if ($tax->invoices()->count() > 0) {
            return redirect()
                ->route('admin.taxes.index')
                ->with('error', 'Cannot delete tax that is used in invoices.');
        }

        $tax->delete();

        return redirect()
            ->route('admin.taxes.index')
            ->with('success', 'Tax deleted successfully.');
    }

    /**
     * Display regional tax configurations index.
     */
    public function regionalIndex()
    {
        $taxes = Tax::with(['regionalTaxes.currency'])->active()->get();
        $regionalTaxes = RegionalTax::with(['tax', 'currency'])->get();
        $currencies = Currency::active()->get();
        
        return view('admin.taxes.regional', compact('taxes', 'regionalTaxes', 'currencies'));
    }

    /**
     * Store regional tax configuration.
     */
    public function storeRegional(Request $request)
    {
        $request->validate([
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'country_code' => 'nullable|string|size:2',
            'region' => 'nullable|string|max:255',
            'rate_override' => 'nullable|numeric|min:0|max:100',
            'is_applicable' => 'boolean',
            'is_inclusive' => 'nullable|boolean',
            'priority' => 'integer|min:0|max:100',
        ]);

        RegionalTax::create([
            'tax_id' => $request->tax_id,
            'currency_id' => $request->currency_id,
            'country_code' => $request->country_code,
            'region' => $request->region,
            'rate_override' => $request->rate_override,
            'is_applicable' => $request->boolean('is_applicable', true),
            'is_inclusive' => $request->is_inclusive,
            'priority' => $request->priority ?? 0,
        ]);

        return redirect()
            ->route('admin.taxes.regional')
            ->with('success', 'Regional tax configuration added successfully.');
    }

    /**
     * Update regional tax configuration.
     */
    public function updateRegional(Request $request, RegionalTax $regionalTax)
    {
        $request->validate([
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'country_code' => 'nullable|string|size:2',
            'region' => 'nullable|string|max:255',
            'rate_override' => 'nullable|numeric|min:0|max:100',
            'is_applicable' => 'boolean',
            'is_inclusive' => 'nullable|boolean',
            'priority' => 'integer|min:0|max:100',
        ]);

        $regionalTax->update([
            'tax_id' => $request->tax_id,
            'currency_id' => $request->currency_id,
            'country_code' => $request->country_code,
            'region' => $request->region,
            'rate_override' => $request->rate_override,
            'is_applicable' => $request->boolean('is_applicable'),
            'is_inclusive' => $request->is_inclusive,
            'priority' => $request->priority ?? 0,
        ]);

        return redirect()
            ->route('admin.taxes.regional')
            ->with('success', 'Regional tax configuration updated successfully.');
    }

    /**
     * Remove regional tax configuration.
     */
    public function destroyRegional(RegionalTax $regionalTax)
    {
        $regionalTax->delete();

        return redirect()
            ->route('admin.taxes.regional')
            ->with('success', 'Regional tax configuration deleted successfully.');
    }
}

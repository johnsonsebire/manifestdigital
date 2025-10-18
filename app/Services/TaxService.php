<?php

namespace App\Services;

use App\Models\Tax;
use App\Models\RegionalTax;
use App\Models\Currency;
use App\Models\Invoice;

class TaxService
{
    /**
     * Get applicable taxes for a specific region and currency.
     */
    public function getApplicableTaxes(?string $countryCode = null, ?int $currencyId = null): \Illuminate\Database\Eloquent\Collection
    {
        // If we have specific regional configurations, use them
        if ($countryCode || $currencyId) {
            $regionalTaxes = RegionalTax::applicable()
                ->when($countryCode, fn($q) => $q->forCountry($countryCode))
                ->when($currencyId, fn($q) => $q->forCurrency($currencyId))
                ->byPriority()
                ->with('tax')
                ->get();
            
            if ($regionalTaxes->isNotEmpty()) {
                return $regionalTaxes->map(function ($regionalTax) {
                    $tax = $regionalTax->tax;
                    
                    // Use regional override rate if available
                    if ($regionalTax->rate_override !== null) {
                        $tax->rate = $regionalTax->rate_override;
                    }
                    
                    // Use regional inclusive setting if specified
                    if ($regionalTax->is_inclusive !== null) {
                        $tax->is_inclusive = $regionalTax->is_inclusive;
                    }
                    
                    return $tax;
                });
            }
        }
        
        // Special handling for international clients (no country code)
        if (!$countryCode && $currencyId) {
            $currency = Currency::find($currencyId);
            
            // If it's USD (international currency), default to no taxes
            if ($currency && $currency->code === 'USD') {
                return Tax::whereRaw('1 = 0')->get(); // Empty eloquent collection
            }
        }
        
        // For Ghana or when country is specified, use default taxes
        if ($countryCode === 'GH') {
            return Tax::active()->default()->ordered()->get();
        }
        
        // For all other cases, no taxes by default (international clients should be exempt)
        return Tax::whereRaw('1 = 0')->get(); // Empty eloquent collection
    }

    /**
     * Calculate total tax for an amount with multiple taxes.
     */
    public function calculateTotalTax(float $baseAmount, \Illuminate\Database\Eloquent\Collection $taxes, bool $compoundTaxes = false): array
    {
        $taxBreakdown = [];
        $totalTaxAmount = 0;
        $taxableAmount = $baseAmount;

        foreach ($taxes as $tax) {
            $taxAmount = $tax->calculateTaxAmount($taxableAmount);
            
            $taxBreakdown[] = [
                'tax_id' => $tax->id,
                'name' => $tax->name,
                'code' => $tax->code,
                'rate' => $tax->rate,
                'type' => $tax->type,
                'taxable_amount' => $taxableAmount,
                'tax_amount' => $taxAmount,
                'is_inclusive' => $tax->is_inclusive,
            ];
            
            $totalTaxAmount += $taxAmount;
            
            // For compound taxes, add the current tax to the base for the next tax
            if ($compoundTaxes && !$tax->is_inclusive) {
                $taxableAmount += $taxAmount;
            }
        }

        return [
            'base_amount' => $baseAmount,
            'total_tax_amount' => $totalTaxAmount,
            'total_amount' => $baseAmount + $totalTaxAmount,
            'tax_breakdown' => $taxBreakdown,
        ];
    }

    /**
     * Apply taxes to an invoice.
     */
    public function applyTaxesToInvoice(Invoice $invoice, array $selectedTaxIds = null): Invoice
    {
        // Get applicable taxes based on invoice location and currency
        $applicableTaxes = $this->getApplicableTaxes(
            $invoice->billing_country_code,
            $invoice->currency_id
        );

        // Filter by selected taxes if provided
        if ($selectedTaxIds !== null && $selectedTaxIds !== []) {
            $applicableTaxes = $applicableTaxes->filter(function ($tax) use ($selectedTaxIds) {
                return in_array($tax->id, $selectedTaxIds);
            });
        }

        // Calculate taxes on subtotal + additional fees - discount
        $taxableAmount = $invoice->subtotal + ($invoice->additional_fees ?? 0) - $invoice->discount_amount;
        $taxCalculation = $this->calculateTotalTax($taxableAmount, $applicableTaxes);

        // Update invoice
        $invoice->update([
            'total_tax_amount' => $taxCalculation['total_tax_amount'],
            'tax_breakdown' => json_encode($taxCalculation['tax_breakdown']),
            'total_amount' => $invoice->subtotal + ($invoice->additional_fees ?? 0) + $taxCalculation['total_tax_amount'] - $invoice->discount_amount,
        ]);

        // Update balance due
        $invoice->balance_due = $invoice->total_amount - $invoice->amount_paid;
        $invoice->save();

        // Clear existing tax relationships
        $invoice->taxes()->detach();

        // Create new tax relationships
        foreach ($taxCalculation['tax_breakdown'] as $taxBreakdown) {
            $invoice->taxes()->attach($taxBreakdown['tax_id'], [
                'tax_rate' => $taxBreakdown['rate'],
                'taxable_amount' => $taxBreakdown['taxable_amount'],
                'tax_amount' => $taxBreakdown['tax_amount'],
                'is_inclusive' => $taxBreakdown['is_inclusive'],
                'metadata' => json_encode([
                    'tax_name' => $taxBreakdown['name'],
                    'tax_code' => $taxBreakdown['code'],
                    'calculation_date' => now()->toISOString(),
                ]),
            ]);
        }

        return $invoice->fresh(['taxes']);
    }

    /**
     * Get default taxes for a currency/region combination.
     */
    public function getDefaultTaxes(?string $countryCode = null, ?int $currencyId = null): \Illuminate\Database\Eloquent\Collection
    {
        // For Ghana (GH) with GHS currency, return Ghana-specific taxes
        if ($countryCode === 'GH' && $currencyId) {
            $currency = Currency::find($currencyId);
            if ($currency && $currency->code === 'GHS') {
                return $this->getApplicableTaxes('GH', $currencyId);
            }
        }

        // For international clients (USD), typically no taxes
        if ($currencyId) {
            $currency = Currency::find($currencyId);
            if ($currency && $currency->code === 'USD') {
                // Check if there are specific international tax rules
                $internationalTaxes = $this->getApplicableTaxes(null, $currencyId);
                return $internationalTaxes;
            }
        }

        // Fallback to default taxes
        return Tax::active()->default()->ordered()->get();
    }

    /**
     * Update tax rates from external sources (if applicable).
     */
    public function updateTaxRates(): bool
    {
        // This could be extended to update tax rates from government APIs
        // For now, it's a placeholder for future implementation
        
        // Log the update attempt
        logger()->info('Tax rates update requested', [
            'timestamp' => now(),
            'status' => 'not_implemented'
        ]);

        return true;
    }

    /**
     * Validate tax configuration for a region.
     */
    public function validateTaxConfiguration(?string $countryCode = null, ?int $currencyId = null): array
    {
        $issues = [];
        
        $taxes = $this->getApplicableTaxes($countryCode, $currencyId);
        
        if ($taxes->isEmpty()) {
            $issues[] = "No taxes configured for country: " . ($countryCode ?? 'international') . 
                       " with currency ID: " . ($currencyId ?? 'any');
        }

        $totalRate = $taxes->sum('rate');
        if ($totalRate > 50) {
            $issues[] = "Combined tax rate ({$totalRate}%) seems unusually high";
        }

        return $issues;
    }
}
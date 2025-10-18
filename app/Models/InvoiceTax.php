<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceTax extends Model
{
    protected $fillable = [
        'invoice_id',
        'tax_id',
        'tax_rate',
        'taxable_amount',
        'tax_amount',
        'is_inclusive',
        'metadata',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'is_inclusive' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the invoice that owns this tax line.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the tax definition.
     */
    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}

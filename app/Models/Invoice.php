<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use LogsActivity;
    protected $attributes = [
        'total_amount' => 0,
        'amount_paid' => 0,
        'balance_due' => 0,
        'discount_amount' => 0,
        'additional_fees' => 0,
        'total_tax_amount' => 0,
        'tax_rate' => 0,
        'tax_amount' => 0,
        'exchange_rate' => 1,
    ];

    protected $fillable = [
        'invoice_number',
        'order_id',
        'customer_id',
        'client_name',
        'client_email',
        'client_phone',
        'client_address',
        'client_company',
        'billing_country_code',
        'currency_id',
        'exchange_rate',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_rate', // Legacy field - kept for compatibility
        'tax_amount', // Legacy field - kept for compatibility
        'total_tax_amount', // New field for multi-tax support
        'tax_breakdown', // JSON field storing detailed tax information
        'discount_amount',
        'additional_fees',
        'total_amount',
        'amount_paid',
        'balance_due',
        'status',
        'notes',
        'metadata',
        'sent_at',
        'paid_at',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_tax_amount' => 'decimal:2',
        'tax_breakdown' => 'array',
        'exchange_rate' => 'decimal:4',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'metadata' => 'array',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'invoice_taxes')
                    ->withPivot('tax_rate', 'taxable_amount', 'tax_amount', 'is_inclusive', 'metadata')
                    ->withTimestamps();
    }

    // Helper Methods
    public static function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $lastInvoice = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -4)) + 1 : 1;
        
        return sprintf('INV-%s-%04d', $year, $number);
    }

    public function calculateTotals(): void
    {
        $additionalFees = $this->additional_fees ?? 0;
        
        // For backward compatibility, check if we have new tax system data
        if ($this->total_tax_amount !== null) {
            // Use new multi-tax system
            $this->total_amount = $this->subtotal + $additionalFees + $this->total_tax_amount - $this->discount_amount;
        } else {
            // Fall back to legacy single tax calculation
            $this->tax_amount = ($this->subtotal + $additionalFees - $this->discount_amount) * ($this->tax_rate / 100);
            $this->total_amount = $this->subtotal + $additionalFees + $this->tax_amount - $this->discount_amount;
        }
        
        // Calculate balance
        $this->balance_due = $this->total_amount - $this->amount_paid;
    }

    public function recordPayment(float $amount, array $paymentData = []): void
    {
        $this->amount_paid += $amount;
        $this->balance_due = $this->total_amount - $this->amount_paid;

        if ($this->balance_due <= 0) {
            $this->status = 'paid';
            $this->paid_at = now();
        } elseif ($this->amount_paid > 0) {
            $this->status = 'partial';
        }

        // Store payment metadata
        $payments = $this->metadata['payments'] ?? [];
        $payments[] = array_merge([
            'amount' => $amount,
            'date' => now()->toDateTimeString(),
        ], $paymentData);
        
        $this->metadata = array_merge($this->metadata ?? [], ['payments' => $payments]);
        
        $this->save();
    }

    public function markAsSent(): void
    {
        $this->status = 'sent';
        $this->sent_at = now();
        $this->save();
    }

    public function markAsPaid(): void
    {
        $this->status = 'paid';
        $this->paid_at = now();
        $this->amount_paid = $this->total_amount;
        $this->balance_due = 0;
        $this->save();
    }

    public function markAsOverdue(): void
    {
        if ($this->status !== 'paid' && $this->due_date->isPast()) {
            $this->status = 'overdue';
            $this->save();
        }
    }

    public function cancel(): void
    {
        $this->status = 'cancelled';
        $this->save();
    }

    // Query Scopes
    public function scopePending($query)
    {
        return $query->whereIn('status', ['draft', 'sent']);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->whereIn('status', ['sent', 'partial'])
                  ->where('due_date', '<', now());
            });
    }

    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope a query to search invoices by keyword.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('invoice_number', 'like', "%{$search}%")
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('order', function ($q) use ($search) {
                    $q->where('uuid', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $from = null, $to = null)
    {
        if ($from) {
            $query->whereDate('invoice_date', '>=', $from);
        }
        if ($to) {
            $query->whereDate('invoice_date', '<=', $to);
        }
        return $query;
    }

    /**
     * Scope a query to filter by amount range.
     */
    public function scopeAmountRange($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('total_amount', '>=', $min);
        }
        if ($max !== null) {
            $query->where('total_amount', '<=', $max);
        }
        return $query;
    }

    // Accessors
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || 
               (!$this->isPaid() && $this->due_date && $this->due_date->isPast());
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'zinc',
            'sent' => 'blue',
            'paid' => 'green',
            'partial' => 'amber',
            'overdue' => 'red',
            'cancelled' => 'zinc',
            default => 'zinc',
        };
    }

    public function getDaysUntilDueAttribute(): int
    {
        if (!$this->due_date) return 0;
        return $this->due_date->diffInDays(now(), false);
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->isOverdue()) return 0;
        return now()->diffInDays($this->due_date);
    }

    /**
     * Get the client name (from registered customer or manual entry)
     */
    public function getClientNameAttribute(): string
    {
        return $this->attributes['client_name'] ?? $this->customer?->name ?? 'Unknown Client';
    }

    /**
     * Get the client email (from registered customer or manual entry)
     */
    public function getClientEmailAttribute(): string
    {
        return $this->attributes['client_email'] ?? $this->customer?->email ?? '';
    }

    /**
     * Check if invoice is for a manual (non-registered) client
     */
    public function isManualClient(): bool
    {
        return !$this->customer_id && $this->attributes['client_name'];
    }

    /**
     * Create invoice from order
     */
    public static function createFromOrder(Order $order, ?int $dueInDays = 30, ?float $taxRate = 0): self
    {
        $invoice = self::create([
            'invoice_number' => self::generateInvoiceNumber(),
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'client_name' => $order->customer_name,
            'client_email' => $order->customer_email,
            'client_phone' => $order->customer_phone,
            'client_address' => $order->customer_address,
            'invoice_date' => now(),
            'due_date' => now()->addDays($dueInDays),
            'subtotal' => $order->subtotal,
            'tax_rate' => $taxRate,
            'discount_amount' => $order->discount ?? 0,
            'amount_paid' => 0,
            'status' => 'draft',
            'notes' => "Invoice for Order #{$order->order_number}",
        ]);

        $invoice->calculateTotals();
        $invoice->save();

        return $invoice;
    }

    /**
     * Get the effective tax amount (from new or legacy system)
     */
    public function getEffectiveTaxAmount(): float
    {
        return $this->total_tax_amount ?? $this->tax_amount ?? 0;
    }

    /**
     * Check if invoice uses the new multi-tax system
     */
    public function usesMultiTaxSystem(): bool
    {
        return $this->total_tax_amount !== null || !empty($this->tax_breakdown);
    }

    /**
     * Get formatted tax breakdown for display
     */
    public function getFormattedTaxBreakdown(): array
    {
        if (!$this->usesMultiTaxSystem()) {
            // Return legacy tax info in new format
            return $this->tax_amount > 0 ? [[
                'name' => 'Tax',
                'code' => 'TAX',
                'rate' => $this->tax_rate,
                'amount' => $this->tax_amount,
                'type' => 'percentage'
            ]] : [];
        }

        // Ensure tax_breakdown is properly decoded as array
        $taxBreakdown = $this->tax_breakdown;
        
        // If it's still a string (JSON), decode it
        if (is_string($taxBreakdown)) {
            $taxBreakdown = json_decode($taxBreakdown, true) ?? [];
        }
        
        // Ensure it's an array
        if (!is_array($taxBreakdown)) {
            return [];
        }

        // Normalize the array structure to ensure 'amount' key exists
        return array_map(function ($tax) {
            // Handle both 'tax_amount' and 'amount' keys for backward compatibility
            if (isset($tax['tax_amount']) && !isset($tax['amount'])) {
                $tax['amount'] = $tax['tax_amount'];
            }
            return $tax;
        }, $taxBreakdown);
    }

    /**
     * Get the currency symbol or code
     */
    public function getCurrencySymbol(): string
    {
        return $this->currency?->symbol ?? $this->currency?->code ?? '$';
    }

    /**
     * Apply tax service calculations to this invoice
     */
    public function applyTaxCalculations(array $selectedTaxIds = null): self
    {
        $taxService = app(\App\Services\TaxService::class);
        return $taxService->applyTaxesToInvoice($this, $selectedTaxIds);
    }

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'invoice_number',
                'status',
                'issue_date',
                'due_date',
                'sent_date',
                'paid_date',
                'subtotal',
                'tax_rate',
                'tax_amount',
                'total_tax_amount',
                'discount_amount',
                'total_amount',
                'amount_paid',
                'notes',
                'terms',
                'payment_method'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Invoice created',
                'updated' => 'Invoice updated',
                'deleted' => 'Invoice deleted',
                default => "Invoice {$eventName}",
            })
            ->useLogName('invoices');
    }
}

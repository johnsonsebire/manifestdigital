<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'order_id',
        'customer_id',
        'client_name',
        'client_email',
        'client_phone',
        'client_address',
        'client_company',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
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
        // Calculate tax amount
        $this->tax_amount = $this->subtotal * ($this->tax_rate / 100);
        
        // Calculate total
        $this->total_amount = $this->subtotal + $this->tax_amount - $this->discount_amount;
        
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
}

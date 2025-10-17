<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'service_id',
        'variant_id',
        'title',
        'unit_price',
        'quantity',
        'line_total',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            // Auto-calculate line total
            $item->line_total = $item->unit_price * $item->quantity;
        });
    }

    /**
     * Get the order this item belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the service this item is based on.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the service variant this item is based on.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ServiceVariant::class, 'variant_id');
    }

    /**
     * Get the tasks linked to this order item.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get formatted line total.
     */
    public function getFormattedLineTotalAttribute(): string
    {
        $currency = $this->order->currency ?? 'USD';
        return number_format($this->line_total, 2) . ' ' . $currency;
    }
}

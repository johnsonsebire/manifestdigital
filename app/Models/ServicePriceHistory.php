<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePriceHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'old_price',
        'new_price',
        'currency',
        'reason',
        'changed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'old_price' => 'decimal:2',
        'new_price' => 'decimal:2',
    ];

    /**
     * Get the service this price history belongs to.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the user who changed the price.
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Get the price difference.
     */
    public function getPriceDifferenceAttribute(): float
    {
        return $this->new_price - $this->old_price;
    }

    /**
     * Get the percentage change.
     */
    public function getPercentageChangeAttribute(): float
    {
        if ($this->old_price == 0) {
            return 0;
        }
        return (($this->new_price - $this->old_price) / $this->old_price) * 100;
    }
}

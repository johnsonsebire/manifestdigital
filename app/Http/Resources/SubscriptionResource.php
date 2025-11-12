<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => $this->status,
            'billing_interval' => $this->billing_interval,
            'auto_renew' => $this->auto_renew,
            
            // Dates
            'starts_at' => $this->starts_at?->toIso8601String(),
            'expires_at' => $this->expires_at?->toIso8601String(),
            'trial_ends_at' => $this->trial_ends_at?->toIso8601String(),
            'cancelled_at' => $this->cancelled_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            
            // Financial
            'renewal_price' => $this->renewal_price ? (float) $this->renewal_price : null,
            'renewal_discount_percentage' => $this->renewal_discount_percentage ? (float) $this->renewal_discount_percentage : null,
            
            // Computed
            'days_until_expiration' => $this->getDaysUntilExpiration(),
            'is_active' => $this->isActive(),
            'is_expired' => $this->isExpired(),
            
            // Relationships
            'service' => $this->when($this->relationLoaded('service'), function () {
                return [
                    'id' => $this->service->id,
                    'name' => $this->service->name,
                    'description' => $this->service->description,
                    'price' => (float) $this->service->price,
                ];
            }),
            
            'customer' => $this->when($this->relationLoaded('customer'), function () {
                return [
                    'id' => $this->customer->id,
                    'name' => $this->customer->name,
                    'email' => $this->customer->email,
                ];
            }),
            
            'order' => $this->when($this->relationLoaded('order'), function () {
                return $this->order ? [
                    'id' => $this->order->id,
                    'uuid' => $this->order->uuid,
                    'status' => $this->order->status,
                    'total_amount' => (float) $this->order->total_amount,
                ] : null;
            }),
            
            // Metadata
            'metadata' => $this->metadata ?? [],
            'cancellation_reason' => $this->cancellation_reason,
            'custom_billing_terms' => $this->custom_billing_terms,
        ];
    }
}

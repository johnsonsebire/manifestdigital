<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Service;
use App\Models\Order;
use App\Models\User;
use App\Models\ExpirationReminderLog;
use App\Models\ServiceExpirationReminder;
use App\Notifications\SubscriptionExpiringNotification;
use App\Notifications\SubscriptionExpiredNotification;
use App\Notifications\SubscriptionRenewalAvailableNotification;
use App\Notifications\SubscriptionCancelledNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Create a new subscription from an order.
     */
    public function createSubscription(Order $order, Service $service, User $customer, array $options = []): Subscription
    {
        if (!$service->requiresSubscriptionManagement()) {
            throw new \InvalidArgumentException('Service does not support subscriptions');
        }

        DB::beginTransaction();
        
        try {
            $startDate = $options['start_date'] ?? now();
            $expirationDate = $service->calculateExpirationDate($startDate);
            
            $subscription = Subscription::create([
                'uuid' => Str::uuid(),
                'order_id' => $order->id,
                'service_id' => $service->id,
                'customer_id' => $customer->id,
                'starts_at' => $startDate,
                'expires_at' => $expirationDate,
                'next_billing_date' => $expirationDate,
                'billing_interval' => $service->billing_interval,
                'billing_amount' => $service->price,
                'currency' => $service->currency,
                'auto_renew_enabled' => $options['auto_renew'] ?? $service->auto_renew_enabled,
                'status' => 'active',
                'trial_ends_at' => $options['trial_ends_at'] ?? null,
                'minimum_term_ends_at' => $this->calculateMinimumTermEnd($startDate, $service),
                'custom_billing_terms' => $options['custom_billing_terms'] ?? null,
                'metadata' => array_merge([
                    'created_from_order' => $order->uuid,
                    'setup_fee_paid' => $service->hasSetupFee(),
                    'original_price' => $service->price,
                ], $options['metadata'] ?? []),
            ]);

            // Log subscription creation
            Log::info('Subscription created', [
                'subscription_id' => $subscription->id,
                'subscription_uuid' => $subscription->uuid,
                'order_id' => $order->id,
                'service_id' => $service->id,
                'customer_id' => $customer->id,
                'expires_at' => $expirationDate,
            ]);

            DB::commit();
            
            return $subscription;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create subscription', [
                'order_id' => $order->id,
                'service_id' => $service->id,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Renew an existing subscription.
     */
    public function renewSubscription(Subscription $subscription, array $options = []): Subscription
    {
        DB::beginTransaction();
        
        try {
            $service = $subscription->service;
            $isEarlyRenewal = $subscription->expires_at->isFuture();
            
            // Calculate new expiration date
            $baseDate = $isEarlyRenewal ? $subscription->expires_at : now();
            $newExpirationDate = $service->calculateExpirationDate($baseDate);
            
            // Calculate renewal price
            $renewalPrice = $options['price'] ?? $this->calculateRenewalPrice($subscription);
            
            // Update subscription
            $subscription->update([
                'expires_at' => $newExpirationDate,
                'next_billing_date' => $newExpirationDate,
                'billing_amount' => $renewalPrice,
                'status' => 'active',
                'last_renewed_at' => now(),
                'renewal_count' => $subscription->renewal_count + 1,
                'cancelled_at' => null,
                'cancelled_by' => null,
                'cancellation_reason' => null,
                'metadata' => array_merge($subscription->metadata ?? [], [
                    'last_renewal' => [
                        'date' => now()->toISOString(),
                        'price' => $renewalPrice,
                        'early_renewal' => $isEarlyRenewal,
                        'previous_expiration' => $subscription->getOriginal('expires_at'),
                    ],
                ], $options['metadata'] ?? []),
            ]);

            // Log renewal
            Log::info('Subscription renewed', [
                'subscription_id' => $subscription->id,
                'subscription_uuid' => $subscription->uuid,
                'new_expiration' => $newExpirationDate,
                'renewal_price' => $renewalPrice,
                'early_renewal' => $isEarlyRenewal,
            ]);

            DB::commit();
            
            return $subscription->fresh();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to renew subscription', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Cancel a subscription.
     */
    public function cancelSubscription(Subscription $subscription, array $options = []): Subscription
    {
        DB::beginTransaction();
        
        try {
            $effectiveDate = $options['effective_date'] ?? $subscription->expires_at;
            $reason = $options['reason'] ?? 'Customer request';
            $cancelledBy = $options['cancelled_by'] ?? auth()->id();
            
            // Check for early termination fee
            $earlyTerminationFee = 0;
            if ($subscription->hasEarlyTerminationFee()) {
                $earlyTerminationFee = $subscription->service->early_termination_fee;
            }
            
            // Calculate refund if applicable
            $refundAmount = $options['refund_amount'] ?? $this->calculateRefundAmount($subscription, $effectiveDate);
            
            $subscription->update([
                'status' => $effectiveDate->isPast() ? 'cancelled' : 'pending_cancellation',
                'cancelled_at' => now(),
                'cancelled_by' => $cancelledBy,
                'cancellation_reason' => $reason,
                'cancellation_effective_date' => $effectiveDate,
                'auto_renew_enabled' => false,
                'metadata' => array_merge($subscription->metadata ?? [], [
                    'cancellation' => [
                        'date' => now()->toISOString(),
                        'reason' => $reason,
                        'effective_date' => $effectiveDate->toISOString(),
                        'refund_amount' => $refundAmount,
                        'early_termination_fee' => $earlyTerminationFee,
                    ],
                ]),
            ]);

            // Send cancellation notification
            $subscription->customer->notify(new SubscriptionCancelledNotification(
                $subscription,
                $reason,
                $effectiveDate,
                $refundAmount
            ));

            Log::info('Subscription cancelled', [
                'subscription_id' => $subscription->id,
                'subscription_uuid' => $subscription->uuid,
                'reason' => $reason,
                'effective_date' => $effectiveDate,
                'refund_amount' => $refundAmount,
            ]);

            DB::commit();
            
            return $subscription->fresh();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to cancel subscription', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Check for expiring subscriptions and send reminders.
     */
    public function checkExpirations(bool $dryRun = false): array
    {
        $results = [
            'checked' => 0,
            'reminders_sent' => 0,
            'errors' => [],
            'details' => [],
        ];

        // Get all active subscriptions that might need reminders
        $subscriptions = Subscription::with(['service', 'customer'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->where('expires_at', '<=', now()->addDays(15)) // Max reminder window
            ->get();

        $results['checked'] = $subscriptions->count();

        foreach ($subscriptions as $subscription) {
            try {
                $remindersSent = $this->sendRemindersForSubscription($subscription, $dryRun);
                $results['reminders_sent'] += $remindersSent;
                
                if ($remindersSent > 0) {
                    $results['details'][] = [
                        'subscription_uuid' => $subscription->uuid,
                        'service' => $subscription->service->title,
                        'customer' => $subscription->customer->email,
                        'expires_at' => $subscription->expires_at,
                        'reminders_sent' => $remindersSent,
                    ];
                }
            } catch (\Exception $e) {
                $results['errors'][] = [
                    'subscription_uuid' => $subscription->uuid,
                    'error' => $e->getMessage(),
                ];
                
                Log::error('Failed to process subscription reminders', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Send reminders for a specific subscription.
     */
    protected function sendRemindersForSubscription(Subscription $subscription, bool $dryRun = false): int
    {
        $service = $subscription->service;
        $customer = $subscription->customer;
        $daysUntilExpiration = now()->diffInDays($subscription->expires_at, false);
        
        // Get reminder schedule for this service/customer
        $reminderConfig = ServiceExpirationReminder::getReminderSchedule($service->id, $customer->id);
        $remindersSent = 0;

        foreach ($reminderConfig['intervals'] as $reminderType) {
            $reminderDays = (int) str_replace('_days', '', $reminderType);
            
            // Check if we should send this reminder
            if ($daysUntilExpiration <= $reminderDays && $daysUntilExpiration >= 0) {
                // Check if reminder already sent
                if (ExpirationReminderLog::wasReminderSent($subscription->id, $reminderType)) {
                    continue;
                }

                if (!$dryRun) {
                    // Send reminder notification
                    $customer->notify(new SubscriptionExpiringNotification(
                        $subscription,
                        $reminderType,
                        $reminderConfig['email_template']
                    ));

                    // Log the reminder
                    ExpirationReminderLog::logReminder(
                        $subscription->id,
                        $reminderType,
                        $reminderConfig['email_template'] ?: 'default',
                        $customer->email
                    );
                }

                $remindersSent++;
            }
        }

        return $remindersSent;
    }

    /**
     * Calculate pro-rated amount for partial periods.
     */
    public function calculateProRatedAmount(Subscription $subscription, \DateTime $fromDate, \DateTime $toDate): float
    {
        if (!$subscription->service->prorated_billing) {
            return (float) $subscription->service->price;
        }

        $service = $subscription->service;
        $fullPeriodDays = $this->getFullPeriodDays($service->billing_interval);
        $actualDays = $fromDate->diff($toDate)->days;
        
        $dailyRate = (float) $service->price / $fullPeriodDays;
        return round($dailyRate * $actualDays, 2);
    }

    /**
     * Handle early renewal with potential bonuses.
     */
    public function handleEarlyRenewal(Subscription $subscription, array $options = []): array
    {
        $daysRemaining = now()->diffInDays($subscription->expires_at, false);
        $service = $subscription->service;
        
        // Calculate early renewal discount
        $earlyRenewalDiscount = $options['early_discount'] ?? $this->calculateEarlyRenewalDiscount($daysRemaining);
        $renewalPrice = $this->calculateRenewalPrice($subscription, $earlyRenewalDiscount);
        
        // Extend from current expiration date (no lost time)
        $newExpirationDate = $service->calculateExpirationDate($subscription->expires_at);
        
        return [
            'renewal_price' => $renewalPrice,
            'discount_percentage' => $earlyRenewalDiscount,
            'savings' => (float) $service->price - $renewalPrice,
            'new_expiration_date' => $newExpirationDate,
            'bonus_days' => $daysRemaining, // Days added to current subscription
        ];
    }

    /**
     * Calculate renewal price with discounts.
     */
    public function calculateRenewalPrice(Subscription $subscription, ?float $additionalDiscount = null): float
    {
        $service = $subscription->service;
        $basePrice = (float) $service->price;
        
        // Apply service renewal discount
        if ($service->renewal_discount_percentage > 0) {
            $basePrice = $service->getRenewalPrice();
        }
        
        // Apply additional discount (for early renewals, etc.)
        if ($additionalDiscount && $additionalDiscount > 0) {
            $additionalDiscountAmount = $basePrice * ($additionalDiscount / 100);
            $basePrice -= $additionalDiscountAmount;
        }
        
        return round($basePrice, 2);
    }

    /**
     * Calculate minimum term end date.
     */
    protected function calculateMinimumTermEnd(\DateTime $startDate, Service $service): ?\DateTime
    {
        $minimumTermMonths = $service->getMinimumBillingTermAttribute();
        
        if (!$minimumTermMonths) {
            return null;
        }
        
        return (clone $startDate)->add(new \DateInterval("P{$minimumTermMonths}M"));
    }

    /**
     * Calculate refund amount for cancellation.
     */
    protected function calculateRefundAmount(Subscription $subscription, \DateTime $effectiveDate): float
    {
        if (!$subscription->service->prorated_billing) {
            return 0;
        }
        
        $lastBillingDate = $subscription->last_renewed_at ?? $subscription->starts_at;
        $nextBillingDate = $subscription->next_billing_date;
        
        if ($effectiveDate >= $nextBillingDate) {
            return 0; // No refund if cancelling after next billing
        }
        
        $unusedDays = $effectiveDate->diff($nextBillingDate)->days;
        $totalPeriodDays = $lastBillingDate->diff($nextBillingDate)->days;
        
        if ($totalPeriodDays <= 0) {
            return 0;
        }
        
        $refundPercentage = $unusedDays / $totalPeriodDays;
        return round($subscription->billing_amount * $refundPercentage, 2);
    }

    /**
     * Calculate early renewal discount based on days remaining.
     */
    protected function calculateEarlyRenewalDiscount(int $daysRemaining): float
    {
        // Example discount schedule - can be customized per service
        if ($daysRemaining >= 30) {
            return 10.0; // 10% discount for 30+ days early
        } elseif ($daysRemaining >= 15) {
            return 5.0;  // 5% discount for 15+ days early
        } elseif ($daysRemaining >= 7) {
            return 2.5;  // 2.5% discount for 7+ days early
        }
        
        return 0;
    }

    /**
     * Get full period days for billing interval.
     */
    protected function getFullPeriodDays(string $billingInterval): int
    {
        return match($billingInterval) {
            'monthly' => 30,
            'quarterly' => 90,
            'semi_annually' => 180,
            'yearly' => 365,
            default => 30,
        };
    }
}

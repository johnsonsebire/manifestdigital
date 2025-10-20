<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRenewalRequest;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Subscription;
use App\Notifications\SubscriptionRenewedNotification;
use App\Services\CurrencyService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SubscriptionRenewalController extends Controller
{
    protected SubscriptionService $subscriptionService;
    protected CurrencyService $currencyService;

    public function __construct(SubscriptionService $subscriptionService, CurrencyService $currencyService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->currencyService = $currencyService;
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display the renewal checkout page.
     * 
     * GET /subscriptions/{subscription}/renew
     */
    public function index(Subscription $subscription)
    {
        // Authorization: Only subscription owner can renew
        if ($subscription->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized to renew this subscription.');
        }

        // Load relationships
        $subscription->load('service', 'order');

        // Calculate renewal details
        $isEarlyRenewal = $subscription->expires_at->isFuture();
        $daysUntilExpiry = now()->diffInDays($subscription->expires_at, false);
        
        // Get renewal pricing
        $service = $subscription->service;
        $basePrice = (float) $service->price;
        $renewalPrice = $this->subscriptionService->calculateRenewalPrice($subscription);
        
        // Calculate early renewal discount if applicable (5% for renewals 30+ days early)
        $earlyRenewalDiscount = 0;
        if ($isEarlyRenewal && $daysUntilExpiry > 30) {
            $earlyRenewalDiscount = 5; // 5% discount
            $earlyRenewalPrice = $renewalPrice * 0.95;
        } else {
            $earlyRenewalPrice = $renewalPrice;
        }

        // Calculate new expiration date
        $newExpirationDate = $service->calculateExpirationDate($subscription->expires_at);
        
        // Service discount information
        $serviceDiscountPercentage = $service->renewal_discount_percentage ?? 0;
        $serviceDiscountAmount = $basePrice - $renewalPrice;

        // Get user's currency
        $userCurrency = $this->currencyService->getUserCurrency();

        return view('subscriptions.renew', [
            'subscription' => $subscription,
            'service' => $service,
            'isEarlyRenewal' => $isEarlyRenewal,
            'daysUntilExpiry' => $daysUntilExpiry,
            'basePrice' => $basePrice,
            'renewalPrice' => $renewalPrice,
            'earlyRenewalDiscount' => $earlyRenewalDiscount,
            'earlyRenewalPrice' => $earlyRenewalPrice,
            'finalPrice' => $earlyRenewalPrice,
            'newExpirationDate' => $newExpirationDate,
            'serviceDiscountPercentage' => $serviceDiscountPercentage,
            'serviceDiscountAmount' => $serviceDiscountAmount,
            'currencyService' => $this->currencyService,
            'userCurrency' => $userCurrency,
        ]);
    }

    /**
     * Process the renewal and create order.
     * 
     * POST /subscriptions/{subscription}/renew
     */
    public function store(Subscription $subscription, SubscriptionRenewalRequest $request)
    {
        // Authorization: Only subscription owner can renew
        if ($subscription->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized to renew this subscription.');
        }

        // Check if subscription is already being renewed (prevent double submission)
        if ($subscription->metadata['renewal_in_progress'] ?? false) {
            return redirect()->back()
                ->with('error', 'Renewal is already in progress for this subscription.');
        }

        try {
            DB::beginTransaction();

            // Mark renewal in progress
            $subscription->metadata = array_merge($subscription->metadata ?? [], [
                'renewal_in_progress' => true,
                'renewal_initiated_at' => now()->toISOString(),
            ]);
            $subscription->save();

            // Load service and customer
            $subscription->load('service', 'customer');
            $service = $subscription->service;
            $customer = $subscription->customer;

            // Calculate final price
            $isEarlyRenewal = $subscription->expires_at->isFuture();
            $daysUntilExpiry = now()->diffInDays($subscription->expires_at, false);
            
            $renewalPrice = $this->subscriptionService->calculateRenewalPrice($subscription);
            
            // Apply early renewal discount if applicable
            if ($isEarlyRenewal && $daysUntilExpiry > 30) {
                $finalPrice = $renewalPrice * 0.95; // 5% discount
                $earlyRenewalApplied = true;
            } else {
                $finalPrice = $renewalPrice;
                $earlyRenewalApplied = false;
            }

            // Create renewal order
            $order = Order::create([
                'uuid' => Str::uuid(),
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '',
                'customer_address' => $customer->address ?? '',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'subtotal' => $finalPrice,
                'tax' => 0,
                'discount' => 0,
                'total' => $finalPrice,
                'notes' => "Subscription renewal for: {$service->title}",
                'metadata' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'renewal_type' => 'subscription_renewal',
                    'subscription_id' => $subscription->id,
                    'subscription_uuid' => $subscription->uuid,
                    'is_early_renewal' => $isEarlyRenewal,
                    'early_renewal_discount_applied' => $earlyRenewalApplied,
                    'days_until_expiry' => $daysUntilExpiry,
                ],
                'placed_at' => now(),
            ]);

            // Create order item for the renewal
            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'variant_id' => null,
                'title' => $service->title . ' - Renewal',
                'quantity' => 1,
                'unit_price' => $finalPrice,
                'line_total' => $finalPrice,
                'metadata' => [
                    'type' => 'subscription_renewal',
                    'subscription_id' => $subscription->id,
                    'subscription_uuid' => $subscription->uuid,
                    'renewal_period' => $service->billing_interval,
                    'early_renewal_discount' => $earlyRenewalApplied ? 5 : 0,
                ],
            ]);

            // Create invoice for the renewal order
            $invoice = Invoice::createFromOrder($order, dueInDays: 30, taxRate: 0);

            DB::commit();

            // Store order UUID in session for payment processing
            session(['pending_renewal_order' => $order->uuid]);
            session(['pending_renewal_subscription' => $subscription->uuid]);

            // Log renewal initiation
            Log::info('Subscription renewal initiated', [
                'subscription_id' => $subscription->id,
                'subscription_uuid' => $subscription->uuid,
                'order_id' => $order->id,
                'order_uuid' => $order->uuid,
                'customer_id' => $customer->id,
                'final_price' => $finalPrice,
                'early_renewal' => $isEarlyRenewal,
            ]);

            // Redirect to payment page
            return redirect()->route('renewal.payment', $order->uuid)
                ->with('success', 'Renewal order created! Proceeding to payment...');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clear renewal in progress flag
            if (isset($subscription)) {
                $metadata = $subscription->metadata ?? [];
                unset($metadata['renewal_in_progress']);
                $subscription->metadata = $metadata;
                $subscription->save();
            }

            Log::error('Subscription renewal failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to process renewal. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Payment redirect page for renewal.
     * Shows auto-submitting form to POST to payment.initiate
     * 
     * GET /subscriptions/renew/payment/{uuid}
     */
    public function payment(string $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        // Verify this is the renewal order that was just created
        if (session('pending_renewal_order') !== $uuid) {
            abort(403, 'Invalid payment request');
        }

        // Authorization check
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized to process this payment.');
        }

        return view('subscriptions.payment', compact('order'));
    }

    /**
     * Renewal success/confirmation page.
     * Called after successful payment to complete the renewal.
     * 
     * GET /subscriptions/renew/success/{uuid}
     */
    public function success(string $uuid)
    {
        $order = Order::with(['items.service', 'customer'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Authorization check
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized to view this order.');
        }

        // Get subscription from order metadata
        $subscriptionUuid = $order->metadata['subscription_uuid'] ?? null;
        if (!$subscriptionUuid) {
            abort(404, 'Subscription not found for this renewal order.');
        }

        $subscription = Subscription::where('uuid', $subscriptionUuid)->firstOrFail();

        // If payment is confirmed and subscription not yet renewed, process the renewal
        if ($order->payment_status === 'paid' && !($subscription->metadata['renewal_completed'] ?? false)) {
            try {
                DB::beginTransaction();

                // Calculate renewal price from order
                $renewalPrice = $order->total;

                // Renew the subscription
                $this->subscriptionService->renewSubscription($subscription, [
                    'price' => $renewalPrice,
                    'metadata' => [
                        'renewal_order_id' => $order->id,
                        'renewal_order_uuid' => $order->uuid,
                        'payment_date' => now()->toISOString(),
                    ],
                ]);

                // Mark renewal as completed
                $subscription->metadata = array_merge($subscription->metadata ?? [], [
                    'renewal_completed' => true,
                    'renewal_completed_at' => now()->toISOString(),
                ]);
                unset($subscription->metadata['renewal_in_progress']);
                $subscription->save();

                // Send renewal confirmation notification
                $subscription->customer->notify(new SubscriptionRenewedNotification($subscription));

                DB::commit();

                Log::info('Subscription renewal completed', [
                    'subscription_id' => $subscription->id,
                    'order_id' => $order->id,
                    'new_expiration' => $subscription->expires_at,
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Failed to complete subscription renewal', [
                    'subscription_id' => $subscription->id,
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
                
                return redirect()->route('customer.subscriptions.show', $subscription)
                    ->with('error', 'Payment received but renewal failed. Please contact support.');
            }
        }

        return view('subscriptions.success', [
            'order' => $order,
            'subscription' => $subscription->fresh(),
        ]);
    }

    /**
     * Generate unique order number.
     */
    protected function generateOrderNumber(): string
    {
        $prefix = 'RNW'; // Renewal prefix
        $timestamp = now()->format('Ymd');
        $random = strtoupper(Str::random(6));
        
        return "{$prefix}-{$timestamp}-{$random}";
    }
}

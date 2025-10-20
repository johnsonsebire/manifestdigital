<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\ServiceVariant;
use App\Services\CartService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected SubscriptionService $subscriptionService;

    public function __construct(CartService $cartService, SubscriptionService $subscriptionService)
    {
        $this->cartService = $cartService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display checkout page
     * 
     * GET /checkout
     */
    public function index()
    {
        $cart = $this->cartService->getCartSummary();

        // Redirect if cart is empty
        if ($cart['count'] === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Validate prices before checkout
        $validation = $this->cartService->validatePrices();
        
        if (!$validation['valid']) {
            return redirect()->route('cart.index')
                ->with('warning', 'Some prices have changed. Please review your cart before proceeding.');
        }

        // Get user info if authenticated
        $user = auth()->user();

        return view('checkout.index', [
            'cart' => $cart,
            'user' => $user,
        ]);
    }

    /**
     * Process checkout and create order
     * 
     * POST /checkout
     * 
     * Uses CheckoutRequest which performs server-side price validation
     */
    public function store(CheckoutRequest $request)
    {
        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = $this->cartService->prepareForCheckout();

            // Create order
            $order = Order::create([
                'uuid' => Str::uuid(),
                'customer_id' => auth()->id(), // Null for guests
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'subtotal' => 0, // Will be calculated
                'tax' => 0,
                'discount' => 0,
                'total' => 0, // Will be calculated
                'notes' => $request->notes,
                'metadata' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
                'placed_at' => now(),
            ]);

            // Create order items with server-validated prices
            $subtotal = 0;
            foreach ($request->items as $item) {
                // Fetch service to get title
                $service = Service::find($item['service_id']);
                
                // Fetch variant name if variant_id exists
                $variantName = null;
                if (!empty($item['variant_id'])) {
                    $variant = ServiceVariant::find($item['variant_id']);
                    $variantName = $variant?->name;
                }

                // Prices already validated in CheckoutRequest
                $lineTotal = $item['price'] * $item['quantity'];
                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'title' => $service->title,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $lineTotal,
                    'metadata' => [
                        'variant_name' => $variantName,
                        'type' => $service->type,
                    ],
                ]);
            }

            // Calculate totals
            $tax = $subtotal * 0; // TODO: Implement tax calculation
            $total = $subtotal + $tax;

            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);

            // Automatically create invoice for the order
            $invoice = Invoice::createFromOrder($order, dueInDays: 30, taxRate: 0);

            // Create subscriptions for subscription-type services
            $this->createSubscriptionsForOrder($order);

            DB::commit();

            // Clear cart after successful order
            $this->cartService->clear();

            // Fire OrderPlaced event
            event(new \App\Events\OrderPlaced($order));

            // Store order UUID in session for payment form
            session(['pending_payment_order' => $order->uuid]);

            // Redirect to payment page (will auto-submit POST form)
            return redirect()->route('checkout.payment', $order->uuid)
                ->with('success', 'Order placed successfully! Proceeding to payment...');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the full error for debugging
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to process order. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Payment redirect page
     * Shows auto-submitting form to POST to payment.initiate
     * 
     * GET /checkout/payment/{uuid}
     */
    public function payment(string $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        // Verify this is the order that was just created
        if (session('pending_payment_order') !== $uuid) {
            abort(403, 'Invalid payment request');
        }

        return view('checkout.payment', compact('order'));
    }

    /**
     * Order confirmation page
     * 
     * GET /checkout/success/{uuid}
     */
    public function success(string $uuid)
    {
        $order = Order::with(['items.service', 'items.variant'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Authorization: Only order owner or staff can view
        if (auth()->guest()) {
            // For guests, allow access (they just created it)
            // In production, you might want to add session-based verification
        } elseif (auth()->id() !== $order->customer_id) {
            // Authenticated but not order owner - check if staff
            if (!auth()->user()->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
                abort(403, 'Unauthorized to view this order.');
            }
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Create subscriptions for subscription-type services in the order.
     */
    protected function createSubscriptionsForOrder(Order $order): void
    {
        // Load order items with services
        $order->load(['items.service', 'customer']);

        foreach ($order->items as $orderItem) {
            $service = $orderItem->service;

            // Skip if not a subscription service
            if (!$service->requiresSubscriptionManagement()) {
                continue;
            }

            // Create a subscription for each quantity (multiple subscriptions for same service if quantity > 1)
            for ($i = 0; $i < $orderItem->quantity; $i++) {
                try {
                    $subscription = $this->subscriptionService->createSubscription(
                        $order,
                        $service,
                        $order->customer ?: $this->createGuestCustomer($order),
                        [
                            'start_date' => now(),
                            'auto_renew' => $service->auto_renew_enabled,
                            'metadata' => [
                                'order_item_id' => $orderItem->id,
                                'quantity_instance' => $i + 1,
                                'variant_id' => $orderItem->variant_id,
                                'variant_name' => $orderItem->metadata['variant_name'] ?? null,
                                'unit_price' => $orderItem->unit_price,
                                'created_from_checkout' => true,
                            ],
                        ]
                    );

                    Log::info('Subscription created from order', [
                        'order_id' => $order->id,
                        'order_uuid' => $order->uuid,
                        'service_id' => $service->id,
                        'subscription_id' => $subscription->id,
                        'subscription_uuid' => $subscription->uuid,
                        'quantity_instance' => $i + 1,
                    ]);

                } catch (\Exception $e) {
                    Log::error('Failed to create subscription from order', [
                        'order_id' => $order->id,
                        'service_id' => $service->id,
                        'error' => $e->getMessage(),
                        'quantity_instance' => $i + 1,
                    ]);
                    
                    // Don't fail the entire order for subscription creation errors
                    // Just log and continue - admin can manually create subscriptions
                }
            }
        }
    }

    /**
     * Create a temporary customer record for guest orders with subscriptions.
     */
    protected function createGuestCustomer(Order $order): \App\Models\User
    {
        // For guest orders that include subscriptions, we need to create a customer account
        // This ensures the subscription system can send reminders and manage renewals
        
        $existingUser = \App\Models\User::where('email', $order->customer_email)->first();
        
        if ($existingUser) {
            // Update order to link to existing customer
            $order->update(['customer_id' => $existingUser->id]);
            return $existingUser;
        }

        // Create new customer account for guest
        $customer = \App\Models\User::create([
            'name' => $order->customer_name,
            'email' => $order->customer_email,
            'phone' => $order->customer_phone,
            'address' => $order->customer_address,
            'email_verified_at' => null, // They need to verify their email
            'password' => bcrypt(Str::random(32)), // Temporary password
            'created_from_guest_order' => true,
        ]);

        // Assign customer role
        $customer->assignRole('Customer');

        // Update order to link to new customer
        $order->update(['customer_id' => $customer->id]);

        // Send welcome email with account setup instructions
        $customer->notify(new \App\Notifications\GuestAccountCreatedNotification($order));

        Log::info('Guest customer account created for subscription order', [
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'customer_email' => $customer->email,
        ]);

        return $customer;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
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
                // Prices already validated in CheckoutRequest
                $lineTotal = $item['price'] * $item['quantity'];
                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $lineTotal,
                    'snapshot' => [
                        'service_title' => $item['service_title'] ?? null,
                        'variant_name' => $item['variant_name'] ?? null,
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

            DB::commit();

            // Clear cart after successful order
            $this->cartService->clear();

            // Fire OrderPlaced event
            event(new \App\Events\OrderPlaced($order));

            // Redirect to payment initialization
            return redirect()->route('payment.initiate', $order->uuid)
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
}

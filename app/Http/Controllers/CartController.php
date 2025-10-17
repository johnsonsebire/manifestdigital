<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page
     * 
     * GET /cart
     */
    public function index()
    {
        $cart = $this->cartService->getCartSummary();
        
        // Validate prices before showing cart
        $validation = $this->cartService->validatePrices();
        
        return view('cart.index', [
            'cart' => $cart,
            'validation' => $validation,
        ]);
    }

    /**
     * Add item to cart (AJAX)
     * 
     * POST /cart/add
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'variant_id' => ['nullable', 'integer', 'exists:service_variants,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $result = $this->cartService->addItem(
            $validated['service_id'],
            $validated['variant_id'] ?? null,
            $validated['quantity']
        );

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Update cart item quantity (AJAX)
     * 
     * PATCH /cart/update/{cartKey}
     */
    public function update(Request $request, string $cartKey)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $result = $this->cartService->updateQuantity($cartKey, $validated['quantity']);

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Remove item from cart (AJAX)
     * 
     * DELETE /cart/remove/{cartKey}
     */
    public function remove(Request $request, string $cartKey)
    {
        $result = $this->cartService->removeItem($cartKey);

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Clear entire cart
     * 
     * POST /cart/clear
     */
    public function clear(Request $request)
    {
        $this->cartService->clear();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'cart' => $this->cartService->getCartSummary(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }

    /**
     * Get cart summary (AJAX for navbar cart widget)
     * 
     * GET /cart/summary
     */
    public function summary()
    {
        return response()->json($this->cartService->getCartSummary());
    }
}

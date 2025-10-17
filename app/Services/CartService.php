<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServiceVariant;
use Illuminate\Support\Facades\Session;

/**
 * Cart Service - Manages shopping cart operations
 * 
 * Supports both session-based cart (for guests) and database cart (for authenticated users)
 * All prices are validated server-side before adding to cart
 */
class CartService
{
    protected string $sessionKey = 'shopping_cart';

    /**
     * Get all items in the cart
     * 
     * @return array
     */
    public function getItems(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Get cart item count
     * 
     * @return int
     */
    public function getCount(): int
    {
        $items = $this->getItems();
        return array_sum(array_column($items, 'quantity'));
    }

    /**
     * Get cart subtotal (sum of all line totals)
     * 
     * @return float
     */
    public function getSubtotal(): float
    {
        $items = $this->getItems();
        return array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $items));
    }

    /**
     * Add item to cart with server-side price validation
     * 
     * @param int $serviceId
     * @param int|null $variantId
     * @param int $quantity
     * @return array ['success' => bool, 'message' => string, 'cart' => array]
     */
    public function addItem(int $serviceId, ?int $variantId = null, int $quantity = 1): array
    {
        // Validate service exists and is available
        $service = Service::where('id', $serviceId)
            ->where('is_available', true)
            ->first();

        if (!$service) {
            return [
                'success' => false,
                'message' => 'Service not found or unavailable.',
                'cart' => $this->getCartSummary(),
            ];
        }

        // Get server-side price (NEVER trust client)
        $price = $service->sale_price ?? $service->base_price;
        $variantName = null;
        $variant = null;

        // If variant specified, validate and get variant price
        if ($variantId) {
            $variant = ServiceVariant::where('id', $variantId)
                ->where('service_id', $serviceId)
                ->where('is_available', true)
                ->first();

            if (!$variant) {
                return [
                    'success' => false,
                    'message' => 'Service variant not found or unavailable.',
                    'cart' => $this->getCartSummary(),
                ];
            }

            $price = $variant->sale_price ?? $variant->price;
            $variantName = $variant->name;
        }

        // Create cart item key (unique per service+variant combination)
        $cartKey = $variantId ? "s{$serviceId}_v{$variantId}" : "s{$serviceId}";

        // Get current cart
        $cart = $this->getItems();

        // Check if item already in cart
        if (isset($cart[$cartKey])) {
            // Update quantity
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            // Add new item
            $cart[$cartKey] = [
                'service_id' => $serviceId,
                'service_title' => $service->title,
                'service_slug' => $service->slug,
                'variant_id' => $variantId,
                'variant_name' => $variantName,
                'price' => (float) $price, // Server-side price
                'quantity' => $quantity,
                'image_url' => $service->image_url,
            ];
        }

        // Save to session
        Session::put($this->sessionKey, $cart);

        return [
            'success' => true,
            'message' => 'Item added to cart successfully.',
            'cart' => $this->getCartSummary(),
        ];
    }

    /**
     * Update item quantity in cart
     * 
     * @param string $cartKey
     * @param int $quantity
     * @return array
     */
    public function updateQuantity(string $cartKey, int $quantity): array
    {
        $cart = $this->getItems();

        if (!isset($cart[$cartKey])) {
            return [
                'success' => false,
                'message' => 'Item not found in cart.',
                'cart' => $this->getCartSummary(),
            ];
        }

        if ($quantity <= 0) {
            return $this->removeItem($cartKey);
        }

        $cart[$cartKey]['quantity'] = $quantity;
        Session::put($this->sessionKey, $cart);

        return [
            'success' => true,
            'message' => 'Cart updated successfully.',
            'cart' => $this->getCartSummary(),
        ];
    }

    /**
     * Remove item from cart
     * 
     * @param string $cartKey
     * @return array
     */
    public function removeItem(string $cartKey): array
    {
        $cart = $this->getItems();

        if (!isset($cart[$cartKey])) {
            return [
                'success' => false,
                'message' => 'Item not found in cart.',
                'cart' => $this->getCartSummary(),
            ];
        }

        unset($cart[$cartKey]);
        Session::put($this->sessionKey, $cart);

        return [
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart' => $this->getCartSummary(),
        ];
    }

    /**
     * Clear all items from cart
     * 
     * @return void
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    /**
     * Get cart summary (count, subtotal, items)
     * 
     * @return array
     */
    public function getCartSummary(): array
    {
        $items = $this->getItems();
        $count = $this->getCount();
        $subtotal = $this->getSubtotal();

        return [
            'items' => array_values($items), // Re-index for JSON
            'count' => $count,
            'subtotal' => $subtotal,
            'formatted_subtotal' => '$' . number_format($subtotal, 2),
        ];
    }

    /**
     * Validate cart items against current database prices
     * 
     * Returns array of items with price mismatches
     * Should be called before checkout
     * 
     * @return array ['valid' => bool, 'errors' => array, 'updated_items' => array]
     */
    public function validatePrices(): array
    {
        $cart = $this->getItems();
        $errors = [];
        $updatedItems = [];
        $hasChanges = false;

        foreach ($cart as $cartKey => $item) {
            // Fetch current service
            $service = Service::find($item['service_id']);
            
            if (!$service || !$service->is_available) {
                $errors[] = "{$item['service_title']} is no longer available.";
                unset($cart[$cartKey]);
                $hasChanges = true;
                continue;
            }

            // Get current price
            $currentPrice = $service->sale_price ?? $service->base_price;

            // Check variant if applicable
            if ($item['variant_id']) {
                $variant = ServiceVariant::where('id', $item['variant_id'])
                    ->where('is_available', true)
                    ->first();

                if (!$variant) {
                    $errors[] = "{$item['service_title']} - {$item['variant_name']} is no longer available.";
                    unset($cart[$cartKey]);
                    $hasChanges = true;
                    continue;
                }

                $currentPrice = $variant->sale_price ?? $variant->price;
            }

            // Compare prices (allow small floating point tolerance)
            if (abs($currentPrice - $item['price']) > 0.01) {
                $errors[] = "Price for {$item['service_title']} has changed from \${$item['price']} to \${$currentPrice}.";
                $cart[$cartKey]['price'] = (float) $currentPrice;
                $updatedItems[] = $cart[$cartKey];
                $hasChanges = true;
            }
        }

        // Update cart if changes detected
        if ($hasChanges) {
            Session::put($this->sessionKey, $cart);
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'updated_items' => $updatedItems,
        ];
    }

    /**
     * Prepare cart data for checkout/order creation
     * 
     * @return array
     */
    public function prepareForCheckout(): array
    {
        $items = $this->getItems();
        $checkoutItems = [];

        foreach ($items as $item) {
            $checkoutItems[] = [
                'service_id' => $item['service_id'],
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        return $checkoutItems;
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Models\ServiceVariant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can checkout (guests and authenticated users)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Customer Information (required for guests)
            'customer_name' => ['required_without:user_id', 'string', 'max:255'],
            'customer_email' => ['required_without:user_id', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            
            // Order Items - CRITICAL: Never trust client prices
            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['required', 'exists:services,id'],
            'items.*.variant_id' => ['nullable', 'exists:service_variants,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:100'],
            
            // Client-provided prices (will be recalculated server-side for security)
            'items.*.price' => ['required', 'numeric', 'min:0'],
            
            // Additional details
            'items.*.custom_requirements' => ['nullable', 'string', 'max:2000'],
            
            // Billing/Shipping Info
            'billing_address' => ['nullable', 'string', 'max:500'],
            'billing_city' => ['nullable', 'string', 'max:100'],
            'billing_state' => ['nullable', 'string', 'max:100'],
            'billing_country' => ['nullable', 'string', 'max:100'],
            'billing_zip' => ['nullable', 'string', 'max:20'],
            
            // Order Notes
            'notes' => ['nullable', 'string', 'max:2000'],
            
            // Payment method selection
            'payment_method' => ['required', 'string', Rule::in(['paystack', 'stripe', 'paypal', 'bank_transfer'])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customer_name.required_without' => 'Your name is required.',
            'customer_email.required_without' => 'Your email is required.',
            'customer_email.email' => 'Please provide a valid email address.',
            'items.required' => 'Your cart is empty.',
            'items.min' => 'Your cart must contain at least one item.',
            'items.*.service_id.required' => 'Service selection is required.',
            'items.*.service_id.exists' => 'Selected service does not exist.',
            'items.*.variant_id.exists' => 'Selected variant does not exist.',
            'items.*.quantity.required' => 'Quantity is required.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.price.required' => 'Price information is missing.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'Invalid payment method selected.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validatePricesServerSide($validator);
            $this->validateServiceAvailability($validator);
        });
    }

    /**
     * CRITICAL: Validate prices server-side - never trust client input
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validatePricesServerSide($validator)
    {
        foreach ($this->items ?? [] as $index => $item) {
            $service = Service::find($item['service_id']);
            
            if (!$service) {
                continue; // Already validated by exists rule
            }

            // Get actual price from database
            $actualPrice = $service->sale_price ?? $service->base_price;

            // If variant specified, use variant price
            if (!empty($item['variant_id'])) {
                $variant = ServiceVariant::find($item['variant_id']);
                if ($variant && $variant->service_id === $service->id) {
                    $actualPrice = $variant->price;
                }
            }

            // Compare with client-provided price (allow 0.01 tolerance for floating point)
            $clientPrice = (float) $item['price'];
            if (abs($clientPrice - $actualPrice) > 0.01) {
                $validator->errors()->add(
                    "items.{$index}.price",
                    "Price mismatch detected. Expected: {$actualPrice}, Got: {$clientPrice}. Please refresh and try again."
                );
            }
        }
    }

    /**
     * Validate that all services are available for purchase
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateServiceAvailability($validator)
    {
        foreach ($this->items ?? [] as $index => $item) {
            $service = Service::find($item['service_id']);
            
            if ($service && !$service->is_available) {
                $validator->errors()->add(
                    "items.{$index}.service_id",
                    "The service '{$service->title}' is currently unavailable."
                );
            }

            // Validate variant availability if specified
            if (!empty($item['variant_id'])) {
                $variant = ServiceVariant::find($item['variant_id']);
                if ($variant && !$variant->is_available) {
                    $validator->errors()->add(
                        "items.{$index}.variant_id",
                        "The selected variant is currently unavailable."
                    );
                }
            }
        }
    }
}

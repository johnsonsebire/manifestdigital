<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $order = $this->route('order');
        return $this->user()->can('requestChanges', $order);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'change_type' => ['required', Rule::in(['upgrade', 'downgrade', 'modification', 'addition', 'removal'])],
            'reason' => ['required', 'string', 'max:1000'],
            'requested_changes' => ['required', 'string', 'max:5000'],
            
            // New items or modifications
            'new_items' => ['nullable', 'array'],
            'new_items.*.service_id' => ['required', 'exists:services,id'],
            'new_items.*.variant_id' => ['nullable', 'exists:service_variants,id'],
            'new_items.*.quantity' => ['required', 'integer', 'min:1'],
            'new_items.*.price' => ['required', 'numeric', 'min:0'],
            
            // Items to remove
            'remove_items' => ['nullable', 'array'],
            'remove_items.*' => ['exists:order_items,id'],
            
            // Price adjustment
            'price_adjustment' => ['nullable', 'numeric'],
            
            'metadata' => ['nullable', 'array'],
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
            'order_id.required' => 'Order is required.',
            'order_id.exists' => 'Selected order does not exist.',
            'change_type.required' => 'Change type is required.',
            'change_type.in' => 'Invalid change type.',
            'reason.required' => 'Reason for change is required.',
            'requested_changes.required' => 'Please describe the requested changes.',
            'new_items.*.service_id.required' => 'Service selection is required for new items.',
            'new_items.*.service_id.exists' => 'Selected service does not exist.',
            'new_items.*.price.required' => 'Price is required for new items.',
            'remove_items.*.exists' => 'Selected item does not exist.',
        ];
    }

    /**
     * Configure the validator instance - validate prices server-side
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate new item prices server-side
            if ($this->has('new_items')) {
                foreach ($this->new_items as $index => $item) {
                    $service = \App\Models\Service::find($item['service_id']);
                    
                    if ($service) {
                        $actualPrice = $service->sale_price ?? $service->base_price;
                        
                        if (!empty($item['variant_id'])) {
                            $variant = \App\Models\ServiceVariant::find($item['variant_id']);
                            if ($variant && $variant->service_id === $service->id) {
                                $actualPrice = $variant->price;
                            }
                        }
                        
                        $clientPrice = (float) $item['price'];
                        if (abs($clientPrice - $actualPrice) > 0.01) {
                            $validator->errors()->add(
                                "new_items.{$index}.price",
                                "Price mismatch detected. Expected: {$actualPrice}, Got: {$clientPrice}."
                            );
                        }
                    }
                }
            }
        });
    }
}

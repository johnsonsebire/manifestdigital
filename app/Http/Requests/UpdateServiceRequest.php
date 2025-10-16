<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('service'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $serviceId = $this->route('service')->id ?? $this->route('service');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($serviceId),
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
            ],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'type' => ['required', Rule::in(['package', 'subscription', 'custom', 'one_time', 'ai_enhanced', 'consulting', 'add_on'])],
            
            // Pricing - server-side validation critical
            'base_price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99', 'lt:base_price'],
            
            'is_visible' => ['boolean'],
            'is_available' => ['boolean'],
            'is_featured' => ['boolean'],
            
            'metadata' => ['nullable', 'array'],
            'features' => ['nullable', 'array'],
            'requirements' => ['nullable', 'array'],
            'deliverables' => ['nullable', 'array'],
            
            // Categories (many-to-many)
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            
            // Variants
            'variants' => ['nullable', 'array'],
            'variants.*.id' => ['nullable', 'exists:service_variants,id'],
            'variants.*.name' => ['required', 'string', 'max:255'],
            'variants.*.price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'variants.*.features' => ['nullable', 'array'],
            'variants.*.is_available' => ['boolean'],
            
            'estimated_delivery_days' => ['nullable', 'integer', 'min:1'],
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
            'title.required' => 'Service title is required.',
            'slug.unique' => 'This slug is already taken.',
            'slug.regex' => 'Slug must be lowercase letters, numbers, and hyphens only.',
            'type.required' => 'Service type is required.',
            'type.in' => 'Invalid service type selected.',
            'base_price.required' => 'Base price is required.',
            'base_price.numeric' => 'Base price must be a valid number.',
            'base_price.min' => 'Base price cannot be negative.',
            'sale_price.lt' => 'Sale price must be less than base price.',
            'categories.*.exists' => 'One or more selected categories do not exist.',
            'variants.*.name.required' => 'Variant name is required.',
            'variants.*.price.required' => 'Variant price is required.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure prices are properly formatted as decimals
        if ($this->has('base_price')) {
            $this->merge([
                'base_price' => number_format((float) $this->base_price, 2, '.', ''),
            ]);
        }

        if ($this->has('sale_price') && $this->sale_price) {
            $this->merge([
                'sale_price' => number_format((float) $this->sale_price, 2, '.', ''),
            ]);
        }
    }
}

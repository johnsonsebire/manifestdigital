<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecordPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $order = $this->route('order');
        return $order && $this->user()->can('markAsPaid', $order);
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
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999.99'],
            'payment_method' => ['required', 'string', Rule::in(['paystack', 'stripe', 'paypal', 'bank_transfer', 'cash', 'check', 'other'])],
            'transaction_reference' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['initiated', 'succeeded', 'failed', 'refunded'])],
            'notes' => ['nullable', 'string', 'max:1000'],
            'paid_at' => ['nullable', 'date', 'before_or_equal:now'],
            'gateway_response' => ['nullable', 'array'],
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
            'amount.required' => 'Payment amount is required.',
            'amount.min' => 'Amount must be at least 0.01.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Invalid payment method.',
            'status.required' => 'Payment status is required.',
            'status.in' => 'Invalid payment status.',
            'paid_at.before_or_equal' => 'Payment date cannot be in the future.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure amount is properly formatted as decimal
        if ($this->has('amount')) {
            $this->merge([
                'amount' => number_format((float) $this->amount, 2, '.', ''),
            ]);
        }

        // Default paid_at to now if not provided
        if (!$this->has('paid_at')) {
            $this->merge([
                'paid_at' => now(),
            ]);
        }
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
            // Validate payment amount doesn't exceed order total
            $order = \App\Models\Order::find($this->order_id);
            if ($order) {
                $totalPaid = $order->payments()->where('status', 'succeeded')->sum('amount');
                $remainingBalance = $order->total_amount - $totalPaid;
                
                if ($this->amount > $remainingBalance + 0.01) { // Allow small tolerance
                    $validator->errors()->add(
                        'amount',
                        "Payment amount exceeds remaining balance of {$remainingBalance}."
                    );
                }
            }
        });
    }
}

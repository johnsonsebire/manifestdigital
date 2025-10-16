<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('order'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::in(['pending', 'initiated', 'paid', 'processing', 'completed', 'cancelled', 'refunded'])],
            'payment_status' => ['nullable', Rule::in(['unpaid', 'pending', 'paid', 'partial', 'refunded'])],
            'notes' => ['nullable', 'string', 'max:2000'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
            'metadata' => ['nullable', 'array'],
            'assigned_project_id' => ['nullable', 'exists:projects,id'],
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
            'status.in' => 'Invalid order status.',
            'payment_status.in' => 'Invalid payment status.',
            'assigned_project_id.exists' => 'Selected project does not exist.',
        ];
    }
}

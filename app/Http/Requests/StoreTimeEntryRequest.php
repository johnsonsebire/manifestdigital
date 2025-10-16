<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = \App\Models\Task::find($this->task_id);
        return $task && $this->user()->can('logTime', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'description' => ['required', 'string', 'max:500'],
            'hours' => ['required', 'numeric', 'min:0.01', 'max:24'],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'is_billable' => ['boolean'],
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
            'task_id.required' => 'Task is required.',
            'task_id.exists' => 'Selected task does not exist.',
            'description.required' => 'Description is required.',
            'hours.required' => 'Hours worked is required.',
            'hours.min' => 'Hours must be at least 0.01.',
            'hours.max' => 'Hours cannot exceed 24 in a single entry.',
            'date.required' => 'Date is required.',
            'date.before_or_equal' => 'Date cannot be in the future.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure hours are properly formatted as decimals
        if ($this->has('hours')) {
            $this->merge([
                'hours' => number_format((float) $this->hours, 2, '.', ''),
            ]);
        }
    }
}

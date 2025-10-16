<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Task::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assignee_id' => ['nullable', 'exists:users,id'],
            'milestone_id' => ['nullable', 'exists:milestones,id'],
            'status' => ['nullable', Rule::in(['todo', 'in_progress', 'review', 'done', 'blocked'])],
            'priority' => ['nullable', 'integer', 'min:0', 'max:3'], // 0=low, 1=medium, 2=high, 3=urgent
            'due_date' => ['nullable', 'date'],
            'estimated_hours' => ['nullable', 'numeric', 'min:0', 'max:9999.99'],
            'metadata' => ['nullable', 'array'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
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
            'project_id.required' => 'Project is required.',
            'project_id.exists' => 'Selected project does not exist.',
            'title.required' => 'Task title is required.',
            'assignee_id.exists' => 'Selected assignee does not exist.',
            'milestone_id.exists' => 'Selected milestone does not exist.',
            'status.in' => 'Invalid task status.',
            'priority.min' => 'Invalid priority value.',
            'priority.max' => 'Invalid priority value.',
        ];
    }
}

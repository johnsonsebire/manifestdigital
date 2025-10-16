<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(['planning', 'active', 'on_hold', 'completed', 'cancelled'])],
            'visibility' => ['nullable', Rule::in(['private', 'client', 'public'])],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'completed_at' => ['nullable', 'date'],
            'budget' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'metadata' => ['nullable', 'array'],
            
            // Team assignments (if updating team)
            'team' => ['nullable', 'array'],
            'team.*.user_id' => ['required', 'exists:users,id'],
            'team.*.role' => ['required', 'string', Rule::in(['manager', 'developer', 'designer', 'qa', 'contributor'])],
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
            'title.required' => 'Project title is required.',
            'status.in' => 'Invalid project status.',
            'visibility.in' => 'Invalid visibility setting.',
            'due_date.after_or_equal' => 'Due date must be on or after start date.',
            'team.*.user_id.required' => 'Team member is required.',
            'team.*.user_id.exists' => 'Selected team member does not exist.',
            'team.*.role.required' => 'Team member role is required.',
            'team.*.role.in' => 'Invalid team member role.',
        ];
    }
}

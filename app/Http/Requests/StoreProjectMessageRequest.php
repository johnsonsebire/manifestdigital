<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\ProjectMessage::class);
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
            'message' => ['required', 'string', 'max:10000'],
            'is_internal' => ['boolean'],
            'metadata' => ['nullable', 'array'],
            
            // File attachments
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['file', 'max:10240'], // 10MB max per file
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
            'message.required' => 'Message content is required.',
            'message.max' => 'Message cannot exceed 10,000 characters.',
            'attachments.max' => 'You can attach a maximum of 10 files.',
            'attachments.*.file' => 'Invalid file uploaded.',
            'attachments.*.max' => 'File size cannot exceed 10MB.',
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
            // Validate internal message permission
            if ($this->is_internal) {
                $project = \App\Models\Project::find($this->project_id);
                if ($project && !$this->user()->can('viewInternalContent', $project)) {
                    $validator->errors()->add('is_internal', 'You do not have permission to create internal messages.');
                }
            }
        });
    }
}

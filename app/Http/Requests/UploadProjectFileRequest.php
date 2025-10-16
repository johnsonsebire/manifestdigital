<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadProjectFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\ProjectFile::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Polymorphic relationship
            'model_type' => ['required', Rule::in(['App\Models\Project', 'App\Models\Task', 'App\Models\ProjectMessage'])],
            'model_id' => ['required', 'integer'],
            
            // File upload - CRITICAL: Validate file types for security
            'file' => [
                'required',
                'file',
                'max:20480', // 20MB max
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,7z',
            ],
            
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
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
            'model_type.required' => 'File context is required.',
            'model_type.in' => 'Invalid file context.',
            'model_id.required' => 'File context ID is required.',
            'file.required' => 'Please select a file to upload.',
            'file.file' => 'Invalid file uploaded.',
            'file.max' => 'File size cannot exceed 20MB.',
            'file.mimes' => 'File type not allowed. Allowed types: jpg, jpeg, png, pdf, doc, docx, xls, xlsx, ppt, pptx, txt, zip, rar, 7z.',
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
            // Validate that the model exists and user has access
            $modelClass = $this->model_type;
            if (class_exists($modelClass)) {
                $model = $modelClass::find($this->model_id);
                if (!$model) {
                    $validator->errors()->add('model_id', 'The specified item does not exist.');
                } elseif (method_exists($model, 'getKey') && !$this->user()->can('view', $model)) {
                    $validator->errors()->add('model_id', 'You do not have permission to upload files to this item.');
                }
            }
        });
    }
}

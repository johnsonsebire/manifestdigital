<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('category'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')->id ?? $this->route('category');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categoryId),
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::notIn([$categoryId]) // Cannot be its own parent
            ],
            'is_visible' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'metadata' => ['nullable', 'array'],
            'icon' => ['nullable', 'string', 'max:100'],
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
            'title.required' => 'Category title is required.',
            'slug.unique' => 'This slug is already taken.',
            'slug.regex' => 'Slug must be lowercase letters, numbers, and hyphens only.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'parent_id.not_in' => 'A category cannot be its own parent.',
        ];
    }
}

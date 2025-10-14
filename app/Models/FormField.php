<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'form_id',
        'name',
        'type',
        'label',
        'options',
        'placeholder',
        'help_text',
        'is_required',
        'is_unique',
        'order',
        'validation_rules',
        'attributes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_required' => 'boolean',
        'is_unique' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
        'attributes' => 'array',
    ];

    /**
     * Get the form that owns the field.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the validation rules for this field.
     */
    public function getValidationRules(): array
    {
        $rules = [];

        // Basic required rule
        if ($this->is_required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        // Type-specific rules
        switch ($this->type) {
            case 'email':
                $rules[] = 'email';
                break;
            case 'number':
                $rules[] = 'numeric';
                break;
            case 'date':
                $rules[] = 'date';
                break;
            case 'file':
                $rules[] = 'file';
                // Add file validation rules as needed
                break;
            case 'url':
                $rules[] = 'url';
                break;
            case 'phone':
                $rules[] = 'regex:/^[0-9\+\-\(\)\s]{5,20}$/';
                break;
        }

        // Add unique check if required
        if ($this->is_unique) {
            $rules[] = function ($attribute, $value, $fail) {
                $form = $this->form;
                $submissions = FormSubmission::where('form_id', $form->id)
                    ->get()
                    ->filter(function ($submission) use ($attribute, $value) {
                        $data = $submission->data;
                        return isset($data[$attribute]) && $data[$attribute] == $value;
                    });

                if ($submissions->count() > 0) {
                    $fail("The {$attribute} has already been used in a previous submission.");
                }
            };
        }

        // Add custom validation rules if defined
        if (!empty($this->validation_rules)) {
            $rules = array_merge($rules, $this->validation_rules);
        }

        return $rules;
    }

    /**
     * Get available field types.
     */
    public static function availableTypes(): array
    {
        return [
            'text' => 'Text Input',
            'textarea' => 'Text Area',
            'email' => 'Email Input',
            'number' => 'Number Input',
            'select' => 'Dropdown Select',
            'checkbox' => 'Checkbox',
            'radio' => 'Radio Button',
            'date' => 'Date Picker',
            'file' => 'File Upload',
            'hidden' => 'Hidden Field',
            'phone' => 'Phone Number',
            'url' => 'URL Input',
        ];
    }
}

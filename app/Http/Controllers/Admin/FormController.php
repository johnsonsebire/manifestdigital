<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-forms');
        
        $forms = Form::withCount('submissions')->latest()->paginate(10);
        
        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create-forms');
        
        $fieldTypes = FormField::availableTypes();
        
        return view('admin.forms.create', compact('fieldTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-forms');
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:forms,slug',
            'description' => 'nullable|string',
            'success_message' => 'nullable|string',
            'submit_button_text' => 'nullable|string|max:255',
            'store_submissions' => 'boolean',
            'send_notifications' => 'boolean',
            'notification_email' => 'nullable|required_if:send_notifications,1|email',
            'is_active' => 'boolean',
            'requires_login' => 'boolean',
            'recaptcha_status' => 'string|in:disabled,v2,v3',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Debug what's coming in from the form
        Log::info('Form submission data:', $request->all());
        
        // Create the form
        $form = Form::create([
            'name' => $request->name,
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'success_message' => $request->success_message ?? 'Thank you for your submission!',
            'submit_button_text' => $request->submit_button_text ?? 'Submit',
            'store_submissions' => $request->store_submissions ?? true,
            'send_notifications' => $request->send_notifications ?? false,
            'notification_email' => $request->notification_email,
            'is_active' => $request->is_active ?? true,
            'requires_login' => $request->requires_login ?? false,
            'recaptcha_status' => $request->recaptcha_status ?? 'disabled',
            'shortcode' => $request->shortcode ?? 'form_' . Str::random(8),
        ]);
        
        // Process form fields if submitted
        if ($request->has('fields')) {
            $this->processFormFields($form, $request->fields);
        }
        
        return redirect()->route('admin.forms.edit', $form)
            ->with('success', 'Form created successfully. Now add fields to your form.');
    }
    
    /**
     * Process and save form fields.
     */
    private function processFormFields(Form $form, array $fields)
    {
        $order = 1;
        foreach ($fields as $fieldData) {
            $form->fields()->create([
                'name' => $fieldData['name'] ?? Str::slug($fieldData['label'], '_'),
                'type' => $fieldData['type'],
                'label' => $fieldData['label'],
                'options' => $fieldData['options'] ?? null,
                'placeholder' => $fieldData['placeholder'] ?? null,
                'help_text' => $fieldData['help_text'] ?? null,
                'is_required' => $fieldData['is_required'] ?? false,
                'is_unique' => $fieldData['is_unique'] ?? false,
                'order' => $order++,
                'validation_rules' => $fieldData['validation_rules'] ?? null,
                'attributes' => $fieldData['attributes'] ?? null,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view-forms');
        
        $form = Form::with('fields')->findOrFail($id);
        
        return view('admin.forms.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('edit-forms');
        
        $form = Form::with('fields')->findOrFail($id);
        $fieldTypes = FormField::availableTypes();
        
        return view('admin.forms.edit', compact('form', 'fieldTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('edit-forms');
        
        $form = Form::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:forms,slug,' . $form->id,
            'description' => 'nullable|string',
            'success_message' => 'nullable|string',
            'submit_button_text' => 'nullable|string|max:255',
            'store_submissions' => 'boolean',
            'send_notifications' => 'boolean',
            'notification_email' => 'nullable|required_if:send_notifications,1|email',
            'is_active' => 'boolean',
            'requires_login' => 'boolean',
            'recaptcha_status' => 'string|in:disabled,v2,v3',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update the form
        $form->update([
            'name' => $request->name,
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'success_message' => $request->success_message ?? 'Thank you for your submission!',
            'submit_button_text' => $request->submit_button_text ?? 'Submit',
            'store_submissions' => $request->store_submissions ?? true,
            'send_notifications' => $request->send_notifications ?? false,
            'notification_email' => $request->notification_email,
            'is_active' => $request->is_active ?? true,
            'requires_login' => $request->requires_login ?? false,
            'recaptcha_status' => $request->recaptcha_status ?? 'disabled',
        ]);
        
        // Update fields if needed
        if ($request->has('update_fields') && $request->update_fields) {
            // Delete existing fields if replacing them
            if ($request->has('replace_fields') && $request->replace_fields) {
                $form->fields()->delete();
            }
            
            // Process form fields
            if ($request->has('fields')) {
                $this->processFormFields($form, $request->fields);
            }
        }
        
        return redirect()->route('admin.forms.edit', $form)
            ->with('success', 'Form updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete-forms');
        
        $form = Form::findOrFail($id);
        
        // Delete form and related fields (cascade will handle this)
        $form->delete();
        
        return redirect()->route('admin.forms.index')
            ->with('success', 'Form deleted successfully.');
    }
    
    /**
     * Add a field to a form.
     */
    public function addField(Request $request, $id)
    {
        $this->authorize('edit-forms');
        
        $form = Form::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(FormField::availableTypes())),
            'label' => 'required|string|max:255',
            'options' => 'nullable|array',
            'placeholder' => 'nullable|string',
            'help_text' => 'nullable|string',
            'is_required' => 'boolean',
            'is_unique' => 'boolean',
            'validation_rules' => 'nullable|array',
            'attributes' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Create the field
        $field = $form->fields()->create([
            'name' => $request->name ?? Str::slug($request->label, '_'),
            'type' => $request->type,
            'label' => $request->label,
            'options' => $request->options,
            'placeholder' => $request->placeholder,
            'help_text' => $request->help_text,
            'is_required' => $request->is_required ?? false,
            'is_unique' => $request->is_unique ?? false,
            'order' => $form->fields->count() + 1,
            'validation_rules' => $request->validation_rules,
            'attributes' => $request->attributes,
        ]);
        
        return response()->json([
            'success' => true,
            'field' => $field,
            'message' => 'Field added successfully.'
        ]);
    }
    
    /**
     * Update a field.
     */
    public function updateField(Request $request, $id, $fieldId)
    {
        $this->authorize('edit-forms');
        
        $form = Form::findOrFail($id);
        $field = $form->fields()->findOrFail($fieldId);
        
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(FormField::availableTypes())),
            'label' => 'required|string|max:255',
            'options' => 'nullable|array',
            'placeholder' => 'nullable|string',
            'help_text' => 'nullable|string',
            'is_required' => 'boolean',
            'is_unique' => 'boolean',
            'validation_rules' => 'nullable|array',
            'attributes' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Update the field
        $field->update([
            'name' => $request->name ?? Str::slug($request->label, '_'),
            'type' => $request->type,
            'label' => $request->label,
            'options' => $request->options,
            'placeholder' => $request->placeholder,
            'help_text' => $request->help_text,
            'is_required' => $request->is_required ?? false,
            'is_unique' => $request->is_unique ?? false,
            'validation_rules' => $request->validation_rules,
            'attributes' => $request->attributes,
        ]);
        
        return response()->json([
            'success' => true,
            'field' => $field,
            'message' => 'Field updated successfully.'
        ]);
    }
    
    /**
     * Delete a field.
     */
    public function deleteField($id, $fieldId)
    {
        $this->authorize('edit-forms');
        
        $form = Form::findOrFail($id);
        $field = $form->fields()->findOrFail($fieldId);
        
        $field->delete();
        
        // Re-order remaining fields
        $order = 1;
        foreach ($form->fields()->orderBy('order')->get() as $remainingField) {
            $remainingField->update(['order' => $order++]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Field deleted successfully.'
        ]);
    }
    
    /**
     * Reorder fields.
     */
    public function reorderFields(Request $request, $id)
    {
        $this->authorize('edit-forms');
        
        $form = Form::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'fields' => 'required|array',
            'fields.*' => 'required|integer|exists:form_fields,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Update field order
        foreach ($request->fields as $order => $fieldId) {
            $form->fields()->where('id', $fieldId)->update(['order' => $order + 1]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Field order updated successfully.'
        ]);
    }
    
    /**
     * Update all fields for a form.
     */
    public function updateFields(Request $request, $id)
    {
        $this->authorize('edit-forms');
        
        $form = Form::findOrFail($id);
        
        // Handle updating existing fields
        if ($request->has('fields')) {
            foreach ($request->fields as $index => $fieldData) {
                $field = $form->fields()->findOrFail($fieldData['id']);
                
                $field->update([
                    'name' => $fieldData['name'] ?? Str::slug($fieldData['label'], '_'),
                    'type' => $fieldData['type'],
                    'label' => $fieldData['label'],
                    'options' => isset($fieldData['options']) ? explode("\n", $fieldData['options']) : null,
                    'placeholder' => $fieldData['placeholder'] ?? null,
                    'help_text' => $fieldData['help_text'] ?? null,
                    'is_required' => isset($fieldData['required']),
                    'order' => $index + 1,
                ]);
            }
        }
        
        // Handle adding new fields
        if ($request->has('new_fields')) {
            $lastOrder = $form->fields->max('order') ?? 0;
            
            foreach ($request->new_fields as $index => $fieldData) {
                $form->fields()->create([
                    'name' => $fieldData['name'] ?? Str::slug($fieldData['label'], '_'),
                    'type' => $fieldData['type'],
                    'label' => $fieldData['label'],
                    'options' => isset($fieldData['options']) ? explode("\n", $fieldData['options']) : null,
                    'placeholder' => $fieldData['placeholder'] ?? null,
                    'help_text' => $fieldData['help_text'] ?? null,
                    'is_required' => isset($fieldData['required']),
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }
        
        return redirect()->route('admin.forms.edit', $form->id)
            ->with('success', 'Form fields updated successfully.');
    }
}

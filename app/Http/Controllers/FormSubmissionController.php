<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormSubmissionController extends Controller
{
    /**
     * Display a form for users to submit.
     */
    public function showForm($slug)
    {
        $form = Form::with('fields')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        // Check if form requires login
        if ($form->requires_login && !Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Please log in to access this form.');
        }
        
        // Pass the form to the view
        return view('forms.show', compact('form'));
    }
    
    /**
     * Process a form submission.
     */
    public function submitForm(Request $request, $slug)
    {
        $form = Form::with('fields')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        // Check if form requires login
        if ($form->requires_login && !Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Please log in to submit this form.');
        }
        
        // Validate the form submission based on field settings
        $rules = [];
        $messages = [];
        
        foreach ($form->fields as $field) {
            // Skip hidden fields
            if ($field->type === 'hidden') {
                continue;
            }
            
            // Apply validation rules
            $fieldRules = $field->getValidationRules();
            if (!empty($fieldRules)) {
                $rules[$field->name] = $fieldRules;
                
                // Custom messages for required fields
                if ($field->is_required) {
                    $messages[$field->name . '.required'] = "The {$field->label} field is required.";
                }
            }
        }
        
        // Validate
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Process and sanitize submission data
        $formData = $this->processSubmissionData($form, $request);
        
        // Store the submission if configured
        if ($form->store_submissions) {
            $submission = FormSubmission::create([
                'form_id' => $form->id,
                'user_id' => Auth::id(),
                'data' => $formData,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
        
        // Send notification if configured
        if ($form->send_notifications && $form->notification_email) {
            $this->sendFormNotification($form, $formData);
        }
        
        // Redirect with success message
        return redirect()->back()->with('success', $form->success_message ?? 'Thank you for your submission!');
    }
    
    /**
     * Process and sanitize submission data.
     */
    private function processSubmissionData(Form $form, Request $request)
    {
        $formData = [];
        
        foreach ($form->fields as $field) {
            // Process the field value based on type
            if ($field->type === 'file') {
                // Handle file uploads
                if ($request->hasFile($field->name)) {
                    $path = $request->file($field->name)->store('form-uploads', 'public');
                    $formData[$field->name] = asset('storage/' . $path);
                }
            } elseif ($field->type === 'checkbox') {
                // Handle checkboxes (may be boolean or array)
                if (is_array($request->input($field->name))) {
                    $formData[$field->name] = implode(', ', $request->input($field->name));
                } else {
                    $formData[$field->name] = $request->input($field->name) ? 'Yes' : 'No';
                }
            } else {
                // Handle other input types
                $formData[$field->name] = $request->input($field->name);
            }
        }
        
        return $formData;
    }
    
    /**
     * Send email notification about the form submission.
     */
    private function sendFormNotification(Form $form, array $formData)
    {
        // This is a simplified version - you might want to implement a proper 
        // notification class for this in a real application
        
        $recipients = explode(',', $form->notification_email);
        
        try {
            \Illuminate\Support\Facades\Mail::send(
                ['html' => 'emails.form-submission', 'text' => 'emails.form-submission-text'],
                ['form' => $form, 'data' => $formData],
                function ($message) use ($form, $recipients) {
                    $message->to($recipients)
                        ->subject('New Form Submission: ' . $form->name);
                }
            );
        } catch (\Exception $e) {
            // Log the error but don't prevent form submission from completing
            \Illuminate\Support\Facades\Log::error('Failed to send form submission email: ' . $e->getMessage());
        }
    }
}

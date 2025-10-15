<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
     * Submit a form.
     */
    public function submitForm(Request $request, $slug)
    {
        \Log::info('Form submission attempt', ['slug' => $slug, 'data' => $request->all()]);
        
        try {
            // Find the form
            $form = Form::where('slug', $slug)->firstOrFail();
            
            \Log::info('Form found', ['form_id' => $form->id, 'form_name' => $form->name]);

            // Check if form is active
            if (!$form->isActive()) {
                \Log::warning('Form not active', ['form_id' => $form->id]);
                return back()->with('error', 'This form is currently not accepting submissions.');
            }

            // Build validation rules from form fields
            $rules = [];
            $customMessages = [];
            
            foreach ($form->fields as $field) {
                $fieldRules = $field->getValidationRules();
                if (!empty($fieldRules)) {
                    $rules[$field->name] = $fieldRules;
                }
                
                // Add custom error messages for better UX
                $customMessages[$field->name . '.required'] = "The {$field->label} field is required.";
                $customMessages[$field->name . '.email'] = "Please enter a valid email address.";
            }

            // Validate the request
            $validated = $request->validate($rules, $customMessages);

            // Store submission if enabled
            if ($form->store_submissions) {
                $submission = FormSubmission::create([
                    'form_id' => $form->id,
                    'data' => $validated,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'submitted_at' => now(),
                ]);
            }

            // Send notification emails if enabled
            if ($form->send_notifications) {
                $this->sendFormNotification($form, $validated);
            }

            // Determine success response based on configuration
            $successMessage = $form->success_message ?? 'Form submitted successfully!';
            
            // Check if we should redirect to a success page
            if (!empty($form->success_page_url)) {
                return redirect($form->success_page_url)
                    ->with('success', $successMessage);
            }

            // Return success response based on request type
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                ]);
            }

            return back()->with('success', $successMessage);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            Log::error('Form submission error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your submission.',
                ], 500);
            }
            
            return back()->with('error', 'An error occurred while processing your submission. Please try again.');
        }
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

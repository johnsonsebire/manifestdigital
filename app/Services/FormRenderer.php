<?php

namespace App\Services;

use App\Models\Form;

class FormRenderer
{
    /**
     * Process form shortcodes in content.
     *
     * @param string $content The content to process
     * @return string The processed content
     */
    public function processShortcodes($content)
    {
        // Match different forms of shortcode: 
        // [form id=1], [form id="1"], [form slug="contact-form"]
        $pattern = '/\[form\s+(?:id=["\']*(\d+)["\']*|slug=["\']*([^"\'\]]+)["\']*)]/i';
        
        return preg_replace_callback($pattern, function ($matches) {
            $formId = $matches[1] ?? null;
            $formSlug = $matches[2] ?? null;
            
            // Find the form
            $form = null;
            try {
                if ($formId) {
                    $form = Form::with('fields')->find($formId);
                } elseif ($formSlug) {
                    $form = Form::with('fields')->where('slug', $formSlug)->first();
                }
                
                // If form not found or not active, return empty string
                if (!$form || !$form->isActive()) {
                    return '<div class="alert alert-warning">Form #' . ($formId ?? $formSlug) . ' not found or inactive</div>';
                }
                
                // Render the form
                return $this->renderForm($form);
            } catch (\Exception $e) {
                return '<div class="alert alert-danger">Error processing form: ' . $e->getMessage() . '</div>';
            }
        }, $content);
    }
    
    /**
     * Render a form.
     *
     * @param Form $form The form to render
     * @return string The rendered form HTML
     */
    /**
     * Render a form.
     *
     * @param Form $form The form to render
     * @return string The rendered form HTML
     */
    public function renderForm(Form $form)
    {
        try {
            // Check if the form has fields to prevent errors
            if (!$form->fields || $form->fields->isEmpty()) {
                return '<div class="alert alert-info">This form has no fields defined yet.</div>';
            }
            
            // Use view to render the form
            return view('forms.partials.form', compact('form'))->render();
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error rendering form: ' . $e->getMessage() . '</div>';
        }
    }
}
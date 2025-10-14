<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class ContactFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we already have a form with id=2
        $existingForm = Form::find(2);
        if ($existingForm) {
            // Clear any existing fields for this form
            $existingForm->fields()->delete();
            
            // Update the form
            $existingForm->update([
                'name' => 'Contact Us Form',
                'title' => 'Get in Touch',
                'slug' => 'contact-us',
                'description' => 'Use this form to contact our team for any inquiries.',
                'success_message' => 'Thank you for your message! We will get back to you soon.',
                'submit_button_text' => 'Send Message',
                'store_submissions' => true,
                'send_notifications' => true,
                'notification_email' => 'johnsonsebire@gmail.com',
                'is_active' => true
            ]);
            
            $form = $existingForm;
        } else {
            // Create a new form with id=2
            $form = Form::create([
                'id' => 2,
                'name' => 'Contact Us Form',
                'title' => 'Get in Touch',
                'slug' => 'contact-us',
                'description' => 'Use this form to contact our team for any inquiries.',
                'success_message' => 'Thank you for your message! We will get back to you soon.',
                'submit_button_text' => 'Send Message',
                'store_submissions' => true,
                'send_notifications' => true,
                'notification_email' => 'johnsonsebire@gmail.com',
                'is_active' => true,
                'shortcode' => 'form_contact'
            ]);
        }

        // Create form fields
        $fields = [
            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Full Name',
                'placeholder' => 'Enter your full name',
                'is_required' => true,
                'order' => 1
            ],
            [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email Address',
                'placeholder' => 'Enter your email address',
                'is_required' => true,
                'order' => 2
            ],
            [
                'name' => 'phone',
                'type' => 'text',
                'label' => 'Phone Number',
                'placeholder' => 'Enter your phone number',
                'is_required' => false,
                'order' => 3
            ],
            [
                'name' => 'subject',
                'type' => 'select',
                'label' => 'Subject',
                'options' => json_encode([
                    'general' => 'General Inquiry',
                    'support' => 'Technical Support',
                    'quote' => 'Request a Quote',
                    'feedback' => 'Feedback',
                    'other' => 'Other'
                ]),
                'is_required' => true,
                'order' => 4
            ],
            [
                'name' => 'message',
                'type' => 'textarea',
                'label' => 'Your Message',
                'placeholder' => 'Type your message here...',
                'is_required' => true,
                'order' => 5
            ]
        ];

        foreach ($fields as $field) {
            FormField::create([
                'form_id' => $form->id,
                'name' => $field['name'],
                'type' => $field['type'],
                'label' => $field['label'],
                'placeholder' => $field['placeholder'] ?? null,
                'options' => $field['options'] ?? null,
                'is_required' => $field['is_required'] ?? false,
                'order' => $field['order']
            ]);
        }

        $this->command->info('Contact form seeded successfully!');
    }
}
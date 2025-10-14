<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\FormField;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a contact form
        $form = Form::create([
            'id' => 1,
            'name' => 'Contact Form',
            'title' => 'Get In Touch',
            'slug' => 'contact-form',
            'description' => 'Send us a message and we will get back to you as soon as possible.',
            'success_message' => 'Thank you for your message! We will contact you shortly.',
            'submit_button_text' => 'Send Message',
            'store_submissions' => true,
            'send_notifications' => true,
            'notification_email' => 'info@manifestghana.com',
            'is_active' => true,
            'requires_login' => false,
            'recaptcha_status' => 'disabled',
            'shortcode' => 'form_contact',
        ]);

        // Add fields to the form
        $fields = [
            [
                'form_id' => $form->id,
                'name' => 'name',
                'label' => 'Your Name',
                'type' => 'text',
                'placeholder' => 'Enter your full name',
                'help_text' => 'Please provide your full name',
                'default_value' => '',
                'is_required' => true,
                'validation_rules' => 'required|string|max:100',
                'order' => 1,
                'options' => null,
            ],
            [
                'form_id' => $form->id,
                'name' => 'email',
                'label' => 'Email Address',
                'type' => 'email',
                'placeholder' => 'Enter your email address',
                'help_text' => 'We\'ll never share your email with anyone else',
                'default_value' => '',
                'is_required' => true,
                'validation_rules' => 'required|email|max:255',
                'order' => 2,
                'options' => null,
            ],
            [
                'form_id' => $form->id,
                'name' => 'subject',
                'label' => 'Subject',
                'type' => 'text',
                'placeholder' => 'Enter message subject',
                'help_text' => '',
                'default_value' => '',
                'is_required' => true,
                'validation_rules' => 'required|string|max:200',
                'order' => 3,
                'options' => null,
            ],
            [
                'form_id' => $form->id,
                'name' => 'message',
                'label' => 'Your Message',
                'type' => 'textarea',
                'placeholder' => 'Enter your message here',
                'help_text' => 'Please provide as much detail as possible',
                'default_value' => '',
                'is_required' => true,
                'validation_rules' => 'required|string|min:10',
                'order' => 4,
                'options' => null,
            ],
        ];

        foreach ($fields as $field) {
            FormField::create($field);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class BookACallFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the "Book a Call" form
        $form = Form::updateOrCreate(
            ['slug' => 'book-a-call'],
            [
                'name' => 'Book a Call',
                'title' => 'Schedule Your Consultation',
                'description' => 'Fill out the form below and we\'ll get back to you within 24 hours to confirm your appointment',
                'success_message' => 'Thank you for booking a consultation. We\'ll contact you within 24 hours to confirm your preferred time slot.',
                'submit_button_text' => 'Schedule Consultation',
                'store_submissions' => true,
                'send_notifications' => true,
                'notification_email' => env('MAIL_FROM_ADDRESS', 'info@manifestghana.com'),
                'is_active' => true,
                'requires_login' => false,
                'recaptcha_status' => 'disabled',
                'shortcode' => '[form id="book-a-call"]',
            ]
        );

        // Delete existing fields to prevent duplicates
        $form->fields()->delete();

        // Create form fields
        $fields = [
            [
                'name' => 'firstName',
                'type' => 'text',
                'label' => 'First Name',
                'placeholder' => 'John',
                'is_required' => true,
                'order' => 1,
            ],
            [
                'name' => 'lastName',
                'type' => 'text',
                'label' => 'Last Name',
                'placeholder' => 'Doe',
                'is_required' => true,
                'order' => 2,
            ],
            [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email Address',
                'placeholder' => 'john@example.com',
                'is_required' => true,
                'order' => 3,
            ],
            [
                'name' => 'phone',
                'type' => 'text',
                'label' => 'Phone Number',
                'placeholder' => '+233 XX XXX XXXX',
                'is_required' => true,
                'order' => 4,
            ],
            [
                'name' => 'meetingType',
                'type' => 'select',
                'label' => 'Meeting Type',
                'options' => [
                    'discovery' => 'Discovery Call (30 minutes)',
                    'technical' => 'Technical Consultation (45 minutes)',
                    'project' => 'Project Discussion (60 minutes)',
                ],
                'is_required' => true,
                'order' => 5,
            ],
            [
                'name' => 'preferredDate',
                'type' => 'date',
                'label' => 'Preferred Date',
                'is_required' => true,
                'order' => 6,
            ],
            [
                'name' => 'preferredTime',
                'type' => 'select',
                'label' => 'Preferred Time',
                'options' => [
                    '09:00' => '09:00 AM',
                    '10:00' => '10:00 AM',
                    '11:00' => '11:00 AM',
                    '12:00' => '12:00 PM',
                    '14:00' => '02:00 PM',
                    '15:00' => '03:00 PM',
                    '16:00' => '04:00 PM',
                    '17:00' => '05:00 PM',
                ],
                'is_required' => true,
                'order' => 7,
            ],
            [
                'name' => 'timezone',
                'type' => 'select',
                'label' => 'Your Timezone',
                'options' => [
                    'GMT' => 'GMT (Ghana)',
                    'WAT' => 'WAT (West Africa Time)',
                    'EST' => 'EST (Eastern Standard Time)',
                    'PST' => 'PST (Pacific Standard Time)',
                    'CET' => 'CET (Central European Time)',
                    'BST' => 'BST (British Summer Time)',
                ],
                'is_required' => true,
                'order' => 8,
            ],
            [
                'name' => 'projectDetails',
                'type' => 'textarea',
                'label' => 'Tell us about your project',
                'placeholder' => 'Briefly describe your project, goals, and any specific requirements...',
                'is_required' => false,
                'order' => 9,
            ],
        ];

        foreach ($fields as $fieldData) {
            FormField::create(array_merge(['form_id' => $form->id], $fieldData));
        }

        $this->command->info('Book a Call form created successfully!');
    }
}

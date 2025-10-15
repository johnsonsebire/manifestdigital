<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class TeamProfileFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Team Profile form
        $form = Form::create([
            'name' => 'Team Profile Submission',
            'title' => 'Team Profile Form',
            'slug' => 'team-profile',
            'description' => 'Complete this form to create or update your team profile information for the Manifest Digital team showcase.',
            'is_active' => true,
            'requires_login' => false,
            'store_submissions' => true,
            'send_notifications' => true,
            'notification_email' => 'business@manifestghana.com',
            'success_message' => 'Thank you for submitting your profile! We\'ll review your information and update the team page shortly.',
            'success_page_url' => null,
            'shortcode' => '[form id=team-profile]',
        ]);

        // Personal Information
        FormField::create([
            'form_id' => $form->id,
            'name' => 'name',
            'label' => 'Full Name',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => true,
            'validation_rules' => 'required|string|max:255',
            'order' => 1,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'role',
            'label' => 'Job Role/Position',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => true,
            'validation_rules' => 'required|string|max:255',
            'order' => 2,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'id_key',
            'label' => 'Profile ID',
            'type' => 'text',
            'placeholder' => 'Unique identifier (e.g., "john-doe", use lowercase with hyphens)',
            'is_required' => true,
            'validation_rules' => 'required|string|max:100|regex:/^[a-z0-9-]+$/',
            'order' => 3,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'bio',
            'label' => 'Professional Bio',
            'type' => 'textarea',
            'placeholder' => 'Write a detailed professional bio (2-3 paragraphs recommended)',
            'is_required' => true,
            'validation_rules' => 'required|string',
            'order' => 4,
        ]);

        // Contact Information
        FormField::create([
            'form_id' => $form->id,
            'name' => 'contact_email',
            'label' => 'Email',
            'type' => 'email',
            'placeholder' => '',
            'is_required' => true,
            'validation_rules' => 'required|email',
            'order' => 5,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'contact_phone',
            'label' => 'Phone Number',
            'type' => 'tel',
            'placeholder' => '',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:20',
            'order' => 6,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'contact_location',
            'label' => 'Location',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 7,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'contact_linkedin',
            'label' => 'LinkedIn Profile',
            'type' => 'url',
            'placeholder' => '',
            'is_required' => false,
            'validation_rules' => 'nullable|url',
            'order' => 8,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'contact_github',
            'label' => 'GitHub Profile',
            'type' => 'url',
            'placeholder' => '',
            'is_required' => false,
            'validation_rules' => 'nullable|url',
            'order' => 9,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'contact_other_social',
            'label' => 'Other Social Media',
            'type' => 'text',
            'placeholder' => 'Format: platform:username (e.g., dribbble:username)',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 10,
        ]);

        // Skills (stored as JSON text)
        FormField::create([
            'form_id' => $form->id,
            'name' => 'skills',
            'label' => 'Skills',
            'type' => 'textarea',
            'placeholder' => 'Enter skills in JSON format: [{"category":"Programming Languages","items":"JavaScript, Python, PHP"},{"category":"Design","items":"Figma, Adobe XD"}]',
            'is_required' => true,
            'validation_rules' => 'required|string',
            'order' => 11,
        ]);

        // Experience (stored as JSON text)
        FormField::create([
            'form_id' => $form->id,
            'name' => 'experience',
            'label' => 'Professional Experience',
            'type' => 'textarea',
            'placeholder' => 'Enter experience in JSON format: [{"title":"Senior Developer","company":"Tech Co","duration":"2020 - Present","location":"Accra","description":"Led development team..."}]',
            'is_required' => true,
            'validation_rules' => 'required|string',
            'order' => 12,
        ]);

        // Achievements (stored as JSON text)
        FormField::create([
            'form_id' => $form->id,
            'name' => 'achievements',
            'label' => 'Key Achievements',
            'type' => 'textarea',
            'placeholder' => 'Enter achievements in JSON format: [{"title":"Best Project Award","year":"2023","description":"Awarded for outstanding project delivery"}]',
            'is_required' => true,
            'validation_rules' => 'required|string',
            'order' => 13,
        ]);

        $this->command->info('✓ Team Profile form created successfully with 13 fields');
    }
}

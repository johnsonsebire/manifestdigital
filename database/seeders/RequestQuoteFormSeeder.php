<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class RequestQuoteFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Request Quote form
        $form = Form::create([
            'name' => 'Request Quote',
            'title' => 'Get a Quote',
            'slug' => 'request-quote',
            'description' => 'Get a custom quote for your digital project. Complete the form to receive a detailed proposal tailored to your needs.',
            'is_active' => true,
            'requires_login' => false,
            'store_submissions' => true,
            'send_notifications' => true,
            'notification_email' => 'business@manifestghana.com',
            'success_message' => 'Thank you for your quote request! We\'ll review your requirements and get back to you within 24 hours with a detailed proposal.',
            'success_page_url' => null,
            'shortcode' => '[form id=request-quote]',
        ]);

        // Step 1: Service Selection
        FormField::create([
            'form_id' => $form->id,
            'name' => 'service',
            'label' => 'Service Type',
            'type' => 'select',
            'placeholder' => 'Select service type',
            'is_required' => true,
            'validation_rules' => 'required|string',
            'options' => [
                'website' => 'Website Development - From GH₵3,000',
                'ecommerce' => 'E-commerce Store - From GH₵5,000',
                'mobile-app' => 'Mobile App - From GH₵8,000',
                'branding' => 'Brand Identity - From GH₵1,500',
                'digital-marketing' => 'Digital Marketing - From GH₵2,000/month',
                'consulting' => 'IT Consulting - From GH₵500/hour',
            ],
            'order' => 1,
        ]);

        // Step 2: Project Details
        FormField::create([
            'form_id' => $form->id,
            'name' => 'projectTitle',
            'label' => 'Project Title',
            'type' => 'text',
            'placeholder' => 'Give your project a name',
            'is_required' => true,
            'validation_rules' => 'required|string|max:255',
            'order' => 2,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'projectDescription',
            'label' => 'Project Description',
            'type' => 'textarea',
            'placeholder' => 'Describe your project in detail. What are your goals? What problems are you trying to solve?',
            'is_required' => true,
            'validation_rules' => 'required|string',
            'order' => 3,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'targetAudience',
            'label' => 'Target Audience',
            'type' => 'text',
            'placeholder' => 'Who is your target audience?',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 4,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'industry',
            'label' => 'Industry',
            'type' => 'select',
            'placeholder' => 'Select your industry',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'options' => [
                'nonprofit' => 'Non-profit',
                'healthcare' => 'Healthcare',
                'education' => 'Education',
                'technology' => 'Technology',
                'retail' => 'Retail/E-commerce',
                'finance' => 'Finance',
                'real-estate' => 'Real Estate',
                'hospitality' => 'Hospitality',
                'manufacturing' => 'Manufacturing',
                'other' => 'Other',
            ],
            'order' => 5,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'features',
            'label' => 'Required Features',
            'type' => 'textarea',
            'placeholder' => 'List the specific features and functionality you need (e.g., user login, payment processing, booking system, etc.)',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'order' => 6,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'integrations',
            'label' => 'Third-party Integrations',
            'type' => 'text',
            'placeholder' => 'Payment gateways, CRM, email marketing, etc.',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 7,
        ]);

        // Step 3: Budget & Timeline
        FormField::create([
            'form_id' => $form->id,
            'name' => 'budget',
            'label' => 'Project Budget',
            'type' => 'select',
            'placeholder' => 'Select budget range',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'options' => [
                'under-5k' => 'Under GH₵5,000',
                '5k-15k' => 'GH₵5,000 - GH₵15,000',
                '15k-30k' => 'GH₵15,000 - GH₵30,000',
                '30k-plus' => 'GH₵30,000+',
                'flexible' => 'I\'m flexible',
            ],
            'order' => 8,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'timeline',
            'label' => 'Project Timeline',
            'type' => 'select',
            'placeholder' => 'Select timeline',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'options' => [
                'asap' => 'ASAP',
                '1-month' => '1 Month',
                '2-3-months' => '2-3 Months',
                '3-6-months' => '3-6 Months',
                '6-plus-months' => '6+ Months',
                'flexible' => 'Flexible',
            ],
            'order' => 9,
        ]);

        // Step 4: Contact Information
        FormField::create([
            'form_id' => $form->id,
            'name' => 'firstName',
            'label' => 'First Name',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => true,
            'validation_rules' => 'required|string|max:255',
            'order' => 10,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'lastName',
            'label' => 'Last Name',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => true,
            'validation_rules' => 'required|string|max:255',
            'order' => 11,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'email',
            'label' => 'Email Address',
            'type' => 'email',
            'placeholder' => '',
            'is_required' => true,
            'validation_rules' => 'required|email',
            'order' => 12,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'phone',
            'label' => 'Phone Number',
            'type' => 'tel',
            'placeholder' => '+233 XX XXX XXXX',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:20',
            'order' => 13,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'company',
            'label' => 'Organization Name',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 14,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'position',
            'label' => 'Your Position',
            'type' => 'text',
            'placeholder' => '',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 15,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'website',
            'label' => 'Current Website',
            'type' => 'url',
            'placeholder' => 'https://yourwebsite.com',
            'is_required' => false,
            'validation_rules' => 'nullable|url',
            'order' => 16,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'employees',
            'label' => 'Team Size',
            'type' => 'select',
            'placeholder' => 'Select team size',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'options' => [
                '1-10' => '1-10 people',
                '11-50' => '11-50 people',
                '51-200' => '51-200 people',
                '200+' => '200+ people',
            ],
            'order' => 17,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'communication',
            'label' => 'Preferred Communication Method',
            'type' => 'select',
            'placeholder' => 'Select communication method',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'options' => [
                'email' => 'Email',
                'phone' => 'Phone Call',
                'video' => 'Video Call',
                'whatsapp' => 'WhatsApp',
                'in-person' => 'In-person Meeting',
            ],
            'order' => 18,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'availability',
            'label' => 'Best Time to Contact',
            'type' => 'text',
            'placeholder' => 'e.g., Weekdays 9am-5pm, Evenings after 6pm',
            'is_required' => false,
            'validation_rules' => 'nullable|string|max:255',
            'order' => 19,
        ]);

        FormField::create([
            'form_id' => $form->id,
            'name' => 'additionalInfo',
            'label' => 'Additional Information',
            'type' => 'textarea',
            'placeholder' => 'Anything else you\'d like us to know about your project or requirements?',
            'is_required' => false,
            'validation_rules' => 'nullable|string',
            'order' => 20,
        ]);

        $this->command->info('✓ Request Quote form created successfully with 20 fields');
    }
}

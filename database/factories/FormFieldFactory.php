<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormField>
 */
class FormFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fieldTypes = ['text', 'email', 'textarea', 'number', 'select', 'checkbox', 'radio', 'date', 'phone', 'url'];
        $type = $this->faker->randomElement($fieldTypes);

        return [
            'form_id' => Form::factory(),
            'name' => $this->getFieldName($type),
            'type' => $type,
            'label' => $this->getFieldLabel($type),
            'options' => $this->getFieldOptions($type),
            'placeholder' => $this->getFieldPlaceholder($type),
            'help_text' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'is_required' => $this->faker->boolean(60),
            'is_unique' => $this->faker->boolean(15),
            'order' => $this->faker->numberBetween(1, 10),
            'validation_rules' => $this->getValidationRules($type),
            'attributes' => $this->getFieldAttributes($type),
        ];
    }

    /**
     * Get field name based on type
     */
    private function getFieldName($type): string
    {
        $names = [
            'text' => ['first_name', 'last_name', 'company', 'full_name', 'title', 'position'],
            'email' => ['email', 'contact_email', 'business_email'],
            'textarea' => ['message', 'description', 'comments', 'requirements', 'details'],
            'number' => ['budget', 'phone', 'quantity', 'years_experience'],
            'select' => ['service_type', 'budget_range', 'timeline', 'priority'],
            'checkbox' => ['newsletter_subscribe', 'terms_accepted', 'privacy_accepted'],
            'radio' => ['contact_method', 'project_type', 'urgency'],
            'date' => ['preferred_date', 'deadline', 'start_date'],
            'phone' => ['phone', 'mobile', 'contact_number'],
            'url' => ['website', 'portfolio_url', 'company_website'],
        ];

        return $this->faker->randomElement($names[$type] ?? ['field_name']);
    }

    /**
     * Get field label based on type
     */
    private function getFieldLabel($type): string
    {
        $labels = [
            'text' => ['First Name', 'Last Name', 'Company Name', 'Full Name', 'Job Title', 'Position'],
            'email' => ['Email Address', 'Contact Email', 'Business Email'],
            'textarea' => ['Message', 'Project Description', 'Comments', 'Requirements', 'Additional Details'],
            'number' => ['Budget Amount', 'Phone Number', 'Quantity', 'Years of Experience'],
            'select' => ['Service Type', 'Budget Range', 'Project Timeline', 'Priority Level'],
            'checkbox' => ['Subscribe to Newsletter', 'Accept Terms', 'Privacy Policy Agreement'],
            'radio' => ['Preferred Contact Method', 'Project Type', 'Urgency Level'],
            'date' => ['Preferred Date', 'Project Deadline', 'Start Date'],
            'phone' => ['Phone Number', 'Mobile Number', 'Contact Number'],
            'url' => ['Website URL', 'Portfolio URL', 'Company Website'],
        ];

        return $this->faker->randomElement($labels[$type] ?? ['Field Label']);
    }

    /**
     * Get field options for select/radio/checkbox types
     */
    private function getFieldOptions($type): ?array
    {
        if (!in_array($type, ['select', 'radio', 'checkbox'])) {
            return null;
        }

        $options = [
            'select' => [
                ['Web Development', 'Mobile App', 'E-commerce', 'Digital Marketing', 'Consulting'],
                ['$1,000 - $5,000', '$5,000 - $10,000', '$10,000 - $25,000', '$25,000+'],
                ['1-2 weeks', '2-4 weeks', '1-2 months', '3+ months'],
                ['Low', 'Medium', 'High', 'Urgent'],
            ],
            'radio' => [
                ['Email', 'Phone', 'Video Call', 'In Person'],
                ['Website', 'Mobile App', 'E-commerce', 'Custom Software'],
                ['Not Urgent', 'Within a Month', 'Within a Week', 'ASAP'],
            ],
            'checkbox' => [
                ['Yes, I want to receive updates'],
                ['I agree to the terms and conditions'],
                ['I accept the privacy policy'],
            ],
        ];

        return $this->faker->randomElement($options[$type] ?? []);
    }

    /**
     * Get field placeholder based on type
     */
    private function getFieldPlaceholder($type): ?string
    {
        $placeholders = [
            'text' => ['Enter your first name', 'Enter your company name', 'Your full name'],
            'email' => ['your@email.com', 'Enter your email address'],
            'textarea' => ['Tell us about your project...', 'Enter your message here...', 'Describe your requirements...'],
            'number' => ['Enter amount', 'Your phone number', 'Enter quantity'],
            'phone' => ['(555) 123-4567', 'Enter your phone number'],
            'url' => ['https://yourwebsite.com', 'Enter URL'],
            'date' => ['Select date', 'mm/dd/yyyy'],
        ];

        if (!isset($placeholders[$type])) {
            return null;
        }

        return $this->faker->randomElement($placeholders[$type]);
    }

    /**
     * Get validation rules based on type
     */
    private function getValidationRules($type): ?array
    {
        $rules = [
            'email' => ['email'],
            'number' => ['numeric'],
            'phone' => ['regex:/^[0-9\+\-\(\)\s]{5,20}$/'],
            'url' => ['url'],
            'date' => ['date'],
            'text' => $this->faker->boolean(30) ? ['min:2', 'max:100'] : null,
            'textarea' => $this->faker->boolean(40) ? ['min:10', 'max:1000'] : null,
        ];

        return $rules[$type] ?? null;
    }

    /**
     * Get field attributes based on type
     */
    private function getFieldAttributes($type): ?array
    {
        $attributes = [
            'text' => $this->faker->boolean(20) ? ['maxlength' => $this->faker->numberBetween(50, 200)] : null,
            'textarea' => [
                'rows' => $this->faker->numberBetween(3, 8),
                'cols' => $this->faker->numberBetween(40, 80),
            ],
            'number' => [
                'min' => $this->faker->boolean(50) ? $this->faker->numberBetween(0, 100) : null,
                'max' => $this->faker->boolean(50) ? $this->faker->numberBetween(1000, 10000) : null,
            ],
        ];

        return $attributes[$type] ?? null;
    }

    /**
     * Create a required field
     */
    public function required(): static
    {
        return $this->state([
            'is_required' => true,
        ]);
    }

    /**
     * Create an optional field
     */
    public function optional(): static
    {
        return $this->state([
            'is_required' => false,
        ]);
    }

    /**
     * Create a unique field
     */
    public function unique(): static
    {
        return $this->state([
            'is_unique' => true,
        ]);
    }

    /**
     * Create a text field
     */
    public function textField(): static
    {
        return $this->state([
            'type' => 'text',
            'name' => $this->faker->randomElement(['first_name', 'last_name', 'company', 'title']),
            'label' => $this->faker->randomElement(['First Name', 'Last Name', 'Company Name', 'Job Title']),
            'placeholder' => 'Enter text here',
            'validation_rules' => ['min:2', 'max:100'],
        ]);
    }

    /**
     * Create an email field
     */
    public function emailField(): static
    {
        return $this->state([
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email Address',
            'placeholder' => 'your@email.com',
            'is_required' => true,
            'validation_rules' => ['email'],
        ]);
    }

    /**
     * Create a textarea field
     */
    public function textareaField(): static
    {
        return $this->state([
            'type' => 'textarea',
            'name' => $this->faker->randomElement(['message', 'description', 'comments']),
            'label' => $this->faker->randomElement(['Message', 'Description', 'Comments']),
            'placeholder' => 'Enter your message here...',
            'attributes' => ['rows' => 5, 'cols' => 50],
            'validation_rules' => ['min:10', 'max:1000'],
        ]);
    }

    /**
     * Create a select field
     */
    public function selectField(): static
    {
        return $this->state([
            'type' => 'select',
            'name' => 'service_type',
            'label' => 'Service Type',
            'options' => ['Web Development', 'Mobile App', 'E-commerce', 'Digital Marketing'],
        ]);
    }

    /**
     * Create a checkbox field
     */
    public function checkboxField(): static
    {
        return $this->state([
            'type' => 'checkbox',
            'name' => 'newsletter_subscribe',
            'label' => 'Subscribe to Newsletter',
            'options' => ['Yes, I want to receive updates'],
        ]);
    }

    /**
     * Create a phone field
     */
    public function phoneField(): static
    {
        return $this->state([
            'type' => 'phone',
            'name' => 'phone',
            'label' => 'Phone Number',
            'placeholder' => '(555) 123-4567',
            'validation_rules' => ['regex:/^[0-9\+\-\(\)\s]{5,20}$/'],
        ]);
    }

    /**
     * Create a date field
     */
    public function dateField(): static
    {
        return $this->state([
            'type' => 'date',
            'name' => $this->faker->randomElement(['preferred_date', 'deadline', 'start_date']),
            'label' => $this->faker->randomElement(['Preferred Date', 'Deadline', 'Start Date']),
            'validation_rules' => ['date'],
        ]);
    }
}
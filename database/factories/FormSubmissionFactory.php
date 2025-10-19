<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormSubmission>
 */
class FormSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'form_id' => Form::factory(),
            'user_id' => $this->faker->boolean(40) ? User::factory() : null,
            'data' => $this->generateFormData(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }

    /**
     * Generate realistic form submission data
     */
    private function generateFormData(): array
    {
        $formTypes = ['contact', 'quote', 'newsletter', 'support', 'feedback', 'job_application'];
        $formType = $this->faker->randomElement($formTypes);

        return $this->getFormDataByType($formType);
    }

    /**
     * Get form data based on form type
     */
    private function getFormDataByType($type): array
    {
        switch ($type) {
            case 'contact':
                return $this->getContactFormData();
            case 'quote':
                return $this->getQuoteFormData();
            case 'newsletter':
                return $this->getNewsletterFormData();
            case 'support':
                return $this->getSupportFormData();
            case 'feedback':
                return $this->getFeedbackFormData();
            case 'job_application':
                return $this->getJobApplicationFormData();
            default:
                return $this->getContactFormData();
        }
    }

    /**
     * Generate contact form data
     */
    private function getContactFormData(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'company' => $this->faker->boolean(60) ? $this->faker->company() : null,
            'subject' => $this->faker->randomElement([
                'General Inquiry',
                'Service Information',
                'Partnership Opportunity',
                'Technical Question',
                'Pricing Information',
            ]),
            'message' => $this->faker->paragraphs(2, true),
            'contact_method' => $this->faker->randomElement(['email', 'phone', 'either']),
            'newsletter_subscribe' => $this->faker->boolean(30),
        ];
    }

    /**
     * Generate quote request form data
     */
    private function getQuoteFormData(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'company' => $this->faker->company(),
            'project_type' => $this->faker->randomElement([
                'Website Development',
                'Mobile Application',
                'E-commerce Store',
                'Digital Marketing',
                'Custom Software',
            ]),
            'budget_range' => $this->faker->randomElement([
                '$1,000 - $5,000',
                '$5,000 - $10,000',
                '$10,000 - $25,000',
                '$25,000 - $50,000',
                '$50,000+',
            ]),
            'timeline' => $this->faker->randomElement([
                '1-2 weeks',
                '2-4 weeks',
                '1-2 months',
                '3-6 months',
                '6+ months',
            ]),
            'project_description' => $this->faker->paragraphs(3, true),
            'features_required' => $this->faker->randomElements([
                'User Authentication',
                'Payment Processing',
                'Content Management',
                'API Integration',
                'Mobile Responsive',
                'SEO Optimization',
                'Analytics',
                'Social Media Integration',
            ], $this->faker->numberBetween(2, 5)),
            'preferred_start_date' => $this->faker->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d'),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
        ];
    }

    /**
     * Generate newsletter subscription data
     */
    private function getNewsletterFormData(): array
    {
        return [
            'email' => $this->faker->email(),
            'first_name' => $this->faker->firstName(),
            'interests' => $this->faker->randomElements([
                'Web Development',
                'Mobile Apps',
                'Digital Marketing',
                'E-commerce',
                'Technology News',
                'Business Tips',
            ], $this->faker->numberBetween(1, 3)),
            'frequency' => $this->faker->randomElement(['weekly', 'monthly', 'quarterly']),
        ];
    }

    /**
     * Generate support request data
     */
    private function getSupportFormData(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'account_id' => $this->faker->numerify('ACC####'),
            'issue_type' => $this->faker->randomElement([
                'Technical Issue',
                'Billing Question',
                'Feature Request',
                'Bug Report',
                'Account Access',
            ]),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'subject' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(2, true),
            'browser' => $this->faker->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge']),
            'operating_system' => $this->faker->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'steps_to_reproduce' => $this->faker->paragraphs(1, true),
            'expected_behavior' => $this->faker->sentence(),
            'actual_behavior' => $this->faker->sentence(),
        ];
    }

    /**
     * Generate feedback form data
     */
    private function getFeedbackFormData(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'service_used' => $this->faker->randomElement([
                'Web Development',
                'Mobile App Development',
                'Digital Marketing',
                'Consulting',
                'Support',
            ]),
            'overall_satisfaction' => $this->faker->numberBetween(1, 5),
            'communication_rating' => $this->faker->numberBetween(1, 5),
            'quality_rating' => $this->faker->numberBetween(1, 5),
            'timeline_rating' => $this->faker->numberBetween(1, 5),
            'what_went_well' => $this->faker->paragraph(),
            'areas_for_improvement' => $this->faker->paragraph(),
            'would_recommend' => $this->faker->randomElement(['yes', 'no', 'maybe']),
            'additional_comments' => $this->faker->boolean(60) ? $this->faker->paragraph() : null,
        ];
    }

    /**
     * Generate job application data
     */
    private function getJobApplicationFormData(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'position_applied' => $this->faker->randomElement([
                'Senior Web Developer',
                'Frontend Developer',
                'Backend Developer',
                'Full Stack Developer',
                'UI/UX Designer',
                'Project Manager',
                'Digital Marketing Specialist',
            ]),
            'years_experience' => $this->faker->numberBetween(1, 15),
            'current_salary' => $this->faker->numberBetween(30000, 150000),
            'expected_salary' => $this->faker->numberBetween(35000, 180000),
            'availability' => $this->faker->randomElement(['immediately', '2_weeks', '1_month', '2_months']),
            'skills' => $this->faker->randomElements([
                'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Node.js',
                'Python', 'MySQL', 'PostgreSQL', 'AWS', 'Docker', 'Git',
            ], $this->faker->numberBetween(3, 8)),
            'education' => $this->faker->randomElement([
                'High School',
                'Associate Degree',
                'Bachelor\'s Degree',
                'Master\'s Degree',
                'PhD',
            ]),
            'portfolio_url' => $this->faker->boolean(70) ? $this->faker->url() : null,
            'linkedin_url' => $this->faker->boolean(80) ? 'https://linkedin.com/in/' . $this->faker->userName() : null,
            'cover_letter' => $this->faker->paragraphs(3, true),
            'willing_to_relocate' => $this->faker->boolean(30),
            'remote_work_preference' => $this->faker->randomElement(['onsite', 'remote', 'hybrid', 'flexible']),
        ];
    }

    /**
     * Create a contact form submission
     */
    public function contactSubmission(): static
    {
        return $this->state([
            'data' => $this->getContactFormData(),
        ]);
    }

    /**
     * Create a quote request submission
     */
    public function quoteSubmission(): static
    {
        return $this->state([
            'data' => $this->getQuoteFormData(),
        ]);
    }

    /**
     * Create a newsletter subscription
     */
    public function newsletterSubmission(): static
    {
        return $this->state([
            'data' => $this->getNewsletterFormData(),
        ]);
    }

    /**
     * Create a support request submission
     */
    public function supportSubmission(): static
    {
        return $this->state([
            'data' => $this->getSupportFormData(),
        ]);
    }

    /**
     * Create a feedback submission
     */
    public function feedbackSubmission(): static
    {
        return $this->state([
            'data' => $this->getFeedbackFormData(),
        ]);
    }

    /**
     * Create a job application submission
     */
    public function jobApplicationSubmission(): static
    {
        return $this->state([
            'data' => $this->getJobApplicationFormData(),
        ]);
    }

    /**
     * Create a submission from a logged-in user
     */
    public function fromUser(): static
    {
        return $this->afterMaking(function (FormSubmission $submission) {
            $submission->user_id = User::factory()->create()->id;
        });
    }

    /**
     * Create a submission from an anonymous user
     */
    public function anonymous(): static
    {
        return $this->state([
            'user_id' => null,
        ]);
    }

    /**
     * Create a recent submission (within last 30 days)
     */
    public function recent(): static
    {
        return $this->afterMaking(function (FormSubmission $submission) {
            $submission->created_at = $this->faker->dateTimeBetween('-30 days', 'now');
        });
    }

    /**
     * Create an old submission (older than 6 months)
     */
    public function old(): static
    {
        return $this->afterMaking(function (FormSubmission $submission) {
            $submission->created_at = $this->faker->dateTimeBetween('-2 years', '-6 months');
        });
    }
}
<?php

namespace Database\Factories;

use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form>
 */
class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Contact Us',
            'Project Quote Request',
            'Newsletter Subscription',
            'Service Inquiry',
            'Support Request',
            'Feedback Form',
            'Event Registration',
            'Job Application',
            'Consultation Booking',
            'Partnership Inquiry',
        ]);

        return [
            'name' => $name,
            'title' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'success_message' => $this->faker->randomElement([
                'Thank you for your submission! We will get back to you soon.',
                'Your message has been sent successfully.',
                'Thank you for contacting us. We\'ll respond within 24 hours.',
                'Your request has been received and will be processed shortly.',
                'Thanks for your interest! Our team will reach out to you.',
            ]),
            'success_page_url' => $this->faker->boolean(30) ? $this->faker->url() : null,
            'submit_button_text' => $this->faker->randomElement([
                'Send Message',
                'Submit Request',
                'Get Quote',
                'Contact Us',
                'Send Inquiry',
                'Submit Form',
            ]),
            'store_submissions' => $this->faker->boolean(90),
            'send_notifications' => $this->faker->boolean(80),
            'notification_email' => $this->faker->boolean(70) ? $this->faker->companyEmail() : null,
            'is_active' => $this->faker->boolean(85),
            'requires_login' => $this->faker->boolean(20),
            'recaptcha_status' => $this->faker->randomElement(['disabled', 'v2', 'v3']),
            'shortcode' => 'form_' . Str::random(8),
        ];
    }

    /**
     * Create a contact form
     */
    public function contactForm(): static
    {
        return $this->state([
            'name' => 'Contact Us',
            'title' => 'Contact Us',
            'slug' => 'contact-us',
            'description' => 'Get in touch with our team',
            'success_message' => 'Thank you for your message! We will get back to you within 24 hours.',
            'submit_button_text' => 'Send Message',
            'store_submissions' => true,
            'send_notifications' => true,
            'is_active' => true,
            'requires_login' => false,
            'recaptcha_status' => 'v3',
        ]);
    }

    /**
     * Create a quote request form
     */
    public function quoteRequest(): static
    {
        return $this->state([
            'name' => 'Project Quote Request',
            'title' => 'Get a Project Quote',
            'slug' => 'project-quote',
            'description' => 'Tell us about your project and get a custom quote',
            'success_message' => 'Thank you for your project details! Our team will prepare a custom quote and send it to you within 2 business days.',
            'submit_button_text' => 'Request Quote',
            'store_submissions' => true,
            'send_notifications' => true,
            'is_active' => true,
            'requires_login' => false,
            'recaptcha_status' => 'v2',
        ]);
    }

    /**
     * Create a newsletter subscription form
     */
    public function newsletter(): static
    {
        return $this->state([
            'name' => 'Newsletter Subscription',
            'title' => 'Subscribe to Our Newsletter',
            'slug' => 'newsletter',
            'description' => 'Stay updated with our latest news and offers',
            'success_message' => 'Thank you for subscribing! You will receive our newsletter updates.',
            'submit_button_text' => 'Subscribe',
            'store_submissions' => true,
            'send_notifications' => false,
            'is_active' => true,
            'requires_login' => false,
            'recaptcha_status' => 'disabled',
        ]);
    }

    /**
     * Create a support request form
     */
    public function supportRequest(): static
    {
        return $this->state([
            'name' => 'Support Request',
            'title' => 'Technical Support',
            'slug' => 'support-request',
            'description' => 'Need help with our services? Submit a support request',
            'success_message' => 'Your support request has been submitted. Our technical team will respond within 4 hours.',
            'submit_button_text' => 'Submit Request',
            'store_submissions' => true,
            'send_notifications' => true,
            'is_active' => true,
            'requires_login' => true,
            'recaptcha_status' => 'v3',
        ]);
    }

    /**
     * Create an inactive form
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create a form that requires login
     */
    public function requiresLogin(): static
    {
        return $this->state([
            'requires_login' => true,
        ]);
    }

    /**
     * Create a form with no notifications
     */
    public function noNotifications(): static
    {
        return $this->state([
            'send_notifications' => false,
            'notification_email' => null,
        ]);
    }

    /**
     * Create a form with reCAPTCHA v2
     */
    public function withRecaptchaV2(): static
    {
        return $this->state([
            'recaptcha_status' => 'v2',
        ]);
    }

    /**
     * Create a form with reCAPTCHA v3
     */
    public function withRecaptchaV3(): static
    {
        return $this->state([
            'recaptcha_status' => 'v3',
        ]);
    }

    /**
     * Create a simple feedback form
     */
    public function feedback(): static
    {
        return $this->state([
            'name' => 'Customer Feedback',
            'title' => 'Share Your Feedback',
            'slug' => 'feedback',
            'description' => 'Help us improve our services with your valuable feedback',
            'success_message' => 'Thank you for your feedback! Your input helps us serve you better.',
            'submit_button_text' => 'Submit Feedback',
            'store_submissions' => true,
            'send_notifications' => true,
            'is_active' => true,
            'requires_login' => false,
            'recaptcha_status' => 'disabled',
        ]);
    }

    /**
     * Create a job application form
     */
    public function jobApplication(): static
    {
        return $this->state([
            'name' => 'Job Application',
            'title' => 'Apply for a Position',
            'slug' => 'job-application',
            'description' => 'Submit your application for open positions',
            'success_message' => 'Thank you for your application! Our HR team will review it and contact you if you are selected for an interview.',
            'submit_button_text' => 'Submit Application',
            'store_submissions' => true,
            'send_notifications' => true,
            'is_active' => true,
            'requires_login' => false,
            'recaptcha_status' => 'v3',
        ]);
    }
}
<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $basePrice = $this->faker->randomFloat(2, 50, 5000);
        
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'short_description' => $this->faker->sentence(),
            'price' => $basePrice,
            'currency_id' => Currency::factory(),
            'category_id' => Category::factory(),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
            'delivery_time_days' => $this->faker->numberBetween(1, 90),
            'sort_order' => $this->faker->numberBetween(1, 100),
            'metadata' => [
                'includes' => $this->faker->sentences(3),
                'requirements' => $this->faker->sentences(2),
                'deliverables' => $this->faker->sentences(4),
                'revision_limit' => $this->faker->numberBetween(1, 5),
                'support_duration_days' => $this->faker->numberBetween(30, 365),
            ],
            'pricing_type' => $this->faker->randomElement(['fixed', 'hourly', 'custom']),
            'hourly_rate' => null, // Will be set by hourly state
            'setup_fee' => $this->faker->boolean(30) ? $this->faker->randomFloat(2, 25, 500) : null,
            'minimum_hours' => null,
            'tags' => $this->faker->words(5),
        ];
    }

    /**
     * Create a web development service
     */
    public function webDevelopment(): static
    {
        return $this->state([
            'name' => $this->faker->randomElement([
                'Custom Website Development',
                'E-commerce Website',
                'WordPress Development',
                'React Application',
                'Laravel Web Application',
                'Landing Page Design',
            ]),
            'description' => 'Professional web development service with modern technologies and best practices.',
            'price' => $this->faker->randomFloat(2, 800, 8000),
            'delivery_time_days' => $this->faker->numberBetween(14, 60),
            'tags' => ['web development', 'frontend', 'backend', 'responsive', 'modern'],
        ]);
    }

    /**
     * Create a design service
     */
    public function design(): static
    {
        return $this->state([
            'name' => $this->faker->randomElement([
                'Logo Design',
                'Brand Identity Package',
                'UI/UX Design',
                'Website Mockup',
                'Business Card Design',
                'Brochure Design',
            ]),
            'description' => 'Creative design services tailored to your brand and requirements.',
            'price' => $this->faker->randomFloat(2, 150, 2500),
            'delivery_time_days' => $this->faker->numberBetween(3, 21),
            'tags' => ['design', 'creative', 'branding', 'visual', 'professional'],
        ]);
    }

    /**
     * Create an hourly service
     */
    public function hourly(): static
    {
        return $this->state([
            'pricing_type' => 'hourly',
            'hourly_rate' => $this->faker->randomFloat(2, 25, 150),
            'minimum_hours' => $this->faker->numberBetween(1, 10),
            'price' => null, // Price calculated based on hours
        ]);
    }

    /**
     * Create a featured service
     */
    public function featured(): static
    {
        return $this->state([
            'is_featured' => true,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ]);
    }

    /**
     * Create an inactive service
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create a custom pricing service
     */
    public function customPricing(): static
    {
        return $this->state([
            'pricing_type' => 'custom',
            'price' => null,
            'description' => $this->faker->paragraph() . ' Contact us for a custom quote.',
        ]);
    }
}
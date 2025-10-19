<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $budget = $this->faker->randomFloat(2, 500, 50000);
        $spent = $this->faker->randomFloat(2, 0, $budget * 0.8);
        $startDate = $this->faker->dateTimeBetween('-6 months', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d') . ' +6 months');

        return [
            'uuid' => $this->faker->uuid(),
            'customer_id' => User::factory(),
            'currency_id' => Currency::factory(),
            'name' => $this->faker->catchPhrase(),
            'description' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['planning', 'active', 'on_hold', 'completed', 'cancelled']),
            'priority' => $this->faker->randomElement(['low', 'normal', 'high', 'urgent']),
            'budget' => $budget,
            'budget_spent' => $spent,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'actual_start_date' => $this->faker->boolean(60) ? $this->faker->dateTimeBetween($startDate, 'now') : null,
            'actual_end_date' => $this->faker->boolean(20) ? $this->faker->dateTimeBetween($startDate, 'now') : null,
            'estimated_hours' => $this->faker->numberBetween(10, 500),
            'actual_hours' => $this->faker->boolean(60) ? $this->faker->numberBetween(5, 400) : null,
            'completion_percentage' => $this->faker->numberBetween(0, 100),
            'metadata' => [
                'project_type' => $this->faker->randomElement(['website', 'mobile_app', 'web_app', 'ecommerce', 'custom']),
                'technology_stack' => $this->faker->randomElement(['Laravel + Vue', 'React + Node.js', 'WordPress', 'Shopify', 'Custom PHP']),
                'team_size' => $this->faker->numberBetween(1, 8),
                'client_involvement' => $this->faker->randomElement(['low', 'medium', 'high']),
                'communication_frequency' => $this->faker->randomElement(['daily', 'weekly', 'bi-weekly', 'monthly']),
            ],
        ];
    }

    /**
     * Create a project in planning phase
     */
    public function planning(): static
    {
        return $this->state([
            'status' => 'planning',
            'completion_percentage' => $this->faker->numberBetween(0, 15),
            'budget_spent' => 0,
            'actual_start_date' => null,
            'actual_end_date' => null,
            'actual_hours' => null,
        ]);
    }

    /**
     * Create an active project
     */
    public function active(): static
    {
        return $this->state([
            'status' => 'active',
            'completion_percentage' => $this->faker->numberBetween(20, 85),
        ])->afterMaking(function (Project $project) {
            $project->actual_start_date = $this->faker->dateTimeBetween($project->start_date, 'now');
            $project->budget_spent = $project->budget * ($project->completion_percentage / 100) * $this->faker->randomFloat(2, 0.8, 1.2);
            $project->actual_hours = $project->estimated_hours * ($project->completion_percentage / 100) * $this->faker->randomFloat(2, 0.9, 1.3);
        });
    }

    /**
     * Create a completed project
     */
    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
            'completion_percentage' => 100,
        ])->afterMaking(function (Project $project) {
            $project->actual_start_date = $this->faker->dateTimeBetween($project->start_date, $project->end_date);
            $project->actual_end_date = $this->faker->dateTimeBetween($project->actual_start_date, $project->end_date);
            $project->budget_spent = $project->budget * $this->faker->randomFloat(2, 0.85, 1.15);
            $project->actual_hours = $project->estimated_hours * $this->faker->randomFloat(2, 0.9, 1.4);
        });
    }

    /**
     * Create a project on hold
     */
    public function onHold(): static
    {
        return $this->state([
            'status' => 'on_hold',
            'completion_percentage' => $this->faker->numberBetween(10, 60),
        ])->afterMaking(function (Project $project) {
            $project->actual_start_date = $this->faker->dateTimeBetween($project->start_date, 'now');
            $project->budget_spent = $project->budget * ($project->completion_percentage / 100) * $this->faker->randomFloat(2, 0.7, 1.1);
            $project->actual_hours = $project->estimated_hours * ($project->completion_percentage / 100) * $this->faker->randomFloat(2, 0.8, 1.2);
        });
    }

    /**
     * Create a cancelled project
     */
    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
            'completion_percentage' => $this->faker->numberBetween(0, 40),
        ])->afterMaking(function (Project $project) {
            if ($this->faker->boolean(70)) {
                $project->actual_start_date = $this->faker->dateTimeBetween($project->start_date, 'now');
                $project->budget_spent = $project->budget * ($project->completion_percentage / 100) * $this->faker->randomFloat(2, 0.5, 0.9);
                $project->actual_hours = $project->estimated_hours * ($project->completion_percentage / 100) * $this->faker->randomFloat(2, 0.6, 1.0);
            }
        });
    }

    /**
     * Create a high priority project
     */
    public function highPriority(): static
    {
        return $this->state([
            'priority' => 'high',
        ])->afterMaking(function (Project $project) {
            // High priority projects typically have shorter timelines
            $project->end_date = $this->faker->dateTimeBetween($project->start_date, $project->start_date->format('Y-m-d') . ' +3 months');
            $project->metadata = array_merge($project->metadata ?? [], [
                'rush_job' => true,
                'team_size' => $this->faker->numberBetween(3, 8),
                'communication_frequency' => 'daily',
            ]);
        });
    }

    /**
     * Create a large budget project
     */
    public function largeBudget(): static
    {
        return $this->afterMaking(function (Project $project) {
            $project->budget = $this->faker->randomFloat(2, 20000, 100000);
            $project->estimated_hours = $this->faker->numberBetween(200, 1000);
            $project->metadata = array_merge($project->metadata ?? [], [
                'project_type' => 'enterprise',
                'team_size' => $this->faker->numberBetween(5, 12),
                'client_involvement' => 'high',
            ]);
        });
    }

    /**
     * Create a website project
     */
    public function website(): static
    {
        return $this->state([
            'metadata' => [
                'project_type' => 'website',
                'technology_stack' => $this->faker->randomElement(['Laravel + Blade', 'WordPress', 'React + Next.js', 'Vue + Nuxt']),
                'features' => $this->faker->randomElements([
                    'responsive_design', 'cms', 'blog', 'contact_forms', 'seo_optimization',
                    'analytics', 'social_media_integration', 'payment_gateway', 'user_authentication'
                ], $this->faker->numberBetween(3, 7)),
                'pages_count' => $this->faker->numberBetween(5, 25),
                'design_complexity' => $this->faker->randomElement(['simple', 'moderate', 'complex']),
            ],
        ]);
    }

    /**
     * Create an e-commerce project
     */
    public function ecommerce(): static
    {
        return $this->state([
            'metadata' => [
                'project_type' => 'ecommerce',
                'technology_stack' => $this->faker->randomElement(['Shopify', 'WooCommerce', 'Laravel + Custom', 'Magento']),
                'features' => [
                    'product_catalog', 'shopping_cart', 'payment_gateway', 'order_management',
                    'inventory_management', 'user_accounts', 'admin_dashboard', 'shipping_integration'
                ],
                'products_count' => $this->faker->numberBetween(50, 1000),
                'payment_methods' => $this->faker->randomElements(['stripe', 'paypal', 'bank_transfer', 'crypto'], 2),
                'shipping_zones' => $this->faker->numberBetween(1, 5),
            ],
        ])->afterMaking(function (Project $project) {
            // E-commerce projects typically have higher budgets and longer timelines
            $project->budget = $this->faker->randomFloat(2, 5000, 50000);
            $project->estimated_hours = $this->faker->numberBetween(100, 800);
        });
    }
}
<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->randomElement([
                'cube', 'cog', 'code-bracket', 'paint-brush', 'chart-bar',
                'device-phone-mobile', 'globe-alt', 'cloud', 'shield-check'
            ]),
            'color' => $this->faker->hexColor(),
            'is_active' => $this->faker->boolean(85), // 85% chance of being active
            'sort_order' => $this->faker->numberBetween(1, 100),
            'parent_id' => null, // Will be set by subcategory state
            'metadata' => null,
        ];
    }

    /**
     * Create a subcategory
     */
    public function subcategory(Category $parent = null): static
    {
        return $this->state(function () use ($parent) {
            if (!$parent) {
                $parent = Category::whereNull('parent_id')->inRandomOrder()->first()
                    ?? Category::factory()->create();
            }

            return [
                'parent_id' => $parent->id,
                'sort_order' => $this->faker->numberBetween(1, 20),
            ];
        });
    }

    /**
     * Create an inactive category
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create a category with metadata
     */
    public function withMetadata(): static
    {
        return $this->state([
            'metadata' => [
                'featured' => $this->faker->boolean(),
                'show_in_menu' => $this->faker->boolean(80),
                'seo_keywords' => $this->faker->words(5),
            ],
        ]);
    }
}
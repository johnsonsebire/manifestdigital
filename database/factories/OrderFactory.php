<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 100, 10000);
        $taxRate = $this->faker->randomFloat(2, 0, 20);
        $taxAmount = $subtotal * ($taxRate / 100);
        $discountAmount = $this->faker->boolean(30) ? $this->faker->randomFloat(2, 10, $subtotal * 0.2) : 0;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        return [
            'uuid' => $this->faker->uuid(),
            'customer_id' => User::factory(),
            'currency_id' => Currency::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'in_progress', 'completed', 'cancelled', 'on_hold']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'partial', 'refunded', 'failed']),
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'amount_paid' => $this->faker->boolean(60) ? $totalAmount : 0,
            'notes' => $this->faker->boolean(40) ? $this->faker->paragraph() : null,
            'special_requirements' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'deadline' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('+1 week', '+3 months') : null,
            'priority' => $this->faker->randomElement(['low', 'normal', 'high', 'urgent']),
            'metadata' => [
                'source' => $this->faker->randomElement(['website', 'referral', 'direct', 'social_media']),
                'communication_preference' => $this->faker->randomElement(['email', 'phone', 'chat']),
            ],
        ];
    }

    /**
     * Create a pending order
     */
    public function pending(): static
    {
        return $this->state([
            'status' => 'pending',
            'payment_status' => 'pending',
            'amount_paid' => 0,
        ]);
    }

    /**
     * Create an approved order
     */
    public function approved(): static
    {
        return $this->state([
            'status' => 'approved',
            'payment_status' => 'paid',
        ])->afterCreating(function (Order $order) {
            $order->amount_paid = $order->total_amount;
            $order->save();
        });
    }

    /**
     * Create an in-progress order
     */
    public function inProgress(): static
    {
        return $this->state([
            'status' => 'in_progress',
            'payment_status' => 'paid',
        ])->afterCreating(function (Order $order) {
            $order->amount_paid = $order->total_amount;
            $order->save();
        });
    }

    /**
     * Create a completed order
     */
    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
            'payment_status' => 'paid',
        ])->afterCreating(function (Order $order) {
            $order->amount_paid = $order->total_amount;
            $order->save();
        });
    }

    /**
     * Create a cancelled order
     */
    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
            'payment_status' => $this->faker->randomElement(['pending', 'refunded']),
        ]);
    }

    /**
     * Create a high priority order
     */
    public function highPriority(): static
    {
        return $this->state([
            'priority' => 'high',
            'deadline' => $this->faker->dateTimeBetween('+1 day', '+2 weeks'),
        ]);
    }

    /**
     * Create an order with partial payment
     */
    public function partialPayment(): static
    {
        return $this->state([
            'payment_status' => 'partial',
        ])->afterCreating(function (Order $order) {
            $order->amount_paid = $order->total_amount * $this->faker->randomFloat(2, 0.2, 0.8);
            $order->save();
        });
    }

    /**
     * Create an order with discount
     */
    public function withDiscount(): static
    {
        return $this->afterMaking(function (Order $order) {
            $discountPercent = $this->faker->randomFloat(2, 5, 25);
            $order->discount_amount = $order->subtotal * ($discountPercent / 100);
            $order->total_amount = $order->subtotal + $order->tax_amount - $order->discount_amount;
        });
    }
}
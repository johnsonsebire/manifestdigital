<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 100, 15000);
        $taxRate = $this->faker->randomFloat(2, 0, 25);
        $taxAmount = $subtotal * ($taxRate / 100);
        $discountAmount = $this->faker->boolean(25) ? $this->faker->randomFloat(2, 10, $subtotal * 0.15) : 0;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;
        $issueDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $dueDate = $this->faker->dateTimeBetween($issueDate, $issueDate->format('Y-m-d') . ' +60 days');

        return [
            'uuid' => $this->faker->uuid(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('####-###'),
            'customer_id' => User::factory(),
            'order_id' => $this->faker->boolean(70) ? Order::factory() : null,
            'project_id' => $this->faker->boolean(60) ? Project::factory() : null,
            'currency_id' => Currency::factory(),
            'status' => $this->faker->randomElement(['draft', 'sent', 'viewed', 'partial', 'paid', 'overdue', 'cancelled']),
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'sent_date' => $this->faker->boolean(80) ? $this->faker->dateTimeBetween($issueDate, 'now') : null,
            'paid_date' => $this->faker->boolean(40) ? $this->faker->dateTimeBetween($issueDate, 'now') : null,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'amount_paid' => 0,
            'notes' => $this->faker->boolean(30) ? $this->faker->paragraph() : null,
            'terms' => $this->faker->boolean(60) ? $this->faker->sentence() : 'Payment due within 30 days',
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'credit_card', 'paypal', 'check', 'cash']),
            'metadata' => [
                'generated_from' => $this->faker->randomElement(['order', 'project', 'manual']),
                'payment_link' => $this->faker->boolean(70) ? $this->faker->url() : null,
                'reminder_count' => $this->faker->numberBetween(0, 3),
                'late_fee_applied' => false,
            ],
        ];
    }

    /**
     * Create a draft invoice
     */
    public function draft(): static
    {
        return $this->state([
            'status' => 'draft',
            'sent_date' => null,
            'paid_date' => null,
            'amount_paid' => 0,
        ]);
    }

    /**
     * Create a sent invoice
     */
    public function sent(): static
    {
        return $this->state([
            'status' => 'sent',
            'amount_paid' => 0,
            'paid_date' => null,
        ])->afterMaking(function (Invoice $invoice) {
            $invoice->sent_date = $this->faker->dateTimeBetween($invoice->issue_date, 'now');
        });
    }

    /**
     * Create a paid invoice
     */
    public function paid(): static
    {
        return $this->state([
            'status' => 'paid',
        ])->afterMaking(function (Invoice $invoice) {
            $invoice->sent_date = $this->faker->dateTimeBetween($invoice->issue_date, $invoice->due_date);
            $invoice->paid_date = $this->faker->dateTimeBetween($invoice->sent_date, $invoice->due_date);
            $invoice->amount_paid = $invoice->total_amount;
        });
    }

    /**
     * Create an overdue invoice
     */
    public function overdue(): static
    {
        return $this->state([
            'status' => 'overdue',
            'amount_paid' => 0,
            'paid_date' => null,
        ])->afterMaking(function (Invoice $invoice) {
            $invoice->due_date = $this->faker->dateTimeBetween('-60 days', '-1 day');
            $invoice->sent_date = $this->faker->dateTimeBetween($invoice->issue_date, $invoice->due_date);
            $invoice->metadata = array_merge($invoice->metadata ?? [], [
                'reminder_count' => $this->faker->numberBetween(1, 5),
                'last_reminder_sent' => $this->faker->dateTimeBetween($invoice->due_date, 'now'),
            ]);
        });
    }

    /**
     * Create a partially paid invoice
     */
    public function partial(): static
    {
        return $this->state([
            'status' => 'partial',
        ])->afterMaking(function (Invoice $invoice) {
            $invoice->sent_date = $this->faker->dateTimeBetween($invoice->issue_date, 'now');
            $invoice->paid_date = $this->faker->dateTimeBetween($invoice->sent_date, 'now');
            $invoice->amount_paid = $invoice->total_amount * $this->faker->randomFloat(2, 0.2, 0.8);
        });
    }

    /**
     * Create a cancelled invoice
     */
    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
            'amount_paid' => 0,
            'paid_date' => null,
        ])->afterMaking(function (Invoice $invoice) {
            if ($this->faker->boolean(60)) {
                $invoice->sent_date = $this->faker->dateTimeBetween($invoice->issue_date, 'now');
            }
        });
    }

    /**
     * Create an invoice with late fees
     */
    public function withLateFees(): static
    {
        return $this->afterMaking(function (Invoice $invoice) {
            $lateFee = $invoice->total_amount * 0.05; // 5% late fee
            $invoice->total_amount += $lateFee;
            $invoice->metadata = array_merge($invoice->metadata ?? [], [
                'late_fee_applied' => true,
                'late_fee_amount' => $lateFee,
                'late_fee_date' => $this->faker->dateTimeBetween($invoice->due_date, 'now'),
            ]);
        });
    }

    /**
     * Create a recurring invoice
     */
    public function recurring(): static
    {
        return $this->state([
            'metadata' => [
                'is_recurring' => true,
                'recurring_frequency' => $this->faker->randomElement(['monthly', 'quarterly', 'yearly']),
                'next_invoice_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
                'recurring_count' => $this->faker->numberBetween(1, 12),
                'auto_send' => $this->faker->boolean(80),
            ],
        ]);
    }

    /**
     * Create a project milestone invoice
     */
    public function milestone(): static
    {
        return $this->state([
            'metadata' => [
                'invoice_type' => 'milestone',
                'milestone_name' => $this->faker->randomElement([
                    'Project Setup & Planning',
                    'Design Phase Completion',
                    'Development Phase 1',
                    'Testing & QA',
                    'Final Delivery',
                ]),
                'milestone_percentage' => $this->faker->numberBetween(20, 50),
                'completion_requirements' => $this->faker->sentence(),
            ],
        ]);
    }

    /**
     * Create a large amount invoice
     */
    public function largeAmount(): static
    {
        return $this->afterMaking(function (Invoice $invoice) {
            $invoice->subtotal = $this->faker->randomFloat(2, 10000, 50000);
            $invoice->tax_amount = $invoice->subtotal * ($invoice->tax_rate / 100);
            $invoice->total_amount = $invoice->subtotal + $invoice->tax_amount - $invoice->discount_amount;
            
            $invoice->metadata = array_merge($invoice->metadata ?? [], [
                'requires_approval' => true,
                'approved_by' => $this->faker->name(),
                'approval_date' => $this->faker->dateTimeBetween($invoice->issue_date, 'now'),
            ]);
        });
    }

    /**
     * Create an invoice with discount
     */
    public function withDiscount(): static
    {
        return $this->afterMaking(function (Invoice $invoice) {
            $discountPercent = $this->faker->randomFloat(2, 5, 20);
            $invoice->discount_amount = $invoice->subtotal * ($discountPercent / 100);
            $invoice->total_amount = $invoice->subtotal + $invoice->tax_amount - $invoice->discount_amount;
            
            $invoice->metadata = array_merge($invoice->metadata ?? [], [
                'discount_reason' => $this->faker->randomElement([
                    'Early payment discount',
                    'Loyalty customer discount',
                    'Bulk order discount',
                    'Promotional discount',
                ]),
                'discount_percentage' => $discountPercent,
            ]);
        });
    }
}
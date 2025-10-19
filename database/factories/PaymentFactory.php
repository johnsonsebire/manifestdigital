<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 10, 5000);
        $currency = $this->faker->randomElement(['USD', 'EUR', 'GBP', 'GHS', 'CAD']);
        $method = $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer', 'stripe', 'mobile_money']);
        $status = $this->faker->randomElement(['pending', 'processing', 'succeeded', 'failed', 'cancelled', 'refunded']);

        return [
            'order_id' => Order::factory(),
            'amount' => $amount,
            'currency' => $currency,
            'method' => $method,
            'gateway_response' => $this->generateGatewayResponse($method, $status, $amount),
            'status' => $status,
            'reference' => $this->generateReference($method),
            'paid_at' => $status === 'succeeded' ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    /**
     * Generate realistic gateway response based on payment method and status
     */
    private function generateGatewayResponse($method, $status, $amount): array
    {
        $baseResponse = [
            'payment_method' => $method,
            'amount' => $amount,
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP', 'GHS']),
            'status' => $status,
            'timestamp' => now()->toISOString(),
        ];

        switch ($method) {
            case 'stripe':
                return array_merge($baseResponse, [
                    'id' => 'pi_' . $this->faker->regexify('[A-Za-z0-9]{24}'),
                    'object' => 'payment_intent',
                    'client_secret' => 'pi_' . $this->faker->regexify('[A-Za-z0-9]{24}') . '_secret_' . $this->faker->regexify('[A-Za-z0-9]{24}'),
                    'confirmation_method' => 'automatic',
                    'payment_method_types' => ['card'],
                    'receipt_email' => $this->faker->email(),
                    'charges' => [
                        'data' => [
                            [
                                'id' => 'ch_' . $this->faker->regexify('[A-Za-z0-9]{24}'),
                                'payment_method_details' => [
                                    'card' => [
                                        'brand' => $this->faker->randomElement(['visa', 'mastercard', 'amex']),
                                        'last4' => $this->faker->numerify('####'),
                                        'exp_month' => $this->faker->numberBetween(1, 12),
                                        'exp_year' => $this->faker->numberBetween(2024, 2030),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);

            case 'paypal':
                return array_merge($baseResponse, [
                    'id' => 'PAYID-' . $this->faker->regexify('[A-Z0-9]{13}'),
                    'intent' => 'CAPTURE',
                    'status' => strtoupper($status),
                    'payer' => [
                        'email_address' => $this->faker->email(),
                        'payer_id' => $this->faker->regexify('[A-Z0-9]{13}'),
                        'name' => [
                            'given_name' => $this->faker->firstName(),
                            'surname' => $this->faker->lastName(),
                        ],
                    ],
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => $baseResponse['currency'],
                                'value' => number_format($amount, 2, '.', ''),
                            ],
                        ],
                    ],
                ]);

            case 'mobile_money':
                return array_merge($baseResponse, [
                    'transaction_id' => 'MM' . $this->faker->numerify('##########'),
                    'provider' => $this->faker->randomElement(['MTN Mobile Money', 'Vodafone Cash', 'AirtelTigo Money']),
                    'phone_number' => $this->faker->phoneNumber(),
                    'reference_code' => $this->faker->regexify('[A-Z0-9]{8}'),
                ]);

            case 'bank_transfer':
                return array_merge($baseResponse, [
                    'transaction_id' => 'BT' . $this->faker->numerify('##########'),
                    'bank_name' => $this->faker->randomElement(['Chase Bank', 'Bank of America', 'Wells Fargo', 'GCB Bank']),
                    'account_number' => 'XXX-' . $this->faker->numerify('####'),
                    'routing_number' => $this->faker->numerify('#########'),
                    'reference_number' => $this->faker->regexify('[A-Z0-9]{12}'),
                ]);

            case 'credit_card':
            default:
                return array_merge($baseResponse, [
                    'transaction_id' => 'CC' . $this->faker->numerify('##########'),
                    'card_type' => $this->faker->randomElement(['visa', 'mastercard', 'amex', 'discover']),
                    'last_four' => $this->faker->numerify('####'),
                    'authorization_code' => $this->faker->regexify('[A-Z0-9]{6}'),
                    'avs_result' => $this->faker->randomElement(['Y', 'N', 'X']),
                    'cvv_result' => $this->faker->randomElement(['M', 'N', 'X']),
                ]);
        }
    }

    /**
     * Generate payment reference based on method
     */
    private function generateReference($method): string
    {
        switch ($method) {
            case 'stripe':
                return 'pi_' . $this->faker->regexify('[A-Za-z0-9]{24}');
            case 'paypal':
                return 'PAYID-' . $this->faker->regexify('[A-Z0-9]{13}');
            case 'mobile_money':
                return 'MM' . $this->faker->numerify('##########');
            case 'bank_transfer':
                return 'BT' . $this->faker->numerify('##########');
            case 'credit_card':
            default:
                return 'PAY-' . $this->faker->regexify('[A-Z0-9]{12}');
        }
    }

    /**
     * Create a successful payment
     */
    public function succeeded(): static
    {
        return $this->state([
            'status' => 'succeeded',
        ])->afterMaking(function (Payment $payment) {
            $payment->paid_at = $this->faker->dateTimeBetween('-1 month', 'now');
            $payment->gateway_response = array_merge($payment->gateway_response, [
                'status' => 'succeeded',
                'success' => true,
                'processed_at' => $payment->paid_at->toISOString(),
            ]);
        });
    }

    /**
     * Create a failed payment
     */
    public function failed(): static
    {
        return $this->state([
            'status' => 'failed',
            'paid_at' => null,
        ])->afterMaking(function (Payment $payment) {
            $payment->gateway_response = array_merge($payment->gateway_response, [
                'status' => 'failed',
                'error' => [
                    'code' => $this->faker->randomElement(['card_declined', 'insufficient_funds', 'expired_card', 'incorrect_cvc']),
                    'message' => $this->faker->randomElement([
                        'Your card was declined.',
                        'Insufficient funds in account.',
                        'Your card has expired.',
                        'Your card\'s security code is incorrect.',
                    ]),
                ],
            ]);
        });
    }

    /**
     * Create a pending payment
     */
    public function pending(): static
    {
        return $this->state([
            'status' => 'pending',
            'paid_at' => null,
        ]);
    }

    /**
     * Create a processing payment
     */
    public function processing(): static
    {
        return $this->state([
            'status' => 'processing',
            'paid_at' => null,
        ]);
    }

    /**
     * Create a refunded payment
     */
    public function refunded(): static
    {
        return $this->state([
            'status' => 'refunded',
        ])->afterMaking(function (Payment $payment) {
            $payment->paid_at = $this->faker->dateTimeBetween('-2 months', '-1 week');
            $payment->gateway_response = array_merge($payment->gateway_response, [
                'status' => 'refunded',
                'refund_id' => 're_' . $this->faker->regexify('[A-Za-z0-9]{24}'),
                'refund_amount' => $payment->amount,
                'refunded_at' => $this->faker->dateTimeBetween($payment->paid_at, 'now')->toISOString(),
                'refund_reason' => $this->faker->randomElement(['requested_by_customer', 'duplicate', 'fraudulent']),
            ]);
        });
    }

    /**
     * Create a Stripe payment
     */
    public function stripe(): static
    {
        return $this->state([
            'method' => 'stripe',
        ])->afterMaking(function (Payment $payment) {
            $payment->reference = 'pi_' . $this->faker->regexify('[A-Za-z0-9]{24}');
        });
    }

    /**
     * Create a PayPal payment
     */
    public function paypal(): static
    {
        return $this->state([
            'method' => 'paypal',
        ])->afterMaking(function (Payment $payment) {
            $payment->reference = 'PAYID-' . $this->faker->regexify('[A-Z0-9]{13}');
        });
    }

    /**
     * Create a mobile money payment
     */
    public function mobileMoney(): static
    {
        return $this->state([
            'method' => 'mobile_money',
            'currency' => 'GHS', // Mobile money typically in local currency
        ])->afterMaking(function (Payment $payment) {
            $payment->reference = 'MM' . $this->faker->numerify('##########');
        });
    }

    /**
     * Create a bank transfer payment
     */
    public function bankTransfer(): static
    {
        return $this->state([
            'method' => 'bank_transfer',
        ])->afterMaking(function (Payment $payment) {
            $payment->reference = 'BT' . $this->faker->numerify('##########');
        });
    }

    /**
     * Create a credit card payment
     */
    public function creditCard(): static
    {
        return $this->state([
            'method' => 'credit_card',
        ])->afterMaking(function (Payment $payment) {
            $payment->reference = 'PAY-' . $this->faker->regexify('[A-Z0-9]{12}');
        });
    }

    /**
     * Create a large amount payment
     */
    public function largeAmount(): static
    {
        return $this->afterMaking(function (Payment $payment) {
            $payment->amount = $this->faker->randomFloat(2, 5000, 50000);
        });
    }

    /**
     * Create a small amount payment
     */
    public function smallAmount(): static
    {
        return $this->afterMaking(function (Payment $payment) {
            $payment->amount = $this->faker->randomFloat(2, 1, 100);
        });
    }

    /**
     * Create a recent payment (within last 7 days)
     */
    public function recent(): static
    {
        return $this->afterMaking(function (Payment $payment) {
            if ($payment->status === 'succeeded') {
                $payment->paid_at = $this->faker->dateTimeBetween('-7 days', 'now');
            }
            $payment->created_at = $this->faker->dateTimeBetween('-7 days', 'now');
        });
    }

    /**
     * Create an old payment (older than 6 months)
     */
    public function old(): static
    {
        return $this->afterMaking(function (Payment $payment) {
            $oldDate = $this->faker->dateTimeBetween('-2 years', '-6 months');
            if ($payment->status === 'succeeded') {
                $payment->paid_at = $oldDate;
            }
            $payment->created_at = $oldDate;
        });
    }
}
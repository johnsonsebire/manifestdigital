<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentGateways\PaystackGateway;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Get payment gateway instance by name.
     */
    public function getGateway(string $gateway): PaymentGateway
    {
        return match($gateway) {
            'paystack' => new PaystackGateway(),
            // Add more gateways here as needed
            // 'stripe' => new StripeGateway(),
            // 'paypal' => new PayPalGateway(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}"),
        };
    }

    /**
     * Initialize payment for an order.
     */
    public function initializePayment(Order $order, ?string $gateway = null): array
    {
        $gateway = $gateway ?? $order->payment_method;
        
        if ($gateway === 'bank_transfer') {
            return $this->handleBankTransfer($order);
        }

        try {
            $paymentGateway = $this->getGateway($gateway);
            $result = $paymentGateway->initializePayment($order);

            if ($result['success']) {
                // Update order status to initiated (payment process started)
                $order->update(['status' => 'initiated']);
                
                Log::info('Payment initialized', [
                    'order_id' => $order->id,
                    'gateway' => $gateway,
                    'reference' => $result['reference'] ?? null,
                ]);
            }

            return $result;
            
        } catch (\Exception $e) {
            Log::error('Payment initialization failed', [
                'order_id' => $order->id,
                'gateway' => $gateway,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to initialize payment. Please try again.',
            ];
        }
    }

    /**
     * Verify a payment.
     */
    public function verifyPayment(string $reference, string $gateway): array
    {
        try {
            $paymentGateway = $this->getGateway($gateway);
            return $paymentGateway->verifyPayment($reference);
            
        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'reference' => $reference,
                'gateway' => $gateway,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to verify payment. Please contact support.',
            ];
        }
    }

    /**
     * Handle bank transfer payment method.
     */
    protected function handleBankTransfer(Order $order): array
    {
        // Create a pending payment record for bank transfer
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total,
            'currency' => $order->currency ?? 'NGN',
            'method' => 'bank_transfer',
            'reference' => 'BT-' . $order->uuid . '-' . time(),
            'status' => 'pending',
            'gateway_response' => [
                'payment_method' => 'bank_transfer',
                'instructions' => 'Please make payment to the bank account details provided.',
            ],
        ]);

        // Update order status
        $order->update(['status' => 'initiated']);

        return [
            'success' => true,
            'payment_method' => 'bank_transfer',
            'reference' => $payment->reference,
            'instructions' => $this->getBankTransferInstructions(),
        ];
    }

    /**
     * Get bank transfer instructions.
     */
    protected function getBankTransferInstructions(): array
    {
        return [
            'bank_name' => config('services.bank_transfer.bank_name', 'Your Bank Name'),
            'account_name' => config('services.bank_transfer.account_name', 'Your Business Name'),
            'account_number' => config('services.bank_transfer.account_number', '0000000000'),
            'note' => 'Please use your order number as the payment reference.',
        ];
    }

    /**
     * Process webhook from payment gateway.
     */
    public function processWebhook(string $gateway, array $payload, ?string $signature = null): bool
    {
        try {
            $paymentGateway = $this->getGateway($gateway);

            // Validate webhook signature
            if (!$paymentGateway->validateWebhookSignature($payload, $signature)) {
                Log::warning('Invalid webhook signature', [
                    'gateway' => $gateway,
                ]);
                return false;
            }

            // Handle webhook
            return $paymentGateway->handleWebhook($payload);
            
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'gateway' => $gateway,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Refund a payment.
     */
    public function refundPayment(Payment $payment, ?float $amount = null, ?string $reason = null): array
    {
        try {
            $paymentGateway = $this->getGateway($payment->method);
            $result = $paymentGateway->refundPayment($payment, $amount, $reason);

            if ($result['success']) {
                // Update payment status
                $payment->update([
                    'status' => 'refunded',
                    'gateway_response' => array_merge(
                        $payment->gateway_response ?? [],
                        ['refund' => $result['data'] ?? []]
                    ),
                ]);

                // Update order payment status
                $payment->order->update(['payment_status' => 'refunded']);
                
                Log::info('Payment refunded', [
                    'payment_id' => $payment->id,
                    'amount' => $amount ?? $payment->amount,
                ]);
            }

            return $result;
            
        } catch (\Exception $e) {
            Log::error('Payment refund failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to process refund. Please try again.',
            ];
        }
    }

    /**
     * Get available payment gateways.
     */
    public function getAvailableGateways(): array
    {
        $gateways = [];

        // Check if Paystack is configured
        if (config('services.paystack.secret_key')) {
            $gateways[] = [
                'name' => 'paystack',
                'label' => 'Paystack',
                'currencies' => ['NGN', 'GHS', 'ZAR', 'USD'],
            ];
        }

        // Always available
        $gateways[] = [
            'name' => 'bank_transfer',
            'label' => 'Bank Transfer',
            'currencies' => ['NGN', 'USD'],
        ];

        return $gateways;
    }
}

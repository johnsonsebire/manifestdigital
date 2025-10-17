<?php

namespace App\Services\PaymentGateways;

use App\Contracts\PaymentGateway;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaystackGateway implements PaymentGateway
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');
        $this->baseUrl = 'https://api.paystack.co';
    }

    /**
     * {@inheritDoc}
     */
    public function initializePayment(Order $order, array $metadata = []): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->post("{$this->baseUrl}/transaction/initialize", [
                    'email' => $order->customer_email,
                    'amount' => $order->total_amount * 100, // Paystack uses kobo (smallest currency unit)
                    'currency' => $order->currency ?? 'NGN',
                    'reference' => $this->generateReference($order),
                    'callback_url' => route('payment.callback', ['gateway' => 'paystack']),
                    'metadata' => array_merge([
                        'order_uuid' => $order->uuid,
                        'order_id' => $order->id,
                        'customer_name' => $order->customer_name,
                        'customer_phone' => $order->customer_phone,
                    ], $metadata),
                    'channels' => ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
                ]);

            if ($response->successful() && $response->json('status')) {
                $data = $response->json('data');
                
                // Create pending payment record
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'currency' => $order->currency ?? 'NGN',
                    'method' => 'paystack',
                    'reference' => $data['reference'],
                    'status' => 'pending',
                    'gateway_response' => $response->json(),
                ]);

                return [
                    'success' => true,
                    'authorization_url' => $data['authorization_url'],
                    'access_code' => $data['access_code'],
                    'reference' => $data['reference'],
                ];
            }

            Log::error('Paystack initialization failed', [
                'response' => $response->json(),
                'order_id' => $order->id,
            ]);

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Payment initialization failed',
            ];

        } catch (\Exception $e) {
            Log::error('Paystack initialization exception', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while initializing payment',
            ];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function verifyPayment(string $reference): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get("{$this->baseUrl}/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('status')) {
                return [
                    'success' => true,
                    'data' => $response->json('data'),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Payment verification failed',
            ];

        } catch (\Exception $e) {
            Log::error('Paystack verification exception', [
                'error' => $e->getMessage(),
                'reference' => $reference,
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while verifying payment',
            ];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function handleWebhook(array $payload): bool
    {
        try {
            $event = $payload['event'] ?? null;
            $data = $payload['data'] ?? [];

            if (!$event) {
                Log::warning('Paystack webhook: No event type');
                return false;
            }

            switch ($event) {
                case 'charge.success':
                    return $this->handleSuccessfulCharge($data);
                    
                case 'charge.failed':
                    return $this->handleFailedCharge($data);
                    
                default:
                    Log::info('Paystack webhook: Unhandled event', ['event' => $event]);
                    return true; // Return true to acknowledge receipt
            }

        } catch (\Exception $e) {
            Log::error('Paystack webhook handling exception', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return false;
        }
    }

    /**
     * Handle successful charge webhook.
     */
    protected function handleSuccessfulCharge(array $data): bool
    {
        $reference = $data['reference'] ?? null;
        
        if (!$reference) {
            Log::warning('Paystack webhook: No reference in successful charge');
            return false;
        }

        $payment = Payment::where('reference', $reference)->first();

        if (!$payment) {
            Log::warning('Paystack webhook: Payment not found', ['reference' => $reference]);
            return false;
        }

        // Prevent duplicate processing
        if ($payment->status === 'succeeded') {
            Log::info('Paystack webhook: Payment already processed', ['reference' => $reference]);
            return true;
        }

        // Update payment record
        $payment->update([
            'status' => 'succeeded',
            'paid_at' => now(),
            'gateway_response' => $data,
        ]);

        // Update order using OrderService
        $order = $payment->order;
        $orderService = app(\App\Services\OrderService::class);
        $orderService->markAsPaid($order);

        // Fire payment succeeded event
        event(new \App\Events\PaymentSucceeded($payment, $order));

        Log::info('Paystack webhook: Payment succeeded', [
            'reference' => $reference,
            'order_id' => $order->id,
        ]);

        return true;
    }

    /**
     * Handle failed charge webhook.
     */
    protected function handleFailedCharge(array $data): bool
    {
        $reference = $data['reference'] ?? null;
        
        if (!$reference) {
            Log::warning('Paystack webhook: No reference in failed charge');
            return false;
        }

        $payment = Payment::where('reference', $reference)->first();

        if (!$payment) {
            Log::warning('Paystack webhook: Payment not found', ['reference' => $reference]);
            return false;
        }

        // Update payment record
        $payment->update([
            'status' => 'failed',
            'gateway_response' => $data,
        ]);

        // Fire payment failed event
        event(new \App\Events\PaymentFailed($payment, $payment->order));

        Log::info('Paystack webhook: Payment failed', [
            'reference' => $reference,
            'order_id' => $payment->order_id,
        ]);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function validateWebhookSignature(array $payload, ?string $signature = null): bool
    {
        if (!$signature) {
            return false;
        }

        $computedSignature = hash_hmac('sha512', json_encode($payload), $this->secretKey);
        
        return hash_equals($computedSignature, $signature);
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'paystack';
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedCurrencies(): array
    {
        return ['NGN', 'GHS', 'ZAR', 'USD'];
    }

    /**
     * {@inheritDoc}
     */
    public function refundPayment(Payment $payment, ?float $amount = null, ?string $reason = null): array
    {
        try {
            $refundAmount = $amount ?? $payment->amount;
            
            $response = Http::withToken($this->secretKey)
                ->post("{$this->baseUrl}/refund", [
                    'transaction' => $payment->reference,
                    'amount' => $refundAmount * 100, // Convert to kobo
                    'currency' => $payment->currency,
                    'customer_note' => $reason,
                    'merchant_note' => $reason,
                ]);

            if ($response->successful() && $response->json('status')) {
                Log::info('Paystack refund successful', [
                    'payment_id' => $payment->id,
                    'amount' => $refundAmount,
                ]);

                return [
                    'success' => true,
                    'data' => $response->json('data'),
                ];
            }

            Log::error('Paystack refund failed', [
                'response' => $response->json(),
                'payment_id' => $payment->id,
            ]);

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Refund failed',
            ];

        } catch (\Exception $e) {
            Log::error('Paystack refund exception', [
                'error' => $e->getMessage(),
                'payment_id' => $payment->id,
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while processing refund',
            ];
        }
    }

    /**
     * Generate a unique payment reference.
     */
    protected function generateReference(Order $order): string
    {
        return 'ORD-' . $order->uuid . '-' . Str::upper(Str::random(6));
    }
}

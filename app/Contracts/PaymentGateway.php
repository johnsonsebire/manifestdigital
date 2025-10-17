<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGateway
{
    /**
     * Initialize a payment transaction.
     * 
     * @param Order $order
     * @param array $metadata Additional data to pass to gateway
     * @return array Payment data including authorization URL, reference, etc.
     */
    public function initializePayment(Order $order, array $metadata = []): array;

    /**
     * Verify a payment transaction.
     * 
     * @param string $reference Payment reference from gateway
     * @return array Payment verification response
     */
    public function verifyPayment(string $reference): array;

    /**
     * Handle webhook callback from payment gateway.
     * 
     * @param array $payload Webhook payload
     * @return bool Whether the webhook was successfully processed
     */
    public function handleWebhook(array $payload): bool;

    /**
     * Get the payment gateway name.
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Validate webhook signature/authentication.
     * 
     * @param array $payload
     * @param string|null $signature
     * @return bool
     */
    public function validateWebhookSignature(array $payload, ?string $signature = null): bool;

    /**
     * Get supported currencies.
     * 
     * @return array
     */
    public function getSupportedCurrencies(): array;

    /**
     * Refund a payment.
     * 
     * @param Payment $payment
     * @param float|null $amount Amount to refund (null for full refund)
     * @param string|null $reason Refund reason
     * @return array Refund response
     */
    public function refundPayment(Payment $payment, ?float $amount = null, ?string $reason = null): array;
}

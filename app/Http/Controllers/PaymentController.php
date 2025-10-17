<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Initiate payment for an order.
     */
    public function initiate(Request $request, string $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        // Check if order can be paid
        if ($order->payment_status === 'paid') {
            return redirect()
                ->route('checkout.success', $uuid)
                ->with('warning', 'This order has already been paid.');
        }

        if (!in_array($order->status, ['pending', 'initiated'])) {
            return redirect()
                ->route('checkout.success', $uuid)
                ->with('error', 'Payment cannot be initiated for this order.');
        }

        // Initialize payment
        $result = $this->paymentService->initializePayment($order);

        if (!$result['success']) {
            return back()
                ->with('error', $result['message'] ?? 'Failed to initialize payment.');
        }

        // Handle bank transfer
        if ($result['payment_method'] ?? null === 'bank_transfer') {
            return redirect()
                ->route('payment.bank-transfer', ['uuid' => $uuid])
                ->with('bank_transfer_info', $result['instructions']);
        }

        // Redirect to payment gateway
        if (isset($result['authorization_url'])) {
            return redirect($result['authorization_url']);
        }

        return back()->with('error', 'Unable to redirect to payment gateway.');
    }

    /**
     * Handle payment callback from gateway.
     */
    public function callback(Request $request, string $gateway)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        if (!$reference) {
            return redirect()
                ->route('services.index')
                ->with('error', 'Invalid payment reference.');
        }

        // Verify payment
        $result = $this->paymentService->verifyPayment($reference, $gateway);

        if (!$result['success']) {
            Log::warning('Payment verification failed', [
                'reference' => $reference,
                'gateway' => $gateway,
            ]);

            return redirect()
                ->route('services.index')
                ->with('error', 'Payment verification failed. Please contact support if you made a payment.');
        }

        // Find payment record
        $payment = Payment::where('reference', $reference)->first();

        if (!$payment) {
            return redirect()
                ->route('services.index')
                ->with('error', 'Payment record not found.');
        }

        $verificationData = $result['data'] ?? [];
        
        // Check payment status from verification
        $status = $verificationData['status'] ?? null;

        if ($status === 'success') {
            // Update payment if not already updated by webhook
            if ($payment->status !== 'succeeded') {
                $payment->update([
                    'status' => 'succeeded',
                    'paid_at' => now(),
                    'gateway_response' => $verificationData,
                ]);

                // Update order
                $payment->order->update([
                    'payment_status' => 'paid',
                    'status' => 'initiated',
                ]);

                // Fire event if not already fired
                event(new \App\Events\PaymentSucceeded($payment, $payment->order));
            }

            return redirect()
                ->route('checkout.success', $payment->order->uuid)
                ->with('success', 'Payment successful! Your order has been confirmed.');
        }

        // Payment failed or pending
        return redirect()
            ->route('checkout.index')
            ->with('error', 'Payment was not successful. Please try again.');
    }

    /**
     * Handle webhook from payment gateway.
     */
    public function webhook(Request $request, string $gateway)
    {
        // Get signature from header (specific to each gateway)
        $signature = match($gateway) {
            'paystack' => $request->header('X-Paystack-Signature'),
            // 'stripe' => $request->header('Stripe-Signature'),
            default => null,
        };

        $payload = $request->all();

        // Process webhook
        $success = $this->paymentService->processWebhook($gateway, $payload, $signature);

        if ($success) {
            return response()->json(['message' => 'Webhook processed'], 200);
        }

        return response()->json(['message' => 'Webhook processing failed'], 400);
    }

    /**
     * Show bank transfer instructions.
     */
    public function bankTransfer(string $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        // Get payment record
        $payment = $order->payments()
            ->where('method', 'bank_transfer')
            ->latest()
            ->first();

        if (!$payment) {
            return redirect()
                ->route('checkout.success', $uuid)
                ->with('error', 'Payment record not found.');
        }

        $bankInfo = session('bank_transfer_info', [
            'bank_name' => config('services.bank_transfer.bank_name', 'Your Bank Name'),
            'account_name' => config('services.bank_transfer.account_name', 'Your Business Name'),
            'account_number' => config('services.bank_transfer.account_number', '0000000000'),
            'note' => 'Please use your order number as the payment reference.',
        ]);

        return view('payment.bank-transfer', compact('order', 'payment', 'bankInfo'));
    }

    /**
     * Verify payment manually (for admin).
     */
    public function verify(Request $request, Payment $payment)
    {
        $this->authorize('update', $payment->order);

        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($request->action === 'approve') {
            $payment->update([
                'status' => 'succeeded',
                'paid_at' => now(),
                'gateway_response' => array_merge(
                    $payment->gateway_response ?? [],
                    [
                        'manual_verification' => true,
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                        'notes' => $request->notes,
                    ]
                ),
            ]);

            $payment->order->update([
                'payment_status' => 'paid',
                'status' => 'initiated',
            ]);

            event(new \App\Events\PaymentSucceeded($payment, $payment->order));

            return back()->with('success', 'Payment has been approved.');
        }

        // Reject payment
        $payment->update([
            'status' => 'failed',
            'gateway_response' => array_merge(
                $payment->gateway_response ?? [],
                [
                    'manual_verification' => true,
                    'rejected_by' => auth()->id(),
                    'rejected_at' => now(),
                    'notes' => $request->notes,
                ]
            ),
        ]);

        event(new \App\Events\PaymentFailed($payment, $payment->order));

        return back()->with('success', 'Payment has been rejected.');
    }
}

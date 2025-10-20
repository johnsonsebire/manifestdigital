<x-layouts.app title="Processing Payment">
    @push('styles')
        <style>
            .payment-processing {
                min-height: 60vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }
            .payment-processing-content {
                text-align: center;
                max-width: 500px;
            }
            .payment-loader {
                margin-bottom: 2rem;
            }
            .spinner {
                border: 4px solid #f3f4f6;
                border-top: 4px solid #3b82f6;
                border-radius: 50%;
                width: 60px;
                height: 60px;
                animation: spin 1s linear infinite;
                margin: 0 auto;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .payment-processing-text h2 {
                font-size: 1.5rem;
                font-weight: 600;
                color: #111827;
                margin-bottom: 0.5rem;
            }
            .dark .payment-processing-text h2 {
                color: #f9fafb;
            }
            .payment-processing-text p {
                color: #6b7280;
                margin-bottom: 0.5rem;
            }
            .dark .payment-processing-text p {
                color: #9ca3af;
            }
            .order-number {
                font-weight: 600;
                color: #3b82f6;
            }
        </style>
    @endpush

    <div class="payment-processing">
        <div class="payment-processing-content">
            <!-- Loading Spinner -->
            <div class="payment-loader">
                <div class="spinner"></div>
            </div>
            
            <div class="payment-processing-text">
                <h2>Processing Renewal Payment</h2>
                <p>Please wait while we redirect you to the payment gateway...</p>
                <p class="order-number">Renewal Order #{{ $order->order_number }}</p>
            </div>

            <!-- Auto-submit form -->
            <form id="paymentForm" method="POST" action="{{ route('payment.initiate', $order->uuid) }}" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-submit the form after a brief delay
        setTimeout(function() {
            document.getElementById('paymentForm').submit();
        }, 1500);
    </script>
    @endpush
</x-layouts.app>

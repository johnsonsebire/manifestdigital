<x-layouts.frontend>
    @push('styles')
        @vite('resources/css/checkout.css')
    @endpush

    <div class="payment-processing">
        <div class="payment-processing-content">
            <!-- Loading Spinner -->
            <div class="payment-loader">
                <div class="spinner"></div>
            </div>
            
            <div class="payment-processing-text">
                <h2>Processing Payment</h2>
                <p>Please wait while we redirect you to the payment gateway...</p>
                <p class="order-number">Order #{{ $order->order_number }}</p>
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
        }, 1000);
    </script>
    @endpush
</x-layouts.frontend>

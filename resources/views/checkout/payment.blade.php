<x-layouts.frontend>
    <div class="min-h-screen flex items-center justify-center bg-zinc-50 dark:bg-zinc-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <!-- Loading Spinner -->
            <div class="flex justify-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600"></div>
            </div>
            
            <div>
                <h2 class="text-3xl font-extrabold text-zinc-900 dark:text-white">
                    Processing Payment
                </h2>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Please wait while we redirect you to the payment gateway...
                </p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">
                    Order #{{ $order->order_number }}
                </p>
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

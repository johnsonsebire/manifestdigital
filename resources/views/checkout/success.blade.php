<x-layouts.frontend :title="'Order Confirmation | Manifest Digital'">
    {{-- Success Hero Section --}}
    <section class="bg-gradient-to-br from-green-600 via-green-500 to-emerald-500 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            {{-- Success Icon --}}
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-6">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-4">Order Placed Successfully!</h1>
            <p class="text-xl text-green-50 mb-6">
                Thank you for your order. We've received your request and will get started right away.
            </p>
            <p class="text-lg text-green-100">
                Order Number: <strong class="font-mono">{{ $order->uuid }}</strong>
            </p>
        </div>
    </section>

    {{-- Order Details Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- Order Status --}}
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Order Details</h2>
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 font-semibold rounded-full">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Order Information</h3>
                        <p class="text-gray-900"><strong>Order ID:</strong> {{ $order->uuid }}</p>
                        <p class="text-gray-900"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                        <p class="text-gray-900"><strong>Payment Status:</strong> 
                            <span class="px-2 py-1 text-xs rounded {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                        <p class="text-gray-900"><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Customer Information</h3>
                        <p class="text-gray-900"><strong>Name:</strong> {{ $order->customer_name }}</p>
                        <p class="text-gray-900"><strong>Email:</strong> {{ $order->customer_email }}</p>
                        @if($order->customer_phone)
                            <p class="text-gray-900"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                        @endif
                        @if($order->customer_address)
                            <p class="text-gray-900"><strong>Address:</strong> {{ $order->customer_address }}</p>
                        @endif
                    </div>
                </div>

                {{-- Payment Required Banner --}}
                @if($order->payment_status === 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-lg font-bold text-yellow-900 mb-2">Payment Required</h3>
                            <p class="text-yellow-800 mb-4">
                                Your order has been placed, but payment is still pending. Click the button below to complete your payment.
                            </p>
                            <form action="{{ route('payment.initiate', $order->uuid) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-lg transition shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Proceed to Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                {{-- What Happens Next --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <h3 class="font-bold text-blue-900 mb-2">What happens next?</h3>
                    <ul class="text-blue-800 space-y-1 text-sm">
                        <li>✓ You'll receive a confirmation email shortly at <strong>{{ $order->customer_email }}</strong></li>
                        <li>✓ Our team will review your order and get in touch within 24 hours</li>
                        @if($order->payment_status === 'pending')
                            <li>✓ Complete the payment to start processing your order</li>
                        @elseif($order->payment_status === 'paid')
                            <li>✓ Payment received! Your order is being processed</li>
                        @endif
                        <li>✓ Once approved, we'll create a project and you can track progress in your dashboard</li>
                    </ul>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Items</h2>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-0">
                            <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex-shrink-0 flex items-center justify-center">
                                @if($item->service && $item->service->image_url)
                                    <img src="{{ $item->service->image_url }}" alt="{{ $item->snapshot['service_title'] ?? $item->service->title }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">
                                    {{ $item->snapshot['service_title'] ?? ($item->service->title ?? 'Service') }}
                                </h3>
                                @if($item->snapshot['variant_name'])
                                    <p class="text-sm text-gray-600">Variant: {{ $item->snapshot['variant_name'] }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-sm text-gray-600">Quantity: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</span>
                                    <span class="font-bold text-purple-600">${{ number_format($item->line_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Totals --}}
                <div class="mt-6 pt-6 border-t-2 border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->tax > 0)
                            <div class="flex justify-between text-gray-700">
                                <span>Tax</span>
                                <span class="font-semibold">${{ number_format($order->tax, 2) }}</span>
                            </div>
                        @endif
                        @if($order->discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span class="font-semibold">-${{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-2xl font-bold pt-2 border-t border-gray-200">
                            <span class="text-gray-900">Total</span>
                            <span class="text-purple-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Notes --}}
            @if($order->notes)
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Order Notes</h3>
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-8 rounded-lg transition-colors duration-200">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-8 rounded-lg transition-colors duration-200">
                        Create Account to Track Order
                    </a>
                @endauth
                
                <a href="{{ route('services.index') }}" class="text-center border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-4 px-8 rounded-lg transition-colors duration-200">
                    Browse More Services
                </a>
            </div>

            {{-- Help Section --}}
            <div class="mt-12 bg-gray-100 rounded-lg p-6 text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Need Help?</h3>
                <p class="text-gray-700 mb-4">
                    If you have any questions about your order, feel free to contact us.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center text-purple-600 hover:text-purple-700 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contact Us
                    </a>
                    <a href="mailto:{{ $order->customer_email }}" class="inline-flex items-center justify-center text-purple-600 hover:text-purple-700 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Live Chat
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.frontend>

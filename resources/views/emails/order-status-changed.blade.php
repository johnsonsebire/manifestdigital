@extends('emails.layouts.app')

@section('title', 'Order Status Update')

@section('content')
    <div class="greeting">Hello {{ $notifiable->name }}!</div>
    
    <div class="content-text">
        Your order status has been updated from <strong>{{ ucfirst($oldStatus) }}</strong> to <strong>{{ ucfirst($newStatus) }}</strong>.
    </div>
    
    <div class="highlight-box">
        @php
            $statusMessages = [
                'pending' => 'Your order is pending review. We\'ll get back to you shortly.',
                'approved' => 'Great news! Your order has been approved and a project has been created for you.',
                'processing' => 'Your order is being processed by our team.',
                'completed' => 'Congratulations! Your order has been completed successfully.',
                'cancelled' => 'Your order has been cancelled. If you have questions, please contact us.',
                'paid' => 'Payment received! Your order will be processed shortly.',
            ];
        @endphp
        
        @if(isset($statusMessages[$newStatus]))
            {{ $statusMessages[$newStatus] }}
        @else
            Your order is now {{ ucfirst($newStatus) }}.
        @endif
    </div>
    
    <table class="info-table">
        <tr>
            <th>Order Details</th>
            <th>Information</th>
        </tr>
        <tr>
            <td><strong>Order ID</strong></td>
            <td>#{{ $order->id }}</td>
        </tr>
        <tr>
            <td><strong>Order Date</strong></td>
            <td>{{ $order->created_at->format('F d, Y g:i A') }}</td>
        </tr>
        <tr>
            <td><strong>Current Status</strong></td>
            <td><span class="status-badge status-{{ $newStatus }}">{{ ucfirst($newStatus) }}</span></td>
        </tr>
        @if($order->total_amount)
        <tr>
            <td><strong>Order Total</strong></td>
            <td>${{ number_format($order->total_amount, 2) }}</td>
        </tr>
        @endif
    </table>
    
    <div class="button-container">
        <a href="{{ app()->environment('local', 'staging') ? '#order-details' : route('customer.orders.show', $order) }}" class="email-button">
            View Order Details
        </a>
    </div>
    
    <div class="content-text">
        You can track your order progress and communicate with our team through your customer dashboard.
    </div>
@endsection
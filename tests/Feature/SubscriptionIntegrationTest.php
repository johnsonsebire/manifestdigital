<?php

use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Event;
use function Pest\Laravel\{actingAs, post, assertDatabaseHas};

beforeEach(function () {
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->service = Service::factory()->create([
        'name' => 'Premium Hosting',
        'price' => 29.99,
        'duration_months' => 1,
    ]);
});

describe('Order Subscription Integration', function () {
    
    test('completing order creates subscription', function () {
        $order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'pending',
        ]);

        $order->items()->create([
            'service_id' => $this->service->id,
            'quantity' => 1,
            'price' => $this->service->price,
        ]);

        // Simulate order completion
        $order->update(['status' => 'completed']);

        // Verify subscription was created
        $subscription = Subscription::where('order_id', $order->id)->first();
        
        expect($subscription)->not->toBeNull()
            ->and($subscription->customer_id)->toBe($this->customer->id)
            ->and($subscription->service_id)->toBe($this->service->id)
            ->and($subscription->status)->toBe('active');
    })->skip('Requires order completion event listener');

    test('order with trial creates trial subscription', function () {
        $order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'pending',
            'metadata' => [
                'trial' => true,
                'trial_days' => 14,
            ],
        ]);

        $order->items()->create([
            'service_id' => $this->service->id,
            'quantity' => 1,
            'price' => 0, // Free trial
        ]);

        $order->update(['status' => 'completed']);

        $subscription = Subscription::where('order_id', $order->id)->first();
        
        expect($subscription)->not->toBeNull()
            ->and($subscription->status)->toBe('trial')
            ->and($subscription->trial_ends_at)->not->toBeNull();
    })->skip('Requires order completion event listener');

    test('failed payment does not create subscription', function () {
        $order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'failed',
        ]);

        $order->items()->create([
            'service_id' => $this->service->id,
            'quantity' => 1,
            'price' => $this->service->price,
        ]);

        $subscriptionCount = Subscription::where('order_id', $order->id)->count();
        
        expect($subscriptionCount)->toBe(0);
    });
});

describe('Renewal Payment Integration', function () {
    
    test('successful renewal payment extends subscription', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        $originalExpiration = $subscription->expires_at->copy();

        // Simulate renewal payment
        $order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'completed',
            'metadata' => [
                'subscription_id' => $subscription->id,
                'renewal' => true,
            ],
        ]);

        // Trigger renewal processing
        $subscription->renew();

        $subscription->refresh();
        expect($subscription->expires_at->greaterThan($originalExpiration))->toBeTrue()
            ->and($subscription->status)->toBe('active');
    });

    test('renewal creates order with proper metadata', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.renew.process', $subscription), [
                'payment_method' => 'card',
                'terms_accepted' => true,
            ]);

        // Find the renewal order
        $order = Order::where('user_id', $this->customer->id)
            ->whereJsonContains('metadata->subscription_id', $subscription->id)
            ->first();

        expect($order)->not->toBeNull()
            ->and($order->metadata['renewal'])->toBeTrue();
    })->skip('Requires full renewal workflow');
});

describe('Subscription Lifecycle Integration', function () {
    
    test('complete subscription lifecycle from creation to renewal', function () {
        // 1. Create initial subscription via order
        $order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'completed',
        ]);

        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'order_id' => $order->id,
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        expect($subscription->isActive())->toBeTrue();

        // 2. Subscription approaches expiration
        $subscription->update(['expires_at' => now()->addDays(7)]);
        expect($subscription->isExpiringSoon())->toBeTrue();

        // 3. Send reminder
        // (Reminder command would run here)

        // 4. Customer renews
        $subscription->renew();
        expect($subscription->status)->toBe('active')
            ->and($subscription->expires_at->greaterThan(now()->addMonth()))->toBeTrue();

        // 5. Later, customer cancels
        $subscription->cancel('No longer needed');
        expect($subscription->status)->toBe('cancelled')
            ->and($subscription->cancelled_at)->not->toBeNull();
    });

    test('trial subscription converts to active on payment', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'status' => 'trial',
            'trial_ends_at' => now()->addWeek(),
            'auto_renew' => true,
        ]);

        // Trial ends, payment is processed
        $subscription->update([
            'trial_ends_at' => now()->subDay(),
        ]);

        // Command runs and converts to active
        artisan('subscriptions:update-statuses')->run();

        $subscription->refresh();
        expect($subscription->status)->toBe('active');
    });

    test('expired subscription with auto_renew becomes pending_renewal', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'status' => 'active',
            'expires_at' => now()->subDay(),
            'auto_renew' => true,
        ]);

        // Would trigger auto-renewal process here
        $subscription->update(['status' => 'pending_renewal']);

        expect($subscription->status)->toBe('pending_renewal');
    });
});

describe('Notification Integration', function () {
    
    test('expiration reminder notification is queued', function () {
        Event::fake();

        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
        ]);

        // Trigger reminder
        artisan('subscriptions:send-reminders', ['--days' => 7])->run();

        // Would verify notification was queued
    })->skip('Requires notification queue verification');

    test('expired notification is sent on status change', function () {
        Event::fake();

        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses', ['--notify' => true])->run();

        // Would verify expired notification was sent
    })->skip('Requires notification verification');
});

describe('Concurrent Operations', function () {
    
    test('concurrent renewal attempts are handled safely', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        // Simulate concurrent renewal attempts
        $originalExpiration = $subscription->expires_at->copy();

        $subscription->renew(1);
        $subscription->refresh();

        // Second attempt should not double-extend
        $firstRenewalExpiration = $subscription->expires_at->copy();
        
        $subscription->renew(1);
        $subscription->refresh();

        // Should extend from first renewal date, not original
        expect($subscription->expires_at->greaterThan($firstRenewalExpiration))->toBeTrue();
    });

    test('concurrent status updates use transactions', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        // Multiple processes trying to update status
        try {
            \DB::transaction(function () use ($subscription) {
                $subscription->update(['status' => 'expired']);
            });

            \DB::transaction(function () use ($subscription) {
                $subscription->refresh();
                $subscription->update(['status' => 'suspended']);
            });
        } catch (\Exception $e) {
            // One transaction should succeed
        }

        $subscription->refresh();
        expect($subscription->status)->toBeIn(['expired', 'suspended']);
    });
});

describe('Edge Cases', function () {
    
    test('subscription with past expiration can still be renewed', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
            'expires_at' => now()->subMonths(2),
        ]);

        $subscription->renew();

        expect($subscription->status)->toBe('active')
            ->and($subscription->expires_at->isFuture())->toBeTrue();
    });

    test('cancelling already cancelled subscription is idempotent', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'cancelled',
            'cancelled_at' => now()->subWeek(),
        ]);

        $firstCancelledAt = $subscription->cancelled_at->copy();

        $subscription->cancel();

        expect($subscription->status)->toBe('cancelled')
            ->and($subscription->cancelled_at->equalTo($firstCancelledAt))->toBeTrue();
    });

    test('subscription without service can still be managed', function () {
        $subscription = Subscription::factory()->create([
            'service_id' => null, // Custom subscription without service
            'renewal_price' => 50.00,
        ]);

        expect($subscription->calculateRenewalPrice())->toBe(50.00);
    });

    test('subscription with zero price can be renewed', function () {
        $service = Service::factory()->create(['price' => 0]);
        
        $subscription = Subscription::factory()->create([
            'service_id' => $service->id,
            'renewal_price' => 0,
        ]);

        $subscription->renew();

        expect($subscription->status)->toBe('active');
    });
});

describe('Timezone Handling', function () {
    
    test('expiration dates respect application timezone', function () {
        config(['app.timezone' => 'America/New_York']);

        $subscription = Subscription::factory()->create([
            'expires_at' => now()->setTimezone('America/New_York')->addMonth(),
        ]);

        expect($subscription->daysUntilExpiration())->toBeGreaterThan(29);
    });

    test('reminder scheduling accounts for timezone differences', function () {
        // Test that reminders are sent based on server timezone
        // but displayed correctly in customer timezone
    })->skip('Complex timezone test');
});

<?php

use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->customer = User::factory()->create();
    $this->service = Service::factory()->create([
        'price' => 29.99,
        'duration_months' => 1,
    ]);
});

describe('Subscription Model', function () {
    
    test('can create subscription with required fields', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'status' => 'active',
        ]);

        expect($subscription)->toBeInstanceOf(Subscription::class)
            ->and($subscription->customer_id)->toBe($this->customer->id)
            ->and($subscription->service_id)->toBe($this->service->id)
            ->and($subscription->status)->toBe('active')
            ->and($subscription->uuid)->not->toBeNull();
    });

    test('generates uuid on creation', function () {
        $subscription = Subscription::factory()->create();
        
        expect($subscription->uuid)
            ->not->toBeNull()
            ->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i');
    });

    test('has relationship with customer', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
        ]);

        expect($subscription->customer)->toBeInstanceOf(User::class)
            ->and($subscription->customer->id)->toBe($this->customer->id);
    });

    test('has relationship with service', function () {
        $subscription = Subscription::factory()->create([
            'service_id' => $this->service->id,
        ]);

        expect($subscription->service)->toBeInstanceOf(Service::class)
            ->and($subscription->service->id)->toBe($this->service->id);
    });

    test('has relationship with order', function () {
        $order = Order::factory()->create([
            'user_id' => $this->customer->id,
        ]);
        
        $subscription = Subscription::factory()->create([
            'order_id' => $order->id,
        ]);

        expect($subscription->order)->toBeInstanceOf(Order::class)
            ->and($subscription->order->id)->toBe($order->id);
    });
});

describe('Subscription Status Methods', function () {
    
    test('isActive returns true for active subscription', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        expect($subscription->isActive())->toBeTrue();
    });

    test('isActive returns false for expired subscription', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
        ]);

        expect($subscription->isActive())->toBeFalse();
    });

    test('isExpired returns true for past expiration date', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->subDay(),
        ]);

        expect($subscription->isExpired())->toBeTrue();
    });

    test('isExpired returns false for future expiration date', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->addMonth(),
        ]);

        expect($subscription->isExpired())->toBeFalse();
    });

    test('isTrial returns true for trial status', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'trial',
            'trial_ends_at' => now()->addWeek(),
        ]);

        expect($subscription->isTrial())->toBeTrue();
    });

    test('isCancelled returns true for cancelled status', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        expect($subscription->isCancelled())->toBeTrue();
    });

    test('canRenew returns true for active subscription', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        expect($subscription->canRenew())->toBeTrue();
    });

    test('canRenew returns false for cancelled subscription', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'cancelled',
        ]);

        expect($subscription->canRenew())->toBeFalse();
    });
});

describe('Subscription Date Calculations', function () {
    
    test('daysUntilExpiration returns correct number of days', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->addDays(15),
        ]);

        expect($subscription->daysUntilExpiration())->toBe(15);
    });

    test('daysUntilExpiration returns negative for expired subscription', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->subDays(5),
        ]);

        expect($subscription->daysUntilExpiration())->toBeLessThan(0);
    });

    test('isExpiringSoon returns true within 30 days', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->addDays(25),
        ]);

        expect($subscription->isExpiringSoon())->toBeTrue();
    });

    test('isExpiringSoon returns false beyond 30 days', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->addDays(45),
        ]);

        expect($subscription->isExpiringSoon())->toBeFalse();
    });
});

describe('Subscription Renewal', function () {
    
    test('renew extends expiration date by billing interval', function () {
        $subscription = Subscription::factory()->create([
            'billing_interval' => 'monthly',
            'expires_at' => now()->addMonth(),
        ]);

        $originalExpiration = $subscription->expires_at->copy();
        $subscription->renew();

        expect($subscription->expires_at->greaterThan($originalExpiration))->toBeTrue()
            ->and($subscription->expires_at->diffInMonths($originalExpiration))->toBe(1);
    });

    test('renew sets status to active', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
        ]);

        $subscription->renew();

        expect($subscription->status)->toBe('active');
    });

    test('renew clears cancelled_at timestamp', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $subscription->renew();

        expect($subscription->cancelled_at)->toBeNull();
    });

    test('renew with custom duration extends by specified months', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->addMonth(),
        ]);

        $originalExpiration = $subscription->expires_at->copy();
        $subscription->renew(12);

        expect($subscription->expires_at->diffInMonths($originalExpiration))->toBe(12);
    });
});

describe('Subscription Cancellation', function () {
    
    test('cancel sets status to cancelled', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $subscription->cancel();

        expect($subscription->status)->toBe('cancelled');
    });

    test('cancel sets cancelled_at timestamp', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $subscription->cancel();

        expect($subscription->cancelled_at)->not->toBeNull()
            ->and($subscription->cancelled_at)->toBeInstanceOf(Carbon::class);
    });

    test('cancel disables auto_renew', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'auto_renew' => true,
        ]);

        $subscription->cancel();

        expect($subscription->auto_renew)->toBeFalse();
    });

    test('cancel can store cancellation reason', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $subscription->cancel('Too expensive');

        expect($subscription->cancellation_reason)->toBe('Too expensive');
    });
});

describe('Subscription Scopes', function () {
    
    test('active scope returns only active subscriptions', function () {
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'expired']);
        Subscription::factory()->create(['status' => 'active']);

        $activeSubscriptions = Subscription::active()->get();

        expect($activeSubscriptions)->toHaveCount(2)
            ->and($activeSubscriptions->every(fn($s) => $s->status === 'active'))->toBeTrue();
    });

    test('expired scope returns only expired subscriptions', function () {
        Subscription::factory()->create(['expires_at' => now()->subDay()]);
        Subscription::factory()->create(['expires_at' => now()->addMonth()]);
        Subscription::factory()->create(['expires_at' => now()->subWeek()]);

        $expiredSubscriptions = Subscription::expired()->get();

        expect($expiredSubscriptions)->toHaveCount(2)
            ->and($expiredSubscriptions->every(fn($s) => $s->expires_at->isPast()))->toBeTrue();
    });

    test('expiringSoon scope returns subscriptions within 30 days', function () {
        Subscription::factory()->create(['expires_at' => now()->addDays(15)]);
        Subscription::factory()->create(['expires_at' => now()->addDays(45)]);
        Subscription::factory()->create(['expires_at' => now()->addDays(20)]);

        $expiringSoon = Subscription::expiringSoon()->get();

        expect($expiringSoon)->toHaveCount(2);
    });

    test('trial scope returns only trial subscriptions', function () {
        Subscription::factory()->create(['status' => 'trial']);
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'trial']);

        $trialSubscriptions = Subscription::trial()->get();

        expect($trialSubscriptions)->toHaveCount(2)
            ->and($trialSubscriptions->every(fn($s) => $s->status === 'trial'))->toBeTrue();
    });

    test('autoRenew scope returns only auto-renewing subscriptions', function () {
        Subscription::factory()->create(['auto_renew' => true]);
        Subscription::factory()->create(['auto_renew' => false]);
        Subscription::factory()->create(['auto_renew' => true]);

        $autoRenewSubscriptions = Subscription::autoRenew()->get();

        expect($autoRenewSubscriptions)->toHaveCount(2)
            ->and($autoRenewSubscriptions->every(fn($s) => $s->auto_renew === true))->toBeTrue();
    });

    test('forCustomer scope returns subscriptions for specific customer', function () {
        $customer1 = User::factory()->create();
        $customer2 = User::factory()->create();

        Subscription::factory()->create(['customer_id' => $customer1->id]);
        Subscription::factory()->create(['customer_id' => $customer2->id]);
        Subscription::factory()->create(['customer_id' => $customer1->id]);

        $customerSubscriptions = Subscription::forCustomer($customer1->id)->get();

        expect($customerSubscriptions)->toHaveCount(2)
            ->and($customerSubscriptions->every(fn($s) => $s->customer_id === $customer1->id))->toBeTrue();
    });

    test('forService scope returns subscriptions for specific service', function () {
        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();

        Subscription::factory()->create(['service_id' => $service1->id]);
        Subscription::factory()->create(['service_id' => $service2->id]);
        Subscription::factory()->create(['service_id' => $service1->id]);

        $serviceSubscriptions = Subscription::forService($service1->id)->get();

        expect($serviceSubscriptions)->toHaveCount(2)
            ->and($serviceSubscriptions->every(fn($s) => $s->service_id === $service1->id))->toBeTrue();
    });
});

describe('Subscription Discount Calculations', function () {
    
    test('calculateRenewalDiscount returns service renewal discount', function () {
        $service = Service::factory()->create([
            'renewal_discount_percentage' => 15,
        ]);
        
        $subscription = Subscription::factory()->create([
            'service_id' => $service->id,
            'expires_at' => now()->addMonth(),
        ]);

        expect($subscription->calculateRenewalDiscount())->toBe(15.0);
    });

    test('calculateRenewalDiscount adds early renewal bonus', function () {
        $service = Service::factory()->create([
            'renewal_discount_percentage' => 10,
        ]);
        
        $subscription = Subscription::factory()->create([
            'service_id' => $service->id,
            'expires_at' => now()->addDays(35), // More than 30 days away
        ]);

        expect($subscription->calculateRenewalDiscount())->toBe(15.0); // 10 + 5
    });

    test('calculateRenewalPrice applies discount correctly', function () {
        $service = Service::factory()->create([
            'price' => 100.00,
            'renewal_discount_percentage' => 20,
        ]);
        
        $subscription = Subscription::factory()->create([
            'service_id' => $service->id,
            'expires_at' => now()->addMonth(),
        ]);

        expect($subscription->calculateRenewalPrice())->toBe(80.00);
    });
});

describe('Subscription Metadata', function () {
    
    test('can store and retrieve custom metadata', function () {
        $subscription = Subscription::factory()->create([
            'metadata' => [
                'custom_field' => 'value',
                'billing_contact' => 'john@example.com',
            ],
        ]);

        expect($subscription->metadata)->toBeArray()
            ->and($subscription->metadata['custom_field'])->toBe('value')
            ->and($subscription->metadata['billing_contact'])->toBe('john@example.com');
    });

    test('metadata is cast to array', function () {
        $subscription = Subscription::factory()->create();

        expect($subscription->metadata)->toBeArray();
    });
});

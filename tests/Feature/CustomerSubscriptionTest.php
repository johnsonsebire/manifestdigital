<?php

use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use function Pest\Laravel\{actingAs, get, post};

beforeEach(function () {
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->otherCustomer = User::factory()->create(['role' => 'customer']);
    $this->service = Service::factory()->create([
        'name' => 'Premium Hosting',
        'price' => 29.99,
        'duration_months' => 1,
        'renewal_discount_percentage' => 10,
    ]);
});

describe('Customer Subscription Dashboard', function () {
    
    test('customer can view their subscriptions', function () {
        Subscription::factory()->count(3)->create([
            'customer_id' => $this->customer->id,
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.index'));

        $response->assertOk()
            ->assertViewIs('customer.subscriptions.index')
            ->assertViewHas('subscriptions');
    });

    test('customer only sees their own subscriptions', function () {
        $mySubscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
        ]);
        $otherSubscription = Subscription::factory()->create([
            'customer_id' => $this->otherCustomer->id,
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.index'));

        $response->assertOk()
            ->assertSee($mySubscription->uuid)
            ->assertDontSee($otherSubscription->uuid);
    });

    test('guest cannot view subscriptions', function () {
        $response = get(route('customer.subscriptions.index'));

        $response->assertRedirect(route('login'));
    });
});

describe('Customer View Subscription Details', function () {
    
    test('customer can view their subscription details', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertViewIs('customer.subscriptions.show')
            ->assertViewHas('subscription')
            ->assertSee($this->service->name);
    });

    test('customer cannot view other customer subscription', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->otherCustomer->id,
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertForbidden();
    });

    test('subscription details show expiration information', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'expires_at' => now()->addDays(15),
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('Expires in 15 days');
    });

    test('subscription details show renewal options for eligible subscriptions', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('Renew Subscription');
    });
});

describe('Customer Subscription Renewal', function () {
    
    test('customer can view renewal form', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
            'service_id' => $this->service->id,
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.renew', $subscription));

        $response->assertOk()
            ->assertViewIs('customer.subscriptions.renew')
            ->assertViewHas('subscription')
            ->assertSee('Renewal Cost');
    });

    test('renewal form shows early renewal discount', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
            'service_id' => $this->service->id,
            'expires_at' => now()->addDays(35), // More than 30 days away
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.renew', $subscription));

        $response->assertOk()
            ->assertSee('Early Renewal Discount')
            ->assertSee('5%'); // Early renewal bonus
    });

    test('customer can initiate renewal', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
            'service_id' => $this->service->id,
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.renew.process', $subscription), [
                'payment_method' => 'card',
                'terms_accepted' => true,
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');
    });

    test('renewal requires terms acceptance', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.renew.process', $subscription), [
                'payment_method' => 'card',
                'terms_accepted' => false,
            ]);

        $response->assertSessionHasErrors('terms_accepted');
    });

    test('customer cannot renew other customer subscription', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->otherCustomer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.renew.process', $subscription), [
                'payment_method' => 'card',
                'terms_accepted' => true,
            ]);

        $response->assertForbidden();
    });

    test('cancelled subscription cannot be renewed', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'cancelled',
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.renew', $subscription));

        $response->assertForbidden();
    });
});

describe('Customer Subscription Cancellation', function () {
    
    test('customer can view cancellation form', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.cancel', $subscription));

        $response->assertOk()
            ->assertViewIs('customer.subscriptions.cancel')
            ->assertViewHas('subscription');
    });

    test('customer can cancel their subscription', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.cancel.process', $subscription), [
                'reason' => 'No longer needed',
                'confirmation' => true,
            ]);

        $response->assertRedirect(route('customer.subscriptions.show', $subscription))
            ->assertSessionHas('success');

        $subscription->refresh();
        expect($subscription->status)->toBe('cancelled')
            ->and($subscription->cancellation_reason)->toBe('No longer needed');
    });

    test('cancellation requires confirmation', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.cancel.process', $subscription), [
                'reason' => 'Test',
                'confirmation' => false,
            ]);

        $response->assertSessionHasErrors('confirmation');
    });

    test('customer cannot cancel other customer subscription', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->otherCustomer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->post(route('customer.subscriptions.cancel.process', $subscription), [
                'reason' => 'Test',
                'confirmation' => true,
            ]);

        $response->assertForbidden();
    });

    test('already cancelled subscription shows cancellation details', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Customer request',
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('Cancelled')
            ->assertSee('Customer request');
    });
});

describe('Subscription Status Indicators', function () {
    
    test('active subscription shows active badge', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('Active');
    });

    test('expired subscription shows expired badge', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'expired',
            'expires_at' => now()->subDay(),
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('Expired');
    });

    test('trial subscription shows trial badge', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'trial',
            'trial_ends_at' => now()->addWeek(),
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('Trial');
    });

    test('expiring soon subscription shows warning', function () {
        $subscription = Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
            'expires_at' => now()->addDays(5),
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertSee('expires soon', false); // case insensitive
    });
});

describe('Subscription Filtering', function () {
    
    test('customer can filter by active status', function () {
        Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'active',
        ]);
        Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'expired',
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.index', ['status' => 'active']));

        $response->assertOk()
            ->assertViewHas('subscriptions', function ($subscriptions) {
                return $subscriptions->every(fn($s) => $s->status === 'active');
            });
    });

    test('customer can sort subscriptions', function () {
        Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'created_at' => now()->subDays(5),
        ]);
        Subscription::factory()->create([
            'customer_id' => $this->customer->id,
            'created_at' => now()->subDays(1),
        ]);

        $response = actingAs($this->customer)
            ->get(route('customer.subscriptions.index', ['sort' => 'created_at', 'direction' => 'desc']));

        $response->assertOk();
    });
});

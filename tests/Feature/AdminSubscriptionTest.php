<?php

use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use function Pest\Laravel\{actingAs, get, post, delete, assertDatabaseHas};

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->service = Service::factory()->create([
        'name' => 'Premium Hosting',
        'price' => 29.99,
    ]);
});

describe('Admin Subscription Management', function () {
    
    test('admin can view subscriptions index', function () {
        Subscription::factory()->count(5)->create();

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.index'));

        $response->assertOk()
            ->assertViewIs('admin.subscriptions.index')
            ->assertViewHas('subscriptions');
    });

    test('non-admin cannot access subscriptions index', function () {
        $response = actingAs($this->customer)
            ->get(route('admin.subscriptions.index'));

        $response->assertForbidden();
    });

    test('guest cannot access subscriptions index', function () {
        $response = get(route('admin.subscriptions.index'));

        $response->assertRedirect(route('login'));
    });

    test('admin can view single subscription', function () {
        $subscription = Subscription::factory()->create();

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.show', $subscription));

        $response->assertOk()
            ->assertViewIs('admin.subscriptions.show')
            ->assertViewHas('subscription');
    });

    test('admin can filter subscriptions by status', function () {
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'expired']);

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.index', ['status' => 'active']));

        $response->assertOk()
            ->assertViewHas('subscriptions', function ($subscriptions) {
                return $subscriptions->every(fn($s) => $s->status === 'active');
            });
    });

    test('admin can search subscriptions', function () {
        $customer = User::factory()->create(['name' => 'John Doe']);
        Subscription::factory()->create(['customer_id' => $customer->id]);
        Subscription::factory()->create();

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.index', ['search' => 'John']));

        $response->assertOk()
            ->assertSee('John Doe');
    });

    test('admin can export subscriptions to CSV', function () {
        Subscription::factory()->count(3)->create();

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.export'));

        $response->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8')
            ->assertDownload();
    });
});

describe('Subscription Renewal', function () {
    
    test('admin can view renewal form', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.renew', $subscription));

        $response->assertOk()
            ->assertViewIs('admin.subscriptions.renew')
            ->assertViewHas('subscription');
    });

    test('admin can renew subscription', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        $originalExpiration = $subscription->expires_at->copy();

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.renew.store', $subscription), [
                'duration_months' => 3,
            ]);

        $response->assertRedirect(route('admin.subscriptions.show', $subscription))
            ->assertSessionHas('success');

        $subscription->refresh();
        expect($subscription->expires_at->greaterThan($originalExpiration))->toBeTrue();
    });

    test('renewal requires valid duration', function () {
        $subscription = Subscription::factory()->create();

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.renew.store', $subscription), [
                'duration_months' => 0, // Invalid
            ]);

        $response->assertSessionHasErrors('duration_months');
    });
});

describe('Subscription Cancellation', function () {
    
    test('admin can view cancellation form', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.cancel', $subscription));

        $response->assertOk()
            ->assertViewIs('admin.subscriptions.cancel')
            ->assertViewHas('subscription');
    });

    test('admin can cancel subscription', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.cancel.store', $subscription), [
                'reason' => 'Customer request',
            ]);

        $response->assertRedirect(route('admin.subscriptions.show', $subscription))
            ->assertSessionHas('success');

        $subscription->refresh();
        expect($subscription->status)->toBe('cancelled')
            ->and($subscription->cancelled_at)->not->toBeNull()
            ->and($subscription->cancellation_reason)->toBe('Customer request');
    });

    test('cancelled subscription cannot be cancelled again', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.cancel.store', $subscription), [
                'reason' => 'Test',
            ]);

        $response->assertSessionHasErrors();
    });
});

describe('Bulk Operations', function () {
    
    test('admin can bulk activate subscriptions', function () {
        $subscriptions = Subscription::factory()->count(3)->create([
            'status' => 'suspended',
        ]);

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.bulk'), [
                'action' => 'activate',
                'subscription_ids' => $subscriptions->pluck('id')->toArray(),
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        foreach ($subscriptions as $subscription) {
            $subscription->refresh();
            expect($subscription->status)->toBe('active');
        }
    });

    test('admin can bulk suspend subscriptions', function () {
        $subscriptions = Subscription::factory()->count(3)->create([
            'status' => 'active',
        ]);

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.bulk'), [
                'action' => 'suspend',
                'subscription_ids' => $subscriptions->pluck('id')->toArray(),
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        foreach ($subscriptions as $subscription) {
            $subscription->refresh();
            expect($subscription->status)->toBe('suspended');
        }
    });

    test('admin can bulk cancel subscriptions', function () {
        $subscriptions = Subscription::factory()->count(3)->create([
            'status' => 'active',
        ]);

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.bulk'), [
                'action' => 'cancel',
                'subscription_ids' => $subscriptions->pluck('id')->toArray(),
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        foreach ($subscriptions as $subscription) {
            $subscription->refresh();
            expect($subscription->status)->toBe('cancelled');
        }
    });

    test('bulk operation requires subscription ids', function () {
        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.bulk'), [
                'action' => 'activate',
                'subscription_ids' => [],
            ]);

        $response->assertSessionHasErrors('subscription_ids');
    });

    test('bulk operation requires valid action', function () {
        $subscriptions = Subscription::factory()->count(2)->create();

        $response = actingAs($this->admin)
            ->post(route('admin.subscriptions.bulk'), [
                'action' => 'invalid_action',
                'subscription_ids' => $subscriptions->pluck('id')->toArray(),
            ]);

        $response->assertSessionHasErrors('action');
    });
});

describe('Subscription Statistics', function () {
    
    test('index page shows subscription statistics', function () {
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'expired']);
        Subscription::factory()->create(['status' => 'trial']);

        $response = actingAs($this->admin)
            ->get(route('admin.subscriptions.index'));

        $response->assertOk()
            ->assertSee('Total Subscriptions')
            ->assertSee('Active')
            ->assertSee('Expired');
    });
});

describe('Subscription Updates', function () {
    
    test('admin can update subscription status', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $response = actingAs($this->admin)
            ->patch(route('admin.subscriptions.update', $subscription), [
                'status' => 'suspended',
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $subscription->refresh();
        expect($subscription->status)->toBe('suspended');
    });

    test('admin can update subscription expiration date', function () {
        $subscription = Subscription::factory()->create([
            'expires_at' => now()->addMonth(),
        ]);

        $newDate = now()->addMonths(3);

        $response = actingAs($this->admin)
            ->patch(route('admin.subscriptions.update', $subscription), [
                'expires_at' => $newDate->format('Y-m-d'),
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $subscription->refresh();
        expect($subscription->expires_at->format('Y-m-d'))->toBe($newDate->format('Y-m-d'));
    });

    test('admin can toggle auto_renew', function () {
        $subscription = Subscription::factory()->create([
            'auto_renew' => false,
        ]);

        $response = actingAs($this->admin)
            ->patch(route('admin.subscriptions.update', $subscription), [
                'auto_renew' => true,
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $subscription->refresh();
        expect($subscription->auto_renew)->toBeTrue();
    });
});

describe('Subscription Deletion', function () {
    
    test('admin can soft delete subscription', function () {
        $subscription = Subscription::factory()->create();

        $response = actingAs($this->admin)
            ->delete(route('admin.subscriptions.destroy', $subscription));

        $response->assertRedirect()
            ->assertSessionHas('success');

        expect(Subscription::withTrashed()->find($subscription->id))->not->toBeNull()
            ->and(Subscription::find($subscription->id))->toBeNull();
    });
});

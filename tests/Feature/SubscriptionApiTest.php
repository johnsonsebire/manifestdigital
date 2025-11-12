<?php

use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\{getJson, postJson, putJson, patchJson, deleteJson, assertDatabaseHas};

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->service = Service::factory()->create([
        'name' => 'Premium Hosting',
        'price' => 29.99,
        'duration_months' => 1,
    ]);
});

describe('API Authentication', function () {
    
    test('unauthenticated request returns 401', function () {
        $response = getJson('/api/v1/subscriptions');

        $response->assertUnauthorized();
    });

    test('authenticated request with token succeeds', function () {
        Sanctum::actingAs($this->user);

        $response = getJson('/api/v1/subscriptions');

        $response->assertOk();
    });
});

describe('API List Subscriptions', function () {
    
    test('can list all subscriptions', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->count(5)->create();

        $response = getJson('/api/v1/subscriptions');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'uuid',
                        'status',
                        'billing_interval',
                        'auto_renew',
                        'starts_at',
                        'expires_at',
                        'service',
                        'customer',
                    ]
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'total',
                ],
            ]);
    });

    test('can filter subscriptions by status', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'expired']);

        $response = getJson('/api/v1/subscriptions?status=active');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.status', 'active');
    });

    test('can filter subscriptions by customer', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->create(['customer_id' => $this->customer->id]);
        Subscription::factory()->create();

        $response = getJson("/api/v1/subscriptions?customer_id={$this->customer->id}");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.customer.id', $this->customer->id);
    });

    test('can filter subscriptions by service', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->create(['service_id' => $this->service->id]);
        Subscription::factory()->create();

        $response = getJson("/api/v1/subscriptions?service_id={$this->service->id}");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.service.id', $this->service->id);
    });

    test('can search subscriptions', function () {
        Sanctum::actingAs($this->user);
        $customer = User::factory()->create(['name' => 'John Doe']);
        Subscription::factory()->create(['customer_id' => $customer->id]);
        Subscription::factory()->create();

        $response = getJson('/api/v1/subscriptions?search=John');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.customer.name', 'John Doe');
    });

    test('can sort subscriptions', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->create(['created_at' => now()->subDays(5)]);
        Subscription::factory()->create(['created_at' => now()->subDays(1)]);

        $response = getJson('/api/v1/subscriptions?sort_by=created_at&sort_order=desc');

        $response->assertOk();
    });

    test('pagination limits to max 100 per page', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->count(150)->create();

        $response = getJson('/api/v1/subscriptions?per_page=200');

        $response->assertOk()
            ->assertJsonPath('meta.per_page', 100);
    });
});

describe('API Create Subscription', function () {
    
    test('can create subscription with valid data', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', [
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'billing_interval' => 'monthly',
            'starts_at' => now()->format('Y-m-d'),
            'expires_at' => now()->addMonth()->format('Y-m-d'),
            'auto_renew' => true,
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'uuid',
                    'status',
                    'billing_interval',
                ],
            ]);

        assertDatabaseHas('subscriptions', [
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'billing_interval' => 'monthly',
        ]);
    });

    test('create validation requires customer_id', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', [
            'service_id' => $this->service->id,
            'billing_interval' => 'monthly',
            'starts_at' => now()->format('Y-m-d'),
            'expires_at' => now()->addMonth()->format('Y-m-d'),
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('customer_id');
    });

    test('create validation requires service_id', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', [
            'customer_id' => $this->customer->id,
            'billing_interval' => 'monthly',
            'starts_at' => now()->format('Y-m-d'),
            'expires_at' => now()->addMonth()->format('Y-m-d'),
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('service_id');
    });

    test('create validation requires valid billing_interval', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', [
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'billing_interval' => 'invalid',
            'starts_at' => now()->format('Y-m-d'),
            'expires_at' => now()->addMonth()->format('Y-m-d'),
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('billing_interval');
    });

    test('create validation requires expires_at after starts_at', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', [
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'billing_interval' => 'monthly',
            'starts_at' => now()->addMonth()->format('Y-m-d'),
            'expires_at' => now()->format('Y-m-d'),
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('expires_at');
    });

    test('can create subscription with metadata', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', [
            'customer_id' => $this->customer->id,
            'service_id' => $this->service->id,
            'billing_interval' => 'monthly',
            'starts_at' => now()->format('Y-m-d'),
            'expires_at' => now()->addMonth()->format('Y-m-d'),
            'metadata' => [
                'custom_field' => 'value',
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.metadata.custom_field', 'value');
    });
});

describe('API Get Subscription', function () {
    
    test('can retrieve subscription by uuid', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create([
            'service_id' => $this->service->id,
        ]);

        $response = getJson("/api/v1/subscriptions/{$subscription->uuid}");

        $response->assertOk()
            ->assertJsonPath('data.uuid', $subscription->uuid)
            ->assertJsonPath('data.service.name', $this->service->name);
    });

    test('returns 404 for non-existent subscription', function () {
        Sanctum::actingAs($this->user);

        $response = getJson('/api/v1/subscriptions/non-existent-uuid');

        $response->assertNotFound()
            ->assertJsonPath('success', false);
    });
});

describe('API Update Subscription', function () {
    
    test('can update subscription with PUT', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $response = putJson("/api/v1/subscriptions/{$subscription->uuid}", [
            'status' => 'suspended',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status', 'suspended');

        assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'suspended',
        ]);
    });

    test('can update subscription with PATCH', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create([
            'auto_renew' => false,
        ]);

        $response = patchJson("/api/v1/subscriptions/{$subscription->uuid}", [
            'auto_renew' => true,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.auto_renew', true);
    });

    test('can update expiration date', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create();
        $newDate = now()->addMonths(3)->format('Y-m-d');

        $response = patchJson("/api/v1/subscriptions/{$subscription->uuid}", [
            'expires_at' => $newDate,
        ]);

        $response->assertOk();

        $subscription->refresh();
        expect($subscription->expires_at->format('Y-m-d'))->toBe($newDate);
    });

    test('can update renewal price', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create();

        $response = patchJson("/api/v1/subscriptions/{$subscription->uuid}", [
            'renewal_price' => 24.99,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.renewal_price', 24.99);
    });

    test('can update metadata', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create();

        $response = patchJson("/api/v1/subscriptions/{$subscription->uuid}", [
            'metadata' => [
                'updated_field' => 'new_value',
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('data.metadata.updated_field', 'new_value');
    });
});

describe('API Delete Subscription', function () {
    
    test('can cancel subscription', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $response = deleteJson("/api/v1/subscriptions/{$subscription->uuid}");

        $response->assertOk()
            ->assertJsonPath('data.status', 'cancelled');

        $subscription->refresh();
        expect($subscription->status)->toBe('cancelled')
            ->and($subscription->cancelled_at)->not->toBeNull()
            ->and($subscription->auto_renew)->toBeFalse();
    });
});

describe('API Renew Subscription', function () {
    
    test('can renew subscription', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        $originalExpiration = $subscription->expires_at->copy();

        $response = postJson("/api/v1/subscriptions/{$subscription->uuid}/renew", [
            'duration_months' => 3,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status', 'active');

        $subscription->refresh();
        expect($subscription->expires_at->greaterThan($originalExpiration))->toBeTrue();
    });

    test('renewal validates duration_months range', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create();

        $response = postJson("/api/v1/subscriptions/{$subscription->uuid}/renew", [
            'duration_months' => 50, // Too large
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('duration_months');
    });

    test('can renew expired subscription', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
            'expires_at' => now()->subMonth(),
        ]);

        $response = postJson("/api/v1/subscriptions/{$subscription->uuid}/renew", [
            'duration_months' => 1,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status', 'active');

        $subscription->refresh();
        expect($subscription->expires_at->isFuture())->toBeTrue();
    });
});

describe('API Get Statistics', function () {
    
    test('can retrieve subscription statistics', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'active']);
        Subscription::factory()->create(['status' => 'expired']);
        Subscription::factory()->create(['status' => 'trial']);

        $response = getJson('/api/v1/subscriptions/stats');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'total',
                    'active',
                    'trial',
                    'expired',
                    'cancelled',
                    'suspended',
                    'pending_renewal',
                    'expiring_soon',
                ],
            ])
            ->assertJsonPath('data.total', 4)
            ->assertJsonPath('data.active', 2)
            ->assertJsonPath('data.expired', 1)
            ->assertJsonPath('data.trial', 1);
    });
});

describe('API Rate Limiting', function () {
    
    test('rate limit is enforced', function () {
        Sanctum::actingAs($this->user);

        // Make 61 requests (limit is 60 per minute)
        for ($i = 0; $i < 61; $i++) {
            $response = getJson('/api/v1/subscriptions');
            
            if ($i < 60) {
                $response->assertOk();
            }
        }

        // The 61st request should be rate limited
        $response->assertStatus(429);
    })->skip('Rate limiting test can be slow');
});

describe('API Response Format', function () {
    
    test('success response has correct structure', function () {
        Sanctum::actingAs($this->user);
        Subscription::factory()->create();

        $response = getJson('/api/v1/subscriptions');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data',
                'meta',
                'links',
            ])
            ->assertJsonPath('success', true);
    });

    test('error response has correct structure', function () {
        Sanctum::actingAs($this->user);

        $response = postJson('/api/v1/subscriptions', []);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'success',
                'message',
                'errors',
            ])
            ->assertJsonPath('success', false);
    });

    test('dates are in ISO 8601 format', function () {
        Sanctum::actingAs($this->user);
        $subscription = Subscription::factory()->create();

        $response = getJson("/api/v1/subscriptions/{$subscription->uuid}");

        $response->assertOk();
        
        $startsAt = $response->json('data.starts_at');
        expect($startsAt)->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z$/');
    });
});

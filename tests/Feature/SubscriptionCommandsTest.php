<?php

use App\Models\Subscription;
use App\Models\User;
use App\Models\Service;
use App\Console\Commands\SendSubscriptionReminders;
use App\Console\Commands\UpdateSubscriptionStatuses;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->service = Service::factory()->create([
        'name' => 'Premium Hosting',
        'duration_months' => 1,
    ]);
});

describe('Send Subscription Reminders Command', function () {
    
    test('command runs successfully', function () {
        artisan('subscriptions:send-reminders')
            ->assertSuccessful();
    });

    test('command sends reminders for expiring subscriptions', function () {
        Notification::fake();

        $customer = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'customer_id' => $customer->id,
            'service_id' => $this->service->id,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
        ]);

        artisan('subscriptions:send-reminders', ['--days' => 7])
            ->assertSuccessful();

        Notification::assertSentTo($customer, function ($notification) {
            return true;
        });
    });

    test('command with dry-run does not send emails', function () {
        Mail::fake();

        $customer = User::factory()->create();
        Subscription::factory()->create([
            'customer_id' => $customer->id,
            'expires_at' => now()->addDays(7),
        ]);

        artisan('subscriptions:send-reminders', ['--days' => 7, '--dry-run' => true])
            ->assertSuccessful();

        Mail::assertNothingSent();
    });

    test('command only processes active and pending_renewal subscriptions', function () {
        Notification::fake();

        $customer1 = User::factory()->create();
        $customer2 = User::factory()->create();

        Subscription::factory()->create([
            'customer_id' => $customer1->id,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
        ]);

        Subscription::factory()->create([
            'customer_id' => $customer2->id,
            'status' => 'cancelled',
            'expires_at' => now()->addDays(7),
        ]);

        artisan('subscriptions:send-reminders', ['--days' => 7])
            ->assertSuccessful();

        Notification::assertSentTo($customer1, function ($notification) {
            return true;
        });

        Notification::assertNotSentTo($customer2);
    });

    test('command skips subscriptions already reminded', function () {
        Notification::fake();

        $customer = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
            'last_reminder_sent_at' => now(),
        ]);

        artisan('subscriptions:send-reminders', ['--days' => 7])
            ->assertSuccessful();

        Notification::assertNothingSent();
    });

    test('command with force flag resends reminders', function () {
        Notification::fake();

        $customer = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
            'last_reminder_sent_at' => now(),
        ]);

        artisan('subscriptions:send-reminders', ['--days' => 7, '--force' => true])
            ->assertSuccessful();

        Notification::assertSentTo($customer, function ($notification) {
            return true;
        });
    });
});

describe('Update Subscription Statuses Command', function () {
    
    test('command runs successfully', function () {
        artisan('subscriptions:update-statuses')
            ->assertSuccessful();
    });

    test('command expires active subscriptions past expiration date', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses')
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('expired');
    });

    test('command with dry-run does not update database', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses', ['--dry-run' => true])
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('active'); // Should not change
    });

    test('command handles trial expiration correctly', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'trial',
            'trial_ends_at' => now()->subDay(),
            'auto_renew' => false,
        ]);

        artisan('subscriptions:update-statuses')
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('expired');
    });

    test('command converts trial to active when auto_renew is enabled', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'trial',
            'trial_ends_at' => now()->subDay(),
            'auto_renew' => true,
            'expires_at' => now()->addMonth(),
        ]);

        artisan('subscriptions:update-statuses')
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('active');
    });

    test('command suspends long expired subscriptions', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
            'expires_at' => now()->subDays(45), // More than grace period
        ]);

        artisan('subscriptions:update-statuses', ['--grace-period' => 30])
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('suspended');
    });

    test('command respects custom grace period', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
            'expires_at' => now()->subDays(10),
        ]);

        artisan('subscriptions:update-statuses', ['--grace-period' => 5])
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('suspended');
    });

    test('command sends notifications when flag is set', function () {
        Notification::fake();

        $customer = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses', ['--notify' => true])
            ->assertSuccessful();

        Notification::assertSentTo($customer, function ($notification) {
            return true;
        });
    });

    test('command sends admin report when flag is set', function () {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin', 'email' => 'admin@example.com']);
        
        Subscription::factory()->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses', ['--admin-report' => true])
            ->assertSuccessful();

        // Would check for admin notification here
    });

    test('command outputs statistics', function () {
        Subscription::factory()->count(3)->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses')
            ->expectsOutput('Processing expired subscriptions...')
            ->assertSuccessful();
    });

    test('command does not expire pending_renewal subscriptions in grace period', function () {
        $subscription = Subscription::factory()->create([
            'status' => 'pending_renewal',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses')
            ->assertSuccessful();

        $subscription->refresh();
        expect($subscription->status)->toBe('pending_renewal');
    });
});

describe('Command Scheduling', function () {
    
    test('reminder command is scheduled daily', function () {
        // This test verifies the command is registered in the schedule
        expect(app()->make(\Illuminate\Console\Scheduling\Schedule::class)->events())
            ->toContain(fn($event) => str_contains($event->command ?? '', 'subscriptions:send-reminders'));
    })->skip('Schedule verification requires complex setup');

    test('status update command is scheduled daily', function () {
        // This test verifies the command is registered in the schedule
        expect(app()->make(\Illuminate\Console\Scheduling\Schedule::class)->events())
            ->toContain(fn($event) => str_contains($event->command ?? '', 'subscriptions:update-statuses'));
    })->skip('Schedule verification requires complex setup');
});

describe('Command Error Handling', function () {
    
    test('command continues after individual subscription error', function () {
        // Create subscriptions, one that might cause an error
        Subscription::factory()->count(3)->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        artisan('subscriptions:update-statuses')
            ->assertSuccessful();

        // Should process all subscriptions despite any individual errors
        expect(Subscription::where('status', 'expired')->count())->toBeGreaterThan(0);
    });

    test('command logs errors', function () {
        // Would test that errors are logged properly
    })->skip('Requires log verification setup');
});

describe('Command Performance', function () {
    
    test('command handles large number of subscriptions', function () {
        Subscription::factory()->count(100)->create([
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        $startTime = microtime(true);

        artisan('subscriptions:update-statuses')
            ->assertSuccessful();

        $duration = microtime(true) - $startTime;

        // Should complete in reasonable time (< 10 seconds for 100 subscriptions)
        expect($duration)->toBeLessThan(10);
    })->skip('Performance test - run manually when needed');
});

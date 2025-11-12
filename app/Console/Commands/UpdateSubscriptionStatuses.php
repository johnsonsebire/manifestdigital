<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionExpiredNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class UpdateSubscriptionStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:update-statuses
                            {--dry-run : Run without making changes}
                            {--grace-period=0 : Grace period in days before marking as expired}
                            {--notify : Send notifications to customers}
                            {--admin-report : Send summary report to admins}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update subscription statuses based on expiration dates';

    /**
     * Statistics for the run
     */
    private array $stats = [
        'total_processed' => 0,
        'expired' => 0,
        'suspended' => 0,
        'errors' => 0,
        'notifications_sent' => 0,
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $gracePeriod = (int) $this->option('grace-period');
        $sendNotifications = $this->option('notify');
        $sendAdminReport = $this->option('admin-report');

        $this->info('Starting subscription status update...');
        
        if ($dryRun) {
            $this->warn('Running in DRY-RUN mode - no changes will be made');
        }

        $this->info("Grace period: {$gracePeriod} days");
        $this->newLine();

        try {
            // Process expired subscriptions
            $this->processExpiredSubscriptions($dryRun, $gracePeriod, $sendNotifications);

            // Process trial expirations
            $this->processTrialExpirations($dryRun, $sendNotifications);

            // Process suspended subscriptions (grace period expired)
            $this->processSuspendedSubscriptions($dryRun, $gracePeriod, $sendNotifications);

            // Display summary
            $this->displaySummary();

            // Send admin report if requested
            if ($sendAdminReport && !$dryRun) {
                $this->sendAdminReport();
            }

            // Log the run
            if (!$dryRun) {
                Log::info('Subscription status update completed', $this->stats);
            }

            $this->newLine();
            $this->info('✓ Subscription status update completed successfully!');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error updating subscription statuses: ' . $e->getMessage());
            Log::error('Subscription status update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }

    /**
     * Process expired subscriptions
     */
    private function processExpiredSubscriptions(bool $dryRun, int $gracePeriod, bool $sendNotifications): void
    {
        $this->info('Processing expired subscriptions...');

        $expirationDate = now()->subDays($gracePeriod);

        $subscriptions = Subscription::with(['customer', 'service'])
            ->whereIn('status', ['active', 'pending_renewal'])
            ->where('expires_at', '<=', $expirationDate)
            ->get();

        $this->stats['total_processed'] += $subscriptions->count();

        if ($subscriptions->isEmpty()) {
            $this->info('  No expired subscriptions found.');
            return;
        }

        $this->info("  Found {$subscriptions->count()} expired subscription(s)");

        $progressBar = $this->output->createProgressBar($subscriptions->count());
        $progressBar->start();

        foreach ($subscriptions as $subscription) {
            try {
                if (!$dryRun) {
                    DB::transaction(function () use ($subscription, $sendNotifications) {
                        // Update status
                        $subscription->update([
                            'status' => 'expired',
                            'auto_renew' => false, // Disable auto-renew for expired subscriptions
                        ]);

                        // Send notification
                        if ($sendNotifications && $subscription->customer) {
                            $subscription->customer->notify(new SubscriptionExpiredNotification($subscription));
                            $this->stats['notifications_sent']++;
                        }
                    });
                }

                $this->stats['expired']++;
                
                $progressBar->advance();

            } catch (\Exception $e) {
                $this->stats['errors']++;
                Log::error('Failed to update subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $progressBar->finish();
        $this->newLine(2);
    }

    /**
     * Process trial expirations
     */
    private function processTrialExpirations(bool $dryRun, bool $sendNotifications): void
    {
        $this->info('Processing trial expirations...');

        $subscriptions = Subscription::with(['customer', 'service'])
            ->where('status', 'trial')
            ->where('trial_ends_at', '<=', now())
            ->get();

        $this->stats['total_processed'] += $subscriptions->count();

        if ($subscriptions->isEmpty()) {
            $this->info('  No expired trials found.');
            return;
        }

        $this->info("  Found {$subscriptions->count()} expired trial(s)");

        $progressBar = $this->output->createProgressBar($subscriptions->count());
        $progressBar->start();

        foreach ($subscriptions as $subscription) {
            try {
                if (!$dryRun) {
                    DB::transaction(function () use ($subscription, $sendNotifications) {
                        // Check if subscription has a valid payment method
                        if ($subscription->auto_renew && $subscription->expires_at > now()) {
                            // Convert to active
                            $subscription->update(['status' => 'active']);
                        } else {
                            // Expire the subscription
                            $subscription->update([
                                'status' => 'expired',
                                'auto_renew' => false,
                            ]);

                            // Send notification
                            if ($sendNotifications && $subscription->customer) {
                                $subscription->customer->notify(new SubscriptionExpiredNotification($subscription));
                                $this->stats['notifications_sent']++;
                            }
                        }
                    });
                }

                $this->stats['expired']++;
                $progressBar->advance();

            } catch (\Exception $e) {
                $this->stats['errors']++;
                Log::error('Failed to update trial subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $progressBar->finish();
        $this->newLine(2);
    }

    /**
     * Process suspended subscriptions (past grace period)
     */
    private function processSuspendedSubscriptions(bool $dryRun, int $gracePeriod, bool $sendNotifications): void
    {
        if ($gracePeriod <= 0) {
            return; // Skip if no grace period
        }

        $this->info('Processing suspended subscriptions (grace period expired)...');

        $suspensionDate = now()->subDays($gracePeriod * 2); // Double grace period for suspension

        $subscriptions = Subscription::with(['customer', 'service'])
            ->where('status', 'expired')
            ->where('expires_at', '<=', $suspensionDate)
            ->whereNull('cancelled_at') // Don't suspend already cancelled ones
            ->get();

        $this->stats['total_processed'] += $subscriptions->count();

        if ($subscriptions->isEmpty()) {
            $this->info('  No subscriptions to suspend.');
            return;
        }

        $this->info("  Found {$subscriptions->count()} subscription(s) to suspend");

        $progressBar = $this->output->createProgressBar($subscriptions->count());
        $progressBar->start();

        foreach ($subscriptions as $subscription) {
            try {
                if (!$dryRun) {
                    DB::transaction(function () use ($subscription) {
                        $subscription->update(['status' => 'suspended']);
                    });
                }

                $this->stats['suspended']++;
                $progressBar->advance();

            } catch (\Exception $e) {
                $this->stats['errors']++;
                Log::error('Failed to suspend subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $progressBar->finish();
        $this->newLine(2);
    }

    /**
     * Display summary statistics
     */
    private function displaySummary(): void
    {
        $this->newLine();
        $this->info('Summary:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Processed', $this->stats['total_processed']],
                ['Expired', $this->stats['expired']],
                ['Suspended', $this->stats['suspended']],
                ['Notifications Sent', $this->stats['notifications_sent']],
                ['Errors', $this->stats['errors']],
            ]
        );
    }

    /**
     * Send admin report
     */
    private function sendAdminReport(): void
    {
        try {
            $admins = User::role('Admin')->get();

            if ($admins->isEmpty()) {
                return;
            }

            $reportData = [
                'date' => now()->format('Y-m-d H:i:s'),
                'stats' => $this->stats,
            ];

            Notification::send($admins, new \App\Notifications\SubscriptionStatusUpdateReport($reportData));

            $this->info('Admin report sent to ' . $admins->count() . ' administrator(s)');

        } catch (\Exception $e) {
            Log::error('Failed to send admin report', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}

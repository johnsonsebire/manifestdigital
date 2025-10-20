<?php

namespace App\Console\Commands;

use App\Services\SubscriptionService;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckSubscriptionExpirations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expirations 
                            {--dry-run : Run without sending notifications}
                            {--days= : Override default reminder window days}
                            {--service= : Check specific service only (service ID)}
                            {--customer= : Check specific customer only (user ID)}
                            {--force : Force check even if already run today}
                            {--detailed : Show detailed output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expiring subscriptions and send reminder notifications';

    protected SubscriptionService $subscriptionService;

    /**
     * Create a new command instance.
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $startTime = microtime(true);
        $dryRun = $this->option('dry-run');
        $detailed = $this->option('detailed');

        // Display command header
        $this->info('🔄 Checking subscription expirations...');
        
        if ($dryRun) {
            $this->warn('🧪 DRY RUN MODE - No notifications will be sent');
        }

        // Check if already run today (unless forced)
        if (!$this->option('force') && $this->wasAlreadyRunToday()) {
            $this->warn('⚠️  Command already run today. Use --force to override.');
            return 0;
        }

        try {
            // Get subscription count for progress
            $totalSubscriptions = $this->getSubscriptionCount();
            $this->info("📊 Found {$totalSubscriptions} active subscriptions to check");

            // Run expiration checks
            $results = $this->subscriptionService->checkExpirations($dryRun);

            // Process expired subscriptions
            $expiredCount = $this->processExpiredSubscriptions($dryRun);

            // Display results
            $this->displayResults($results, $expiredCount, $detailed);

            // Log execution
            $this->logExecution($results, $expiredCount, $dryRun);

            // Mark as run today
            if (!$dryRun) {
                $this->markAsRunToday();
            }

            $executionTime = round(microtime(true) - $startTime, 2);
            $this->info("✅ Completed in {$executionTime} seconds");

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error checking subscription expirations: ' . $e->getMessage());
            
            Log::error('Subscription expiration check failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'dry_run' => $dryRun,
            ]);

            return 1;
        }
    }

    /**
     * Get count of subscriptions to check.
     */
    protected function getSubscriptionCount(): int
    {
        $query = Subscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->where('expires_at', '<=', now()->addDays($this->option('days') ?: 15));

        if ($serviceId = $this->option('service')) {
            $query->where('service_id', $serviceId);
        }

        if ($customerId = $this->option('customer')) {
            $query->where('customer_id', $customerId);
        }

        return $query->count();
    }

    /**
     * Process expired subscriptions.
     */
    protected function processExpiredSubscriptions(bool $dryRun): int
    {
        $expiredSubscriptions = Subscription::with(['service', 'customer'])
            ->where('status', 'active')
            ->where('expires_at', '<=', now())
            ->get();

        $processed = 0;

        foreach ($expiredSubscriptions as $subscription) {
            try {
                if (!$dryRun) {
                    // Update subscription status
                    $subscription->update([
                        'status' => 'expired',
                        'expired_at' => now(),
                    ]);

                    // Send expired notification if not already sent
                    if (!$this->wasExpiredNotificationSent($subscription)) {
                        $subscription->customer->notify(
                            new \App\Notifications\SubscriptionExpiredNotification($subscription)
                        );

                        // Log the notification
                        \App\Models\ExpirationReminderLog::logReminder(
                            $subscription->id,
                            'expired',
                            'default',
                            $subscription->customer->email
                        );
                    }
                }

                $processed++;

                if ($this->option('detailed')) {
                    $this->line("💀 Expired: {$subscription->service->title} for {$subscription->customer->email}");
                }

            } catch (\Exception $e) {
                $this->error("Failed to process expired subscription {$subscription->uuid}: {$e->getMessage()}");
            }
        }

        if ($processed > 0) {
            $status = $dryRun ? 'would be processed' : 'processed';
            $this->info("💀 {$processed} expired subscriptions {$status}");
        }

        return $processed;
    }

    /**
     * Check if expired notification was already sent.
     */
    protected function wasExpiredNotificationSent(Subscription $subscription): bool
    {
        return \App\Models\ExpirationReminderLog::where('subscription_id', $subscription->id)
            ->where('reminder_type', 'expired')
            ->exists();
    }

    /**
     * Display results summary.
     */
    protected function displayResults(array $results, int $expiredCount, bool $detailed): void
    {
        $this->newLine();
        $this->info('📈 SUMMARY:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Subscriptions Checked', $results['checked']],
                ['Reminders Sent', $results['reminders_sent']],
                ['Expired Processed', $expiredCount],
                ['Errors', count($results['errors'])],
            ]
        );

        // Show errors if any
        if (!empty($results['errors'])) {
            $this->newLine();
            $this->error('❌ ERRORS:');
            foreach ($results['errors'] as $error) {
                $this->line("  • {$error['subscription_uuid']}: {$error['error']}");
            }
        }

        // Show details if detailed option is enabled
        if ($detailed && !empty($results['details'])) {
            $this->newLine();
            $this->info('📋 DETAILS:');
            $this->table(
                ['Subscription', 'Service', 'Customer', 'Expires', 'Reminders'],
                array_map(function ($detail) {
                    return [
                        substr($detail['subscription_uuid'], 0, 8) . '...',
                        $detail['service'],
                        $detail['customer'],
                        $detail['expires_at']->format('M j, Y'),
                        $detail['reminders_sent'],
                    ];
                }, $results['details'])
            );
        }
    }

    /**
     * Log execution details.
     */
    protected function logExecution(array $results, int $expiredCount, bool $dryRun): void
    {
        Log::info('Subscription expiration check completed', [
            'checked' => $results['checked'],
            'reminders_sent' => $results['reminders_sent'],
            'expired_processed' => $expiredCount,
            'errors' => count($results['errors']),
            'dry_run' => $dryRun,
            'execution_time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Check if command was already run today.
     */
    protected function wasAlreadyRunToday(): bool
    {
        $cacheKey = 'subscription_expiration_check_' . date('Y-m-d');
        return cache()->has($cacheKey);
    }

    /**
     * Mark command as run today.
     */
    protected function markAsRunToday(): void
    {
        $cacheKey = 'subscription_expiration_check_' . date('Y-m-d');
        cache()->put($cacheKey, true, now()->endOfDay());
    }
}

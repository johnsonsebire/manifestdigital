<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use App\Models\ExpirationReminderLog;
use App\Services\SubscriptionService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    protected $subscriptionService;
    protected $currencyService;

    public function __construct(SubscriptionService $subscriptionService, CurrencyService $currencyService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->currencyService = $currencyService;
    }

    /**
     * Display subscription index with advanced filtering
     */
    public function index(Request $request)
    {
        $query = Subscription::with(['customer', 'service', 'order']);

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('uuid', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('service', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Service filter
        if ($serviceId = $request->input('service_id')) {
            $query->where('service_id', $serviceId);
        }

        // Expiration date range filter
        if ($expiringWithin = $request->input('expiring_within')) {
            $days = (int) $expiringWithin;
            $query->where('status', 'active')
                  ->whereBetween('expires_at', [
                      now(),
                      now()->addDays($days)
                  ]);
        }

        // Auto-renewal filter
        if ($request->has('auto_renew')) {
            $query->where('auto_renew', $request->input('auto_renew') === '1');
        }

        // Date range filters
        if ($startDate = $request->input('start_date')) {
            $query->whereDate('starts_at', '>=', $startDate);
        }
        if ($endDate = $request->input('end_date')) {
            $query->whereDate('expires_at', '<=', $endDate);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Paginate results
        $subscriptions = $query->paginate(20)->withQueryString();

        // Calculate statistics
        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'trial' => Subscription::where('status', 'trial')->count(),
            'expired' => Subscription::where('status', 'expired')->count(),
            'cancelled' => Subscription::where('status', 'cancelled')->count(),
            'expiring_soon' => Subscription::where('status', 'active')
                ->whereBetween('expires_at', [now(), now()->addDays(30)])
                ->count(),
            'total_mrr' => Subscription::where('status', 'active')
                ->where('billing_interval', 'monthly')
                ->sum('billing_amount'),
            'total_arr' => Subscription::where('status', 'active')
                ->where('billing_interval', 'yearly')
                ->sum('billing_amount'),
        ];

        // Get services for filter dropdown
        $services = Service::where('is_subscription', true)
            ->orderBy('title')
            ->get(['id', 'title']);

        // Get user's currency
        $userCurrency = $this->currencyService->getUserCurrency();

        return view('admin.subscriptions.index', compact(
            'subscriptions',
            'stats',
            'services',
            'userCurrency',
            'currencyService'
        ));
    }

    /**
     * Display detailed subscription view
     */
    public function show(Subscription $subscription)
    {
        $subscription->load([
            'customer',
            'service',
            'order.items',
            'reminderLogs' => function($query) {
                $query->orderBy('sent_at', 'desc');
            }
        ]);

        // Get subscription timeline events
        $timeline = $this->buildSubscriptionTimeline($subscription);

        // Get payment history
        $paymentHistory = $this->getPaymentHistory($subscription);

        // Calculate subscription metrics
        $metrics = [
            'days_active' => $subscription->starts_at->diffInDays(now()),
            'days_remaining' => now()->diffInDays($subscription->expires_at, false),
            'days_until_next_billing' => now()->diffInDays($subscription->next_billing_date, false),
            'total_paid' => $subscription->order->total_amount ?? 0,
            'lifetime_value' => $this->calculateLifetimeValue($subscription),
            'renewal_count' => $subscription->renewal_count ?? 0,
        ];

        // Get user's currency
        $userCurrency = $this->currencyService->getUserCurrency();

        return view('admin.subscriptions.show', compact(
            'subscription',
            'timeline',
            'paymentHistory',
            'metrics',
            'userCurrency',
            'currencyService'
        ));
    }

    /**
     * Show renewal management interface
     */
    public function renew(Subscription $subscription)
    {
        if ($subscription->status !== 'active' && $subscription->status !== 'expired') {
            return back()->with('error', 'Only active or expired subscriptions can be renewed.');
        }

        return view('admin.subscriptions.renew', compact('subscription'));
    }

    /**
     * Process subscription renewal
     */
    public function processRenewal(Request $request, Subscription $subscription)
    {
        $request->validate([
            'renewal_period' => 'required|string|in:service_default,custom',
            'custom_months' => 'required_if:renewal_period,custom|nullable|integer|min:1',
            'renewal_price' => 'required|numeric|min:0',
            'send_confirmation' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $months = $request->renewal_period === 'custom' 
                ? $request->custom_months 
                : $subscription->service->subscription_duration_months;

            $result = $this->subscriptionService->renewSubscription(
                $subscription,
                $months,
                $request->renewal_price,
                $request->notes
            );

            if ($request->boolean('send_confirmation')) {
                $subscription->customer->notify(
                    new \App\Notifications\SubscriptionRenewedNotification($subscription)
                );
            }

            DB::commit();

            return redirect()
                ->route('admin.subscriptions.show', $subscription)
                ->with('success', 'Subscription renewed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to renew subscription: ' . $e->getMessage());
        }
    }

    /**
     * Show cancellation interface
     */
    public function cancel(Subscription $subscription)
    {
        if (!in_array($subscription->status, ['active', 'trial'])) {
            return back()->with('error', 'Only active or trial subscriptions can be cancelled.');
        }

        return view('admin.subscriptions.cancel', compact('subscription'));
    }

    /**
     * Process subscription cancellation
     */
    public function processCancel(Request $request, Subscription $subscription)
    {
        $request->validate([
            'cancellation_type' => 'required|string|in:immediate,end_of_period',
            'refund_amount' => 'nullable|numeric|min:0',
            'cancellation_reason' => 'nullable|string|max:1000',
            'send_notification' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $options = [
                'immediate' => $request->cancellation_type === 'immediate',
                'reason' => $request->cancellation_reason,
                'refund_amount' => $request->refund_amount,
            ];
            
            $result = $this->subscriptionService->cancelSubscription(
                $subscription,
                $options
            );

            if ($request->boolean('send_notification')) {
                $subscription->customer->notify(
                    new \App\Notifications\SubscriptionCancelledNotification($subscription)
                );
            }

            DB::commit();

            return redirect()
                ->route('admin.subscriptions.index')
                ->with('success', 'Subscription cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    /**
     * Bulk operations on subscriptions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:send_reminders,export,update_status',
            'subscription_ids' => 'required|array|min:1',
            'subscription_ids.*' => 'exists:subscriptions,id',
        ]);

        $subscriptions = Subscription::whereIn('id', $request->subscription_ids)->get();

        try {
            DB::beginTransaction();

            $results = [
                'success' => 0,
                'failed' => 0,
                'errors' => []
            ];

            foreach ($subscriptions as $subscription) {
                try {
                    switch ($request->action) {
                        case 'send_reminders':
                            $this->subscriptionService->sendRemindersForSubscription($subscription, true);
                            $results['success']++;
                            break;

                        case 'export':
                            // Will be handled separately
                            break;

                        case 'update_status':
                            if ($request->has('new_status')) {
                                $subscription->update(['status' => $request->new_status]);
                                $results['success']++;
                            }
                            break;
                    }
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Subscription {$subscription->uuid}: " . $e->getMessage();
                }
            }

            DB::commit();

            if ($request->action === 'export') {
                return $this->exportSubscriptions($subscriptions);
            }

            $message = "Bulk action completed. Success: {$results['success']}, Failed: {$results['failed']}";
            
            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Export subscriptions to CSV
     */
    public function export(Request $request)
    {
        $query = Subscription::with(['customer', 'service']);

        // Apply same filters as index
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $subscriptions = $query->get();

        $filename = 'subscriptions_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($subscriptions) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Subscription ID',
                'Customer Name',
                'Customer Email',
                'Service',
                'Status',
                'Start Date',
                'Expiration Date',
                'Billing Amount',
                'Currency',
                'Billing Interval',
                'Auto Renew',
                'Created At'
            ]);

            // CSV data
            foreach ($subscriptions as $subscription) {
                fputcsv($file, [
                    $subscription->uuid,
                    $subscription->customer->name ?? 'N/A',
                    $subscription->customer->email ?? 'N/A',
                    $subscription->service->title ?? 'N/A',
                    $subscription->status,
                    $subscription->starts_at->format('Y-m-d'),
                    $subscription->expires_at->format('Y-m-d'),
                    $subscription->billing_amount,
                    $subscription->currency,
                    $subscription->billing_interval,
                    $subscription->auto_renew ? 'Yes' : 'No',
                    $subscription->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Build subscription timeline
     */
    protected function buildSubscriptionTimeline(Subscription $subscription): array
    {
        $timeline = [];

        // Subscription created
        $timeline[] = [
            'type' => 'created',
            'icon' => 'plus-circle',
            'color' => 'blue',
            'title' => 'Subscription Created',
            'description' => 'Subscription was initiated',
            'timestamp' => $subscription->created_at,
        ];

        // Subscription started
        $timeline[] = [
            'type' => 'started',
            'icon' => 'play-circle',
            'color' => 'green',
            'title' => 'Subscription Started',
            'description' => 'Service access began',
            'timestamp' => $subscription->starts_at,
        ];

        // Reminders sent
        foreach ($subscription->reminderLogs as $log) {
            $timeline[] = [
                'type' => 'reminder',
                'icon' => 'bell',
                'color' => 'yellow',
                'title' => 'Reminder Sent',
                'description' => ucfirst(str_replace('_', ' ', $log->reminder_type)) . ' reminder sent to ' . $log->recipient_email,
                'timestamp' => $log->sent_at,
                'metadata' => [
                    'status' => $log->status,
                    'template' => $log->email_template_used,
                ]
            ];
        }

        // Last renewed
        if ($subscription->last_renewed_at) {
            $timeline[] = [
                'type' => 'renewed',
                'icon' => 'refresh',
                'color' => 'green',
                'title' => 'Subscription Renewed',
                'description' => 'Subscription was renewed',
                'timestamp' => $subscription->last_renewed_at,
            ];
        }

        // Cancellation
        if ($subscription->cancelled_at) {
            $timeline[] = [
                'type' => 'cancelled',
                'icon' => 'x-circle',
                'color' => 'red',
                'title' => 'Subscription Cancelled',
                'description' => $subscription->cancellation_reason ?? 'No reason provided',
                'timestamp' => $subscription->cancelled_at,
            ];
        }

        // Expiration
        if ($subscription->status === 'expired') {
            $timeline[] = [
                'type' => 'expired',
                'icon' => 'clock',
                'color' => 'gray',
                'title' => 'Subscription Expired',
                'description' => 'Subscription has expired',
                'timestamp' => $subscription->expires_at,
            ];
        }

        // Sort by timestamp
        usort($timeline, function($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        return $timeline;
    }

    /**
     * Get payment history
     */
    protected function getPaymentHistory(Subscription $subscription): array
    {
        $history = [];

        // Initial payment
        if ($subscription->order) {
            $history[] = [
                'type' => 'initial',
                'amount' => $subscription->order->total_amount,
                'currency' => $subscription->order->currency,
                'status' => $subscription->order->payment_status,
                'date' => $subscription->order->created_at,
                'description' => 'Initial subscription payment',
            ];
        }

        // Get renewal payments from metadata
        if (isset($subscription->metadata['payment_history'])) {
            foreach ($subscription->metadata['payment_history'] as $payment) {
                $history[] = $payment;
            }
        }

        return $history;
    }

    /**
     * Calculate lifetime value
     */
    protected function calculateLifetimeValue(Subscription $subscription): float
    {
        $ltv = $subscription->order->total_amount ?? 0;

        if (isset($subscription->metadata['payment_history'])) {
            foreach ($subscription->metadata['payment_history'] as $payment) {
                $ltv += $payment['amount'] ?? 0;
            }
        }

        return $ltv;
    }

    /**
     * Export subscriptions to CSV (helper)
     */
    protected function exportSubscriptions($subscriptions)
    {
        $filename = 'subscriptions_bulk_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($subscriptions) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Subscription ID',
                'Customer Name',
                'Customer Email',
                'Service',
                'Status',
                'Start Date',
                'Expiration Date',
                'Billing Amount',
                'Currency'
            ]);

            foreach ($subscriptions as $subscription) {
                fputcsv($file, [
                    $subscription->uuid,
                    $subscription->customer->name ?? 'N/A',
                    $subscription->customer->email ?? 'N/A',
                    $subscription->service->title ?? 'N/A',
                    $subscription->status,
                    $subscription->starts_at->format('Y-m-d'),
                    $subscription->expires_at->format('Y-m-d'),
                    $subscription->billing_amount,
                    $subscription->currency
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

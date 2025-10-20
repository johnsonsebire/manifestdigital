<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display customer's subscriptions
     */
    public function index()
    {
        $subscriptions = Subscription::with(['service', 'order'])
            ->where('customer_id', Auth::id())
            ->orderBy('status')
            ->orderBy('expires_at', 'desc')
            ->get();

        // Group subscriptions by status
        $activeSubscriptions = $subscriptions->whereIn('status', ['active', 'trial']);
        $expiredSubscriptions = $subscriptions->where('status', 'expired');
        $cancelledSubscriptions = $subscriptions->where('status', 'cancelled');

        // Get expiring soon subscriptions (within 30 days)
        $expiringSoon = $activeSubscriptions->filter(function($subscription) {
            return $subscription->expires_at->diffInDays(now(), false) <= 30 
                && $subscription->expires_at->diffInDays(now(), false) >= 0;
        });

        // Calculate metrics
        $metrics = [
            'total_active' => $activeSubscriptions->count(),
            'expiring_soon' => $expiringSoon->count(),
            'total_expired' => $expiredSubscriptions->count(),
            'monthly_cost' => $activeSubscriptions->where('billing_interval', 'monthly')->sum('billing_amount'),
            'yearly_cost' => $activeSubscriptions->where('billing_interval', 'yearly')->sum('billing_amount'),
        ];

        // Get user's currency
        $userCurrency = $this->currencyService->getUserCurrency();

        return view('customer.subscriptions.index', compact(
            'activeSubscriptions',
            'expiredSubscriptions',
            'cancelledSubscriptions',
            'expiringSoon',
            'metrics',
            'userCurrency',
            'currencyService'
        ));
    }

    /**
     * Display detailed subscription information
     */
    public function show(Subscription $subscription)
    {
        // Ensure subscription belongs to authenticated user
        if ($subscription->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to subscription');
        }

        $subscription->load(['service', 'order.items', 'reminderLogs' => function($query) {
            $query->orderBy('sent_at', 'desc')->limit(10);
        }]);

        // Calculate subscription metrics
        $metrics = [
            'days_active' => $subscription->starts_at->diffInDays(now()),
            'days_remaining' => now()->diffInDays($subscription->expires_at, false),
            'days_until_next_billing' => $subscription->next_billing_date 
                ? now()->diffInDays($subscription->next_billing_date, false) 
                : null,
            'total_paid' => $subscription->order->total_amount ?? 0,
            'renewal_count' => $subscription->renewal_count ?? 0,
        ];

        // Build simple timeline
        $timeline = $this->buildCustomerTimeline($subscription);

        // Get user's currency
        $userCurrency = $this->currencyService->getUserCurrency();

        return view('customer.subscriptions.show', compact(
            'subscription',
            'metrics',
            'timeline',
            'userCurrency',
            'currencyService'
        ));
    }

    /**
     * Show cancellation request form
     */
    public function requestCancellation(Subscription $subscription)
    {
        // Ensure subscription belongs to authenticated user
        if ($subscription->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to subscription');
        }

        // Check if subscription can be cancelled
        if (!in_array($subscription->status, ['active', 'trial'])) {
            return redirect()
                ->route('customer.subscriptions.show', $subscription)
                ->with('error', 'This subscription cannot be cancelled.');
        }

        return view('customer.subscriptions.cancel', compact('subscription'));
    }

    /**
     * Submit cancellation request
     */
    public function submitCancellationRequest(Request $request, Subscription $subscription)
    {
        // Ensure subscription belongs to authenticated user
        if ($subscription->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to subscription');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
            'feedback' => 'nullable|string|max:2000',
            'cancellation_type' => 'required|in:end_of_period,immediate',
        ]);

        // Store cancellation request in metadata
        $metadata = $subscription->metadata ?? [];
        $metadata['cancellation_request'] = [
            'requested_at' => now()->toDateTimeString(),
            'reason' => $request->reason,
            'feedback' => $request->feedback,
            'type' => $request->cancellation_type,
            'status' => 'pending_review',
        ];
        
        $subscription->update(['metadata' => $metadata]);

        // TODO: Send notification to admin
        // TODO: Optionally auto-approve based on settings

        return redirect()
            ->route('customer.subscriptions.show', $subscription)
            ->with('success', 'Your cancellation request has been submitted and is pending review. We will contact you shortly.');
    }

    /**
     * Toggle auto-renewal
     */
    public function toggleAutoRenewal(Subscription $subscription)
    {
        // Ensure subscription belongs to authenticated user
        if ($subscription->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to subscription');
        }

        if (!in_array($subscription->status, ['active', 'trial'])) {
            return back()->with('error', 'Cannot modify auto-renewal for this subscription status.');
        }

        $subscription->update([
            'auto_renew' => !$subscription->auto_renew
        ]);

        $message = $subscription->auto_renew 
            ? 'Auto-renewal has been enabled. Your subscription will automatically renew on ' . $subscription->next_billing_date->format('M d, Y')
            : 'Auto-renewal has been disabled. Please renew manually before ' . $subscription->expires_at->format('M d, Y');

        return back()->with('success', $message);
    }

    /**
     * Build customer-friendly timeline
     */
    protected function buildCustomerTimeline(Subscription $subscription): array
    {
        $timeline = [];

        // Subscription started
        $timeline[] = [
            'type' => 'started',
            'icon' => 'check-circle',
            'color' => 'green',
            'title' => 'Subscription Activated',
            'description' => 'Your subscription to ' . $subscription->service->title . ' began',
            'timestamp' => $subscription->starts_at,
        ];

        // Renewals
        if ($subscription->last_renewed_at) {
            $timeline[] = [
                'type' => 'renewed',
                'icon' => 'refresh',
                'color' => 'blue',
                'title' => 'Subscription Renewed',
                'description' => 'Your subscription was successfully renewed',
                'timestamp' => $subscription->last_renewed_at,
            ];
        }

        // Upcoming expiration or renewal
        if ($subscription->status === 'active') {
            $daysRemaining = now()->diffInDays($subscription->expires_at, false);
            
            if ($daysRemaining <= 30 && $daysRemaining > 0) {
                $timeline[] = [
                    'type' => 'expiring',
                    'icon' => 'clock',
                    'color' => $daysRemaining <= 7 ? 'red' : 'yellow',
                    'title' => 'Expiring Soon',
                    'description' => "Your subscription will expire in {$daysRemaining} days",
                    'timestamp' => $subscription->expires_at,
                    'future' => true,
                ];
            } elseif ($subscription->auto_renew && $subscription->next_billing_date) {
                $timeline[] = [
                    'type' => 'auto_renewal',
                    'icon' => 'refresh',
                    'color' => 'blue',
                    'title' => 'Scheduled Auto-Renewal',
                    'description' => 'Your subscription will automatically renew',
                    'timestamp' => $subscription->next_billing_date,
                    'future' => true,
                ];
            }
        }

        // Cancellation
        if ($subscription->cancelled_at) {
            $timeline[] = [
                'type' => 'cancelled',
                'icon' => 'x-circle',
                'color' => 'red',
                'title' => 'Subscription Cancelled',
                'description' => $subscription->cancellation_reason ?? 'Subscription was cancelled',
                'timestamp' => $subscription->cancelled_at,
            ];
        }

        // Expiration
        if ($subscription->status === 'expired') {
            $timeline[] = [
                'type' => 'expired',
                'icon' => 'ban',
                'color' => 'gray',
                'title' => 'Subscription Expired',
                'description' => 'Your subscription has ended',
                'timestamp' => $subscription->expires_at,
            ];
        }

        // Sort by timestamp (future events last)
        usort($timeline, function($a, $b) {
            $aFuture = $a['future'] ?? false;
            $bFuture = $b['future'] ?? false;
            
            if ($aFuture && !$bFuture) return 1;
            if (!$aFuture && $bFuture) return -1;
            
            return $a['timestamp'] <=> $b['timestamp'];
        });

        return $timeline;
    }
}

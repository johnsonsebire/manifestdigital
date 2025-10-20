<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SubscriptionAnalyticsController extends Controller
{
    /**
     * Display subscription analytics dashboard
     */
    public function index(Request $request)
    {
        $dateRange = $request->input('range', '30'); // days
        $startDate = now()->subDays((int) $dateRange);

        // Cache key for analytics data
        $cacheKey = "subscription_analytics_{$dateRange}_" . now()->format('Y-m-d-H');

        $analytics = Cache::remember($cacheKey, now()->addHours(1), function () use ($startDate) {
            return [
                'overview' => $this->getOverviewMetrics(),
                'renewal' => $this->getRenewalMetrics($startDate),
                'revenue' => $this->getRevenueMetrics($startDate),
                'customer' => $this->getCustomerInsights(),
                'expiration_timeline' => $this->getExpirationTimeline(),
                'top_services' => $this->getTopServices(),
                'status_distribution' => $this->getStatusDistribution(),
                'growth_trends' => $this->getGrowthTrends(),
            ];
        });

        return view('admin.subscriptions.analytics', [
            'analytics' => $analytics,
            'dateRange' => $dateRange,
        ]);
    }

    /**
     * Get overview metrics
     */
    private function getOverviewMetrics(): array
    {
        $total = Subscription::count();
        $active = Subscription::where('status', 'active')->count();
        $expiringSoon = Subscription::where('status', 'active')
            ->where('expires_at', '<=', now()->addDays(30))
            ->where('expires_at', '>', now())
            ->count();
        $expired = Subscription::where('status', 'expired')->count();
        $newThisMonth = Subscription::where('created_at', '>=', now()->startOfMonth())->count();

        return [
            'total' => $total,
            'active' => $active,
            'expiring_soon' => $expiringSoon,
            'expired' => $expired,
            'new_this_month' => $newThisMonth,
            'active_percentage' => $total > 0 ? round(($active / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Get renewal metrics
     */
    private function getRenewalMetrics($startDate): array
    {
        // Get subscriptions that were up for renewal in the period
        $renewals = Subscription::where('created_at', '>=', $startDate)
            ->where('status', 'active')
            ->count();

        $cancellations = Subscription::where('cancelled_at', '>=', $startDate)
            ->count();

        $totalEligible = $renewals + $cancellations;

        $renewalRate = $totalEligible > 0 
            ? round(($renewals / $totalEligible) * 100, 1) 
            : 0;

        // Average days before expiration when renewed
        $avgRenewalTiming = Subscription::where('created_at', '>=', $startDate)
            ->where('status', 'active')
            ->whereNotNull('expires_at')
            ->get()
            ->map(function ($sub) {
                return $sub->expires_at->diffInDays($sub->created_at);
            })
            ->avg();

        return [
            'renewals' => $renewals,
            'cancellations' => $cancellations,
            'renewal_rate' => $renewalRate,
            'avg_renewal_timing' => $avgRenewalTiming ? round($avgRenewalTiming, 1) : 0,
        ];
    }

    /**
     * Get revenue metrics
     */
    private function getRevenueMetrics($startDate): array
    {
        // Monthly Recurring Revenue (active subscriptions)
        $mrr = Subscription::where('status', 'active')
            ->where('billing_interval', 'monthly')
            ->sum('renewal_price');

        // Annual Recurring Revenue
        $yearlyRevenue = Subscription::where('status', 'active')
            ->where('billing_interval', 'yearly')
            ->sum('renewal_price');

        $arr = ($mrr * 12) + $yearlyRevenue;

        // Projected revenue from upcoming renewals (next 90 days)
        $projectedRevenue = Subscription::where('status', 'active')
            ->where('auto_renew', true)
            ->where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addDays(90))
            ->sum('renewal_price');

        // Revenue by service type
        $revenueByService = Subscription::where('status', 'active')
            ->join('services', 'subscriptions.service_id', '=', 'services.id')
            ->select('services.name', DB::raw('SUM(subscriptions.renewal_price) as total'))
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Recent revenue (from renewals in date range)
        $recentRevenue = Subscription::where('created_at', '>=', $startDate)
            ->where('status', 'active')
            ->sum('renewal_price');

        return [
            'mrr' => round($mrr, 2),
            'arr' => round($arr, 2),
            'projected_revenue' => round($projectedRevenue, 2),
            'revenue_by_service' => $revenueByService,
            'recent_revenue' => round($recentRevenue, 2),
        ];
    }

    /**
     * Get customer insights
     */
    private function getCustomerInsights(): array
    {
        $customersWithSubscriptions = Subscription::distinct('customer_id')->count('customer_id');
        $totalCustomers = User::role('Customer')->count();
        
        $avgSubscriptionsPerCustomer = $customersWithSubscriptions > 0 
            ? round(Subscription::count() / $customersWithSubscriptions, 1) 
            : 0;

        // Churn rate (cancelled in last 30 days / total active 30 days ago)
        $cancelledLast30 = Subscription::where('cancelled_at', '>=', now()->subDays(30))->count();
        $activeLast30 = Subscription::where('status', 'active')
            ->where('created_at', '<=', now()->subDays(30))
            ->count();

        $churnRate = $activeLast30 > 0 
            ? round(($cancelledLast30 / $activeLast30) * 100, 1) 
            : 0;

        return [
            'customers_with_subscriptions' => $customersWithSubscriptions,
            'total_customers' => $totalCustomers,
            'avg_subscriptions_per_customer' => $avgSubscriptionsPerCustomer,
            'churn_rate' => $churnRate,
        ];
    }

    /**
     * Get expiration timeline (next 90 days)
     */
    private function getExpirationTimeline(): array
    {
        $timeline = [];
        
        for ($i = 0; $i <= 90; $i += 10) {
            $startDay = now()->addDays($i);
            $endDay = now()->addDays($i + 9);
            
            $count = Subscription::where('status', 'active')
                ->whereBetween('expires_at', [$startDay, $endDay])
                ->count();

            $timeline[] = [
                'label' => $i === 0 ? '0-9 days' : "{$i}-" . ($i + 9) . " days",
                'count' => $count,
            ];
        }

        return $timeline;
    }

    /**
     * Get top services by subscription count
     */
    private function getTopServices(): array
    {
        return Subscription::join('services', 'subscriptions.service_id', '=', 'services.id')
            ->select('services.name', DB::raw('COUNT(*) as subscription_count'))
            ->where('subscriptions.status', 'active')
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('subscription_count')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get status distribution
     */
    private function getStatusDistribution(): array
    {
        return Subscription::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            })
            ->toArray();
    }

    /**
     * Get growth trends (last 12 months)
     */
    private function getGrowthTrends(): array
    {
        $trends = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            
            $newSubscriptions = Subscription::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $cancelled = Subscription::whereBetween('cancelled_at', [$monthStart, $monthEnd])->count();
            $netGrowth = $newSubscriptions - $cancelled;

            $trends[] = [
                'month' => $monthStart->format('M Y'),
                'new' => $newSubscriptions,
                'cancelled' => $cancelled,
                'net_growth' => $netGrowth,
            ];
        }

        return $trends;
    }

    /**
     * Export analytics to CSV
     */
    public function export(Request $request)
    {
        $dateRange = $request->input('range', '30');
        $startDate = now()->subDays((int) $dateRange);

        $subscriptions = Subscription::with(['service', 'customer'])
            ->where('created_at', '>=', $startDate)
            ->get();

        $filename = 'subscription-analytics-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($subscriptions) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID',
                'UUID',
                'Customer',
                'Service',
                'Status',
                'Billing Interval',
                'Price',
                'Started At',
                'Expires At',
                'Auto Renew',
                'Cancelled At',
            ]);

            // Data rows
            foreach ($subscriptions as $subscription) {
                fputcsv($file, [
                    $subscription->id,
                    $subscription->uuid,
                    $subscription->customer->name ?? 'N/A',
                    $subscription->service->name ?? 'N/A',
                    $subscription->status,
                    $subscription->billing_interval,
                    $subscription->renewal_price,
                    $subscription->starts_at?->format('Y-m-d'),
                    $subscription->expires_at?->format('Y-m-d'),
                    $subscription->auto_renew ? 'Yes' : 'No',
                    $subscription->cancelled_at?->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get chart data for AJAX requests
     */
    public function chartData(Request $request)
    {
        $type = $request->input('type');
        $range = $request->input('range', '30');
        $startDate = now()->subDays((int) $range);

        $data = match ($type) {
            'expiration' => $this->getExpirationTimeline(),
            'growth' => $this->getGrowthTrends(),
            'status' => $this->getStatusDistribution(),
            'revenue' => $this->getRevenueMetrics($startDate),
            default => [],
        };

        return response()->json($data);
    }
}

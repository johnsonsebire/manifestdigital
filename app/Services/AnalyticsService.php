<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\FormSubmission;
use App\Models\Form;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsService
{
    /**
     * Get revenue analytics data
     */
    public function getRevenueAnalytics(string $period = 'month', int $periods = 12): array
    {
        $groupFormat = $this->getGroupFormat($period);
        
        $revenueData = Order::where('status', 'completed')
            ->where('created_at', '>=', $this->getStartDate($period, $periods))
            ->selectRaw("DATE_FORMAT(created_at, '{$groupFormat}') as period")
            ->selectRaw('SUM(total) as revenue')
            ->selectRaw('COUNT(*) as order_count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return [
            'labels' => $revenueData->pluck('period')->toArray(),
            'revenue' => $revenueData->pluck('revenue')->map(fn($v) => (float) $v)->toArray(),
            'orders' => $revenueData->pluck('order_count')->toArray(),
        ];
    }

    /**
     * Get order status distribution
     */
    public function getOrderStatusDistribution(): array
    {
        $distribution = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return [
            'labels' => $distribution->pluck('status')->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))->toArray(),
            'data' => $distribution->pluck('count')->toArray(),
            'colors' => $this->getStatusColors($distribution->pluck('status')->toArray()),
        ];
    }

    /**
     * Get order trends over time
     */
    public function getOrderTrends(string $period = 'month', int $periods = 12): array
    {
        $groupFormat = $this->getGroupFormat($period);
        $startDate = $this->getStartDate($period, $periods);

        $trends = Order::where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '{$groupFormat}') as period")
            ->selectRaw('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('period', 'status')
            ->orderBy('period')
            ->get()
            ->groupBy('status');

        $periods = $this->generatePeriodLabels($period, $periods);
        
        $datasets = [];
        foreach ($trends as $status => $data) {
            $dataMap = $data->pluck('count', 'period')->toArray();
            $datasets[] = [
                'label' => ucfirst(str_replace('_', ' ', $status)),
                'data' => array_map(fn($p) => $dataMap[$p] ?? 0, $periods),
            ];
        }

        return [
            'labels' => $periods,
            'datasets' => $datasets,
        ];
    }

    /**
     * Get project completion analytics
     */
    public function getProjectAnalytics(): array
    {
        $totalProjects = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();
        $completionRate = $totalProjects > 0 ? ($completedProjects / $totalProjects) * 100 : 0;

        // Average project duration (in days)
        $avgDuration = Project::where('status', 'completed')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->selectRaw('AVG(DATEDIFF(end_date, start_date)) as avg_days')
            ->first()
            ->avg_days ?? 0;

        // Project status distribution
        $statusDistribution = Project::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Projects by month
        $projectsByMonth = Project::where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month")
            ->selectRaw('COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'total' => $totalProjects,
            'completed' => $completedProjects,
            'completion_rate' => round($completionRate, 2),
            'avg_duration_days' => round($avgDuration, 1),
            'status_distribution' => [
                'labels' => $statusDistribution->pluck('status')->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))->toArray(),
                'data' => $statusDistribution->pluck('count')->toArray(),
            ],
            'projects_over_time' => [
                'labels' => $projectsByMonth->pluck('month')->toArray(),
                'data' => $projectsByMonth->pluck('count')->toArray(),
            ],
        ];
    }

    /**
     * Get form submission analytics
     */
    public function getFormAnalytics(): array
    {
        $forms = Form::withCount('submissions')->get();
        
        // Submissions over time (last 12 months)
        $submissionsByMonth = FormSubmission::where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month")
            ->selectRaw('COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Daily submissions (last 30 days)
        $dailySubmissions = FormSubmission::where('created_at', '>=', now()->subDays(30))
            ->selectRaw("DATE(created_at) as date")
            ->selectRaw('COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top performing forms
        $topForms = $forms->sortByDesc('submissions_count')->take(5);

        return [
            'total_forms' => $forms->count(),
            'total_submissions' => $forms->sum('submissions_count'),
            'avg_submissions_per_form' => $forms->count() > 0 ? round($forms->avg('submissions_count'), 1) : 0,
            'submissions_by_month' => [
                'labels' => $submissionsByMonth->pluck('month')->toArray(),
                'data' => $submissionsByMonth->pluck('count')->toArray(),
            ],
            'daily_submissions' => [
                'labels' => $dailySubmissions->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray(),
                'data' => $dailySubmissions->pluck('count')->toArray(),
            ],
            'top_forms' => $topForms->map(fn($f) => [
                'name' => $f->title,
                'submissions' => $f->submissions_count,
            ])->toArray(),
        ];
    }

    /**
     * Get invoice analytics
     */
    public function getInvoiceAnalytics(): array
    {
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $totalBilled = Invoice::sum('total_amount');
        $totalCollected = Invoice::sum('amount_paid');
        $totalOutstanding = Invoice::whereIn('status', ['sent', 'partial', 'overdue'])->sum('balance_due');
        
        $collectionRate = $totalBilled > 0 ? ($totalCollected / $totalBilled) * 100 : 0;

        // Invoices by status
        $statusDistribution = Invoice::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Revenue collected over time
        $revenueCollected = Invoice::where('status', 'paid')
            ->where('paid_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month")
            ->selectRaw('SUM(total_amount) as amount')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'total_invoices' => $totalInvoices,
            'paid_invoices' => $paidInvoices,
            'total_billed' => (float) $totalBilled,
            'total_collected' => (float) $totalCollected,
            'total_outstanding' => (float) $totalOutstanding,
            'collection_rate' => round($collectionRate, 2),
            'status_distribution' => [
                'labels' => $statusDistribution->pluck('status')->map(fn($s) => ucfirst($s))->toArray(),
                'data' => $statusDistribution->pluck('count')->toArray(),
            ],
            'revenue_collected' => [
                'labels' => $revenueCollected->pluck('month')->toArray(),
                'data' => $revenueCollected->pluck('amount')->map(fn($v) => (float) $v)->toArray(),
            ],
        ];
    }

    /**
     * Get top customers by revenue
     */
    public function getTopCustomers(int $limit = 10): array
    {
        return Order::select('customer_id')
            ->selectRaw('SUM(total) as total_revenue')
            ->selectRaw('COUNT(*) as order_count')
            ->with('customer:id,name,email')
            ->groupBy('customer_id')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get()
            ->map(fn($o) => [
                'customer_name' => $o->customer->name ?? 'Guest',
                'customer_email' => $o->customer->email ?? '',
                'total_revenue' => (float) $o->total_revenue,
                'order_count' => $o->order_count,
            ])
            ->toArray();
    }

    /**
     * Get top services by sales
     */
    public function getTopServices(int $limit = 10): array
    {
        return DB::table('order_items')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->select('services.title')
            ->selectRaw('COUNT(order_items.id) as times_ordered')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->selectRaw('SUM(order_items.line_total) as total_revenue')
            ->groupBy('services.id', 'services.title')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get()
            ->map(fn($s) => [
                'service_name' => $s->title,
                'times_ordered' => $s->times_ordered,
                'total_quantity' => $s->total_quantity,
                'total_revenue' => (float) $s->total_revenue,
            ])
            ->toArray();
    }

    /**
     * Get dashboard summary statistics
     */
    public function getDashboardSummary(): array
    {
        $now = now();
        
        return [
            'orders' => [
                'total' => Order::count(),
                'this_month' => Order::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count(),
                'pending' => Order::where('status', 'pending')->count(),
                'completed' => Order::where('status', 'completed')->count(),
            ],
            'revenue' => [
                'total' => (float) Order::where('status', 'completed')->sum('total'),
                'this_month' => (float) Order::where('status', 'completed')
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->sum('total'),
                'this_year' => (float) Order::where('status', 'completed')
                    ->whereYear('created_at', $now->year)
                    ->sum('total'),
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::whereIn('status', ['planning', 'in_progress'])->count(),
                'completed' => Project::where('status', 'completed')->count(),
                'on_hold' => Project::where('status', 'on_hold')->count(),
            ],
            'invoices' => [
                'total' => Invoice::count(),
                'paid' => Invoice::where('status', 'paid')->count(),
                'outstanding' => (float) Invoice::whereIn('status', ['sent', 'partial', 'overdue'])->sum('balance_due'),
                'overdue' => Invoice::where('status', 'overdue')->count(),
            ],
            'forms' => [
                'total_submissions' => FormSubmission::count(),
                'today' => FormSubmission::whereDate('created_at', $now->toDateString())->count(),
                'this_week' => FormSubmission::whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()])->count(),
                'this_month' => FormSubmission::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count(),
            ],
        ];
    }

    /**
     * Get date grouping format based on period
     */
    protected function getGroupFormat(string $period): string
    {
        return match($period) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%U',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => '%Y-%m',
        };
    }

    /**
     * Get start date based on period and number of periods
     */
    protected function getStartDate(string $period, int $periods): Carbon
    {
        return match($period) {
            'day' => now()->subDays($periods),
            'week' => now()->subWeeks($periods),
            'month' => now()->subMonths($periods),
            'year' => now()->subYears($periods),
            default => now()->subMonths($periods),
        };
    }

    /**
     * Generate period labels
     */
    protected function generatePeriodLabels(string $period, int $count): array
    {
        $labels = [];
        $date = $this->getStartDate($period, $count);
        
        for ($i = 0; $i < $count; $i++) {
            $labels[] = $date->format($period === 'month' ? 'Y-m' : 'Y-m-d');
            $date = match($period) {
                'day' => $date->addDay(),
                'week' => $date->addWeek(),
                'month' => $date->addMonth(),
                'year' => $date->addYear(),
                default => $date->addMonth(),
            };
        }
        
        return $labels;
    }

    /**
     * Get status colors for charts
     */
    protected function getStatusColors(array $statuses): array
    {
        $colorMap = [
            'pending' => '#eab308',
            'approved' => '#3b82f6',
            'paid' => '#10b981',
            'in_progress' => '#8b5cf6',
            'completed' => '#059669',
            'cancelled' => '#ef4444',
            'on_hold' => '#f97316',
            'draft' => '#6b7280',
            'sent' => '#3b82f6',
            'partial' => '#f59e0b',
            'overdue' => '#dc2626',
        ];

        return array_map(fn($status) => $colorMap[$status] ?? '#6b7280', $statuses);
    }
}

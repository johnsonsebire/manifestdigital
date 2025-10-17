<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    protected AnalyticsService $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display the analytics dashboard
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'month'); // day, week, month, year
        $periods = $request->get('periods', 12); // number of periods to show

        $summary = $this->analyticsService->getDashboardSummary();
        $revenue = $this->analyticsService->getRevenueAnalytics($period, $periods);
        $order_status = $this->analyticsService->getOrderStatusDistribution();
        $order_trends = $this->analyticsService->getOrderTrends($period, $periods);
        $projects = $this->analyticsService->getProjectAnalytics();
        $invoices = $this->analyticsService->getInvoiceAnalytics();
        $forms = $this->analyticsService->getFormAnalytics();
        $top_customers = $this->analyticsService->getTopCustomers(10);
        $top_services = $this->analyticsService->getTopServices(5);

        return view('admin.reports.index', compact(
            'summary',
            'revenue',
            'order_status',
            'order_trends',
            'projects',
            'invoices',
            'forms',
            'top_customers',
            'top_services'
        ))->with([
            'selected_period' => $period,
            'selected_periods' => $periods
        ]);
    }

    /**
     * Export revenue report
     */
    public function exportRevenue(Request $request)
    {
        $period = $request->get('period', 'month');
        $periods = $request->get('periods', 12);
        
        $data = $this->analyticsService->getRevenueAnalytics($period, $periods);
        
        // TODO: Implement CSV/Excel export
        return response()->json($data);
    }

    /**
     * Export orders report
     */
    public function exportOrders(Request $request)
    {
        $period = $request->get('period', 'month');
        $periods = $request->get('periods', 12);
        
        $data = $this->analyticsService->getOrderTrends($period, $periods);
        
        // TODO: Implement CSV/Excel export
        return response()->json($data);
    }

    /**
     * Get analytics data as JSON for AJAX requests
     */
    public function getData(Request $request)
    {
        $type = $request->get('type');
        $period = $request->get('period', 'month');
        $periods = $request->get('periods', 12);

        $data = match($type) {
            'revenue' => $this->analyticsService->getRevenueAnalytics($period, $periods),
            'orders' => $this->analyticsService->getOrderTrends($period, $periods),
            'projects' => $this->analyticsService->getProjectAnalytics(),
            'invoices' => $this->analyticsService->getInvoiceAnalytics(),
            'forms' => $this->analyticsService->getFormAnalytics(),
            'customers' => $this->analyticsService->getTopCustomers(10),
            'services' => $this->analyticsService->getTopServices(10),
            'summary' => $this->analyticsService->getDashboardSummary(),
            default => ['error' => 'Invalid type'],
        };

        return response()->json($data);
    }
}

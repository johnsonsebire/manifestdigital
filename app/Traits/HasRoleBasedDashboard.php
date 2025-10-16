<?php

namespace App\Traits;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\DB;

trait HasRoleBasedDashboard
{
    /**
     * Get dashboard data based on user's role.
     *
     * @return array
     */
    public function getDashboardData(): array
    {
        $user = auth()->user();

        if ($user->hasRole(['Super Admin', 'Administrator'])) {
            return $this->getAdminDashboardData();
        }

        // Default dashboard for regular users
        return $this->getUserDashboardData();
    }

    /**
     * Get dashboard data for Super Admin and Administrator roles.
     *
     * @return array
     */
    protected function getAdminDashboardData(): array
    {
        return [
            'type' => 'admin',
            'metrics' => $this->getFormSubmissionMetrics(),
            'recentSubmissions' => $this->getRecentSubmissions(10),
            'topForms' => $this->getTopForms(5),
        ];
    }

    /**
     * Get dashboard data for regular users.
     *
     * @return array
     */
    protected function getUserDashboardData(): array
    {
        return [
            'type' => 'user',
            'message' => 'Welcome to your dashboard!',
        ];
    }

    /**
     * Get form submission metrics.
     *
     * @return array
     */
    protected function getFormSubmissionMetrics(): array
    {
        $totalSubmissions = FormSubmission::count();
        $submissionsToday = FormSubmission::whereDate('created_at', today())->count();
        $submissionsThisWeek = FormSubmission::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        $submissionsThisMonth = FormSubmission::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get submissions from last month for comparison
        $submissionsLastMonth = FormSubmission::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // Calculate percentage change
        $monthlyChange = 0;
        if ($submissionsLastMonth > 0) {
            $monthlyChange = (($submissionsThisMonth - $submissionsLastMonth) / $submissionsLastMonth) * 100;
        } elseif ($submissionsThisMonth > 0) {
            $monthlyChange = 100;
        }

        return [
            'total' => $totalSubmissions,
            'today' => $submissionsToday,
            'this_week' => $submissionsThisWeek,
            'this_month' => $submissionsThisMonth,
            'last_month' => $submissionsLastMonth,
            'monthly_change' => round($monthlyChange, 1),
            'total_forms' => Form::count(),
            'active_forms' => Form::where('is_active', true)->count(),
        ];
    }

    /**
     * Get recent form submissions.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getRecentSubmissions(int $limit = 10)
    {
        return FormSubmission::with(['form:id,name,slug'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get top forms by submission count.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    protected function getTopForms(int $limit = 5)
    {
        return Form::withCount('submissions')
            ->orderBy('submissions_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get submission trend data for charts (last 30 days).
     *
     * @return array
     */
    protected function getSubmissionTrendData(): array
    {
        $data = FormSubmission::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => date('M d', strtotime($date)))->toArray(),
            'values' => $data->pluck('count')->toArray(),
        ];
    }
}

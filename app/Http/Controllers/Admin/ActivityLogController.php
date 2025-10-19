<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = Activity::query()
            ->with(['causer', 'subject'])
            ->latest();

        // Filter by log name (model type)
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        // Filter by causer (user who performed the action)
        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        // Filter by event type
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activities = $query->paginate(50);

        // Get filter options
        $logNames = Activity::select('log_name')
            ->distinct()
            ->whereNotNull('log_name')
            ->pluck('log_name')
            ->sort();

        $events = Activity::select('event')
            ->distinct()
            ->whereNotNull('event')
            ->pluck('event')
            ->sort();

        $causers = Activity::with('causer')
            ->whereNotNull('causer_id')
            ->get()
            ->pluck('causer')
            ->filter()
            ->unique('id')
            ->sortBy('name');

        return view('admin.activity-logs.index', compact(
            'activities',
            'logNames',
            'events',
            'causers'
        ));
    }

    /**
     * Show the specified activity log.
     */
    public function show(Activity $activity)
    {
        $activity->load(['causer', 'subject']);

        return view('admin.activity-logs.show', compact('activity'));
    }

    /**
     * Delete activity logs older than specified days.
     */
    public function cleanup(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $cutoffDate = now()->subDays($request->days);
        $deletedCount = Activity::where('created_at', '<', $cutoffDate)->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with('success', "Deleted {$deletedCount} activity log entries older than {$request->days} days.");
    }

    /**
     * Export activity logs to CSV.
     */
    public function export(Request $request)
    {
        $query = Activity::query()
            ->with(['causer', 'subject'])
            ->latest();

        // Apply same filters as index
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activities = $query->limit(5000)->get(); // Limit for performance

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-logs-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Log Name',
                'Description',
                'Event',
                'Subject Type',
                'Subject ID',
                'Causer Type',
                'Causer ID',
                'Causer Name',
                'Properties',
                'Created At'
            ]);

            // CSV Data
            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->id,
                    $activity->log_name,
                    $activity->description,
                    $activity->event,
                    $activity->subject_type,
                    $activity->subject_id,
                    $activity->causer_type,
                    $activity->causer_id,
                    $activity->causer?->name ?? 'System',
                    json_encode($activity->properties),
                    $activity->created_at->toDateTimeString()
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get activity statistics for dashboard.
     */
    public function statistics()
    {
        $stats = [
            'total_activities' => Activity::count(),
            'activities_today' => Activity::whereDate('created_at', today())->count(),
            'activities_this_week' => Activity::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'activities_this_month' => Activity::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'top_events' => Activity::select('event')
                ->selectRaw('count(*) as count')
                ->groupBy('event')
                ->orderByDesc('count')
                ->limit(10)
                ->get(),
            'top_models' => Activity::select('log_name')
                ->selectRaw('count(*) as count')
                ->whereNotNull('log_name')
                ->groupBy('log_name')
                ->orderByDesc('count')
                ->limit(10)
                ->get(),
            'most_active_users' => Activity::with('causer')
                ->whereNotNull('causer_id')
                ->select('causer_id')
                ->selectRaw('count(*) as count')
                ->groupBy('causer_id')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Get activity timeline for a specific subject.
     */
    public function timeline(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|string',
            'subject_id' => 'required|integer',
        ]);

        $activities = Activity::where('subject_type', $request->subject_type)
            ->where('subject_id', $request->subject_id)
            ->with('causer')
            ->latest()
            ->paginate(20);

        return response()->json($activities);
    }

    /**
     * Get recent activities for dashboard widget.
     */
    public function recent(Request $request)
    {
        $limit = $request->get('limit', 10);
        
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'event' => $activity->event,
                    'log_name' => $activity->log_name,
                    'causer_name' => $activity->causer?->name ?? 'System',
                    'created_at' => $activity->created_at->diffForHumans(),
                    'created_at_full' => $activity->created_at->toDateTimeString(),
                ];
            });

        return response()->json($activities);
    }
}
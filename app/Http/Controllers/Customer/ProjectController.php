<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the customer's projects.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->projects()
            ->with(['order', 'team', 'tasks'])
            ->withCount(['tasks', 'messages']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $projects = $query->paginate(10)->withQueryString();

        // Statistics
        $stats = [
            'total' => auth()->user()->projects()->count(),
            'active' => auth()->user()->projects()->whereIn('status', ['planning', 'in_progress'])->count(),
            'completed' => auth()->user()->projects()->where('status', 'completed')->count(),
            'on_hold' => auth()->user()->projects()->where('status', 'on_hold')->count(),
        ];

        return view('customer.projects.index', compact('projects', 'stats'));
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Ensure user owns this project
        $this->authorize('view', $project);

        $project->load([
            'order.items.service',
            'team',
            'tasks' => function ($query) {
                $query->orderBy('order');
            },
            'milestones' => function ($query) {
                $query->orderBy('due_date');
            },
            'files',
        ]);

        // Get activity logs for this project
        $activities = ActivityLog::where('project_id', $project->id)
            ->with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('customer.projects.show', compact('project', 'activities'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with(['order.customer', 'client']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filter by client
        if ($request->filled('client_id')) {
            $query->forClient($request->client_id);
        }

        // Filter by assigned team member
        if ($request->filled('team_member')) {
            $query->whereHas('team', function($q) use ($request) {
                $q->where('user_id', $request->team_member);
            });
        }

        // Date range filter
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $projects = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total' => Project::count(),
            'planning' => Project::where('status', 'planning')->count(),
            'active' => Project::where('status', 'in_progress')->count(), // Active = In Progress
            'in_progress' => Project::where('status', 'in_progress')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
            'completed' => Project::where('status', 'complete')->count(),
            'complete' => Project::where('status', 'complete')->count(),
            'archived' => Project::where('status', 'archived')->count(),
        ];

        // Get all staff users for team filter
        $teamMembers = User::role(['Super Admin','Administrator', 'Staff'])->orderBy('name')->get();

        // Get all clients for client filter
        $clients = User::role('Customer')->orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'stats', 'teamMembers', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get orders that don't have projects yet
        $orders = Order::whereDoesntHave('project')
            ->where('status', '!=', 'cancelled')
            ->with(['customer', 'items'])
            ->latest()
            ->get();

        return view('admin.projects.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,in_progress,on_hold,complete,archived',
        ]);

        // Get the order to retrieve client_id
        $order = Order::findOrFail($validated['order_id']);
        
        // Only set client_id if the order has a registered customer
        // For manual customers (non-registered), client_id will be null
        $validated['client_id'] = $order->customer_id;

        $project = Project::create($validated);

        // Update the order to link it to this project
        $order->update(['assigned_project_id' => $project->id]);

        // Log activity
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'project_created',
            'description' => 'Project created by ' . auth()->user()->name,
        ]);

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'order.customer',
            'order.items.service',
            'tasks' => function($q) {
                $q->with('assignee')->latest();
            },
            'milestones' => function($q) {
                $q->latest();
            },
            'team.user',
            'files',
            'messages.sender',
            'activities.user'
        ]);

        // Get available staff for team assignment
        $availableStaff = User::role(['Administrator', 'Staff'])
            ->whereNotIn('id', $project->team->pluck('user_id'))
            ->orderBy('name')
            ->get();

        return view('admin.projects.show', compact('project', 'availableStaff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project->load('order.customer');
        
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,in_progress,on_hold,complete,archived',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        $oldStatus = $project->status;
        $project->update($validated);

        // Log status change
        if ($oldStatus !== $project->status) {
            ActivityLog::create([
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'type' => 'project_status_changed',
                'description' => 'Project status changed from ' . $oldStatus . ' to ' . $project->status . ' by ' . auth()->user()->name,
            ]);
        }

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Check if project can be deleted
        if ($project->status === 'active') {
            return back()->with('error', 'Cannot delete active projects. Change status first.');
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Add team member to project
     */
    public function addTeamMember(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:manager,developer,designer,tester',
        ]);

        // Check if already a team member
        if ($project->team()->where('user_id', $validated['user_id'])->exists()) {
            return back()->with('error', 'User is already a team member.');
        }

        $project->team()->create($validated);

        // Log activity
        $user = User::find($validated['user_id']);
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'team_member_added',
            'description' => $user->name . ' added to project team as ' . $validated['role'],
        ]);

        return back()->with('success', 'Team member added successfully.');
    }

    /**
     * Remove team member from project
     */
    public function removeTeamMember(Project $project, $teamMemberId)
    {
        $teamMember = $project->team()->findOrFail($teamMemberId);
        $userName = $teamMember->user->name;
        
        $teamMember->delete();

        // Log activity
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'team_member_removed',
            'description' => $userName . ' removed from project team',
        ]);

        return back()->with('success', 'Team member removed successfully.');
    }

    /**
     * Update project completion percentage
     */
    public function updateProgress(Request $request, Project $project)
    {
        $validated = $request->validate([
            'completion_percentage' => 'required|integer|min:0|max:100',
        ]);

        $oldPercentage = $project->completion_percentage;
        $project->update($validated);

        // Auto-complete if 100%
        if ($project->completion_percentage === 100 && $project->status !== 'completed') {
            $project->update(['status' => 'completed']);
        }

        // Log activity
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'progress_updated',
            'description' => 'Project progress updated from ' . $oldPercentage . '% to ' . $project->completion_percentage . '%',
        ]);

        return back()->with('success', 'Project progress updated successfully.');
    }
}

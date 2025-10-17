<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task = $project->tasks()->create($validated);

        // Log activity
        $project->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'task_created',
            'description' => 'Task "' . $task->title . '" created by ' . auth()->user()->name,
        ]);

        return back()->with('success', 'Task created successfully.');
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $oldStatus = $task->status;
        $task->update($validated);

        // Log status change
        if ($oldStatus !== $task->status) {
            $project->activities()->create([
                'user_id' => auth()->id(),
                'action' => 'task_status_updated',
                'description' => 'Task "' . $task->title . '" status changed from ' . $oldStatus . ' to ' . $task->status,
            ]);
        }

        return back()->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $taskTitle = $task->title;
        $task->delete();

        // Log activity
        $project->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'task_deleted',
            'description' => 'Task "' . $taskTitle . '" deleted by ' . auth()->user()->name,
        ]);

        return back()->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle task completion status
     */
    public function toggleStatus(Project $project, Task $task)
    {
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);

        // Log activity
        $action = $newStatus === 'completed' ? 'marked as complete' : 'marked as incomplete';
        $project->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'task_toggled',
            'description' => 'Task "' . $task->title . '" ' . $action . ' by ' . auth()->user()->name,
        ]);

        // Update project completion percentage based on tasks
        $this->updateProjectProgress($project);

        return back()->with('success', 'Task status updated successfully.');
    }

    /**
     * Update project completion based on task completion
     */
    protected function updateProjectProgress(Project $project)
    {
        $totalTasks = $project->tasks()->count();
        
        if ($totalTasks > 0) {
            $completedTasks = $project->tasks()->where('status', 'completed')->count();
            $percentage = round(($completedTasks / $totalTasks) * 100);
            
            $project->update(['completion_percentage' => $percentage]);
            
            // Auto-complete project if all tasks done
            if ($percentage === 100 && $project->status !== 'completed') {
                $project->update(['status' => 'completed']);
                
                $project->activities()->create([
                    'user_id' => auth()->id(),
                    'action' => 'project_auto_completed',
                    'description' => 'Project automatically marked as completed (all tasks finished)',
                ]);
            }
        }
    }
}

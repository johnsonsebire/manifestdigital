<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:0,1,2,3', // 0=low, 1=medium, 2=high, 3=urgent
            'status' => 'required|in:todo,in_progress,review,done',
            'due_date' => 'nullable|date',
        ]);

        $task = $project->tasks()->create($validated);

        // Log activity
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'task_created',
            'description' => 'Task "' . $task->title . '" created by ' . auth()->user()->name,
        ]);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Task created successfully.');
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:0,1,2,3', // 0=low, 1=medium, 2=high, 3=urgent
            'status' => 'required|in:todo,in_progress,review,done',
            'due_date' => 'nullable|date',
        ]);

        $oldStatus = $task->status;
        $task->update($validated);

        // Log status change
        if ($oldStatus !== $task->status) {
            ActivityLog::create([
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'type' => 'task_status_updated',
                'description' => 'Task "' . $task->title . '" status changed from ' . $oldStatus . ' to ' . $task->status,
            ]);
        }

        return redirect()->route('admin.projects.show', $project)->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $taskTitle = $task->title;
        $task->delete();

        // Log activity
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'task_deleted',
            'description' => 'Task "' . $taskTitle . '" deleted by ' . auth()->user()->name,
        ]);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle task completion status
     */
    public function toggleStatus(Project $project, Task $task)
    {
        $newStatus = $task->status === 'done' ? 'todo' : 'done';
        $task->update(['status' => $newStatus]);

        // Log activity
        $action = $newStatus === 'done' ? 'marked as complete' : 'marked as incomplete';
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'task_toggled',
            'description' => 'Task "' . $task->title . '" ' . $action . ' by ' . auth()->user()->name,
        ]);

        // Update project completion percentage based on tasks
        $this->updateProjectProgress($project);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Task status updated successfully.');
    }

    /**
     * Update project completion based on task completion
     */
    protected function updateProjectProgress(Project $project)
    {
        $totalTasks = $project->tasks()->count();
        
        if ($totalTasks > 0) {
            $completedTasks = $project->tasks()->where('status', 'done')->count();
            $percentage = round(($completedTasks / $totalTasks) * 100);
            
            $project->update(['completion_percentage' => $percentage]);
            
            // Auto-complete project if all tasks done
            if ($percentage === 100 && $project->status !== 'complete') {
                $project->update(['status' => 'complete']);
                
                ActivityLog::create([
                    'project_id' => $project->id,
                    'user_id' => auth()->id(),
                    'type' => 'project_auto_completed',
                    'description' => 'Project automatically marked as completed (all tasks finished)',
                ]);
            }
        }
    }
}

<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Staff and admins can view all tasks
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        // Admins and staff can view all tasks
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Load the project relationship if not already loaded
        $task->loadMissing('project');

        // Check if user can view the parent project
        return $user->can('view', $task->project);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Staff, admins, and project team members can create tasks
        // Actual project membership is checked in the controller
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // Admins can update any task
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Staff can update any task
        if ($user->hasRole('Staff')) {
            return true;
        }

        // Load relationships if not already loaded
        $task->loadMissing(['project', 'assignee']);

        // Assigned user can update their own tasks
        if ($task->assignee_id === $user->id) {
            return true;
        }

        // Project team members with manager role can update tasks
        return $task->project->team()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'manager')
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Admins can delete any task
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Load the project relationship if not already loaded
        $task->loadMissing('project');

        // Project managers and staff can delete tasks
        if ($user->hasRole('Staff')) {
            return true;
        }

        return $task->project->team()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'manager')
            ->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        // Admins and staff can restore tasks
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        // Only admins can permanently delete tasks
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can assign the task to someone.
     */
    public function assign(User $user, Task $task): bool
    {
        // Admins and staff can assign tasks
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Load the project relationship if not already loaded
        $task->loadMissing('project');

        // Project managers can assign tasks
        return $task->project->team()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'manager')
            ->exists();
    }

    /**
     * Determine whether the user can log time to the task.
     */
    public function logTime(User $user, Task $task): bool
    {
        // Admins and staff can log time to any task
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Load relationships if not already loaded
        $task->loadMissing(['project', 'assignee']);

        // Assigned user can log time to their task
        if ($task->assignee_id === $user->id) {
            return true;
        }

        // Project team members can log time
        return $task->project->team()->where('user_id', $user->id)->exists();
    }
}

<?php

namespace App\Policies;

use App\Models\ProjectMessage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectMessagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Staff and admins can view all messages
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectMessage $projectMessage): bool
    {
        // Admins and staff can view all messages
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Load the project relationship if not already loaded
        $projectMessage->loadMissing('project');

        // Cannot view internal messages unless staff/admin or team member
        if ($projectMessage->is_internal) {
            return $projectMessage->project->team()->where('user_id', $user->id)->exists();
        }

        // Check if user can view the parent project
        return $user->can('view', $projectMessage->project);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create messages (project access checked in controller)
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectMessage $projectMessage): bool
    {
        // Admins can update any message
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Staff can update any message
        if ($user->hasRole('Staff')) {
            return true;
        }

        // Users can update their own messages within a time window (e.g., 15 minutes)
        if ($projectMessage->user_id === $user->id) {
            return $projectMessage->created_at->diffInMinutes(now()) < 15;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectMessage $projectMessage): bool
    {
        // Admins can delete any message
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Staff can delete any message
        if ($user->hasRole('Staff')) {
            return true;
        }

        // Users can delete their own messages
        return $projectMessage->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectMessage $projectMessage): bool
    {
        // Only admins and staff can restore messages
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectMessage $projectMessage): bool
    {
        // Only admins can permanently delete messages
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can create internal messages.
     */
    public function createInternal(User $user, ProjectMessage $projectMessage): bool
    {
        // Only staff, admins, and team members can create internal messages
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Load the project relationship if not already loaded
        $projectMessage->loadMissing('project');

        return $projectMessage->project->team()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can mark message as AI draft.
     */
    public function markAsAiDraft(User $user): bool
    {
        // Only staff and admins can mark messages as AI drafts
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }
}

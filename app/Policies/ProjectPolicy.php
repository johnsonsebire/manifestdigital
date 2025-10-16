<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Staff and admins can view all projects
        // Team members can view their assigned projects (handled in controller queries)
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // Admins and staff can view all projects
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Client can view their own projects (client visibility or higher)
        if ($project->client_id === $user->id && in_array($project->visibility, ['client', 'public'])) {
            return true;
        }

        // Team members can view projects they're assigned to
        return $project->team()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only staff and admins can create projects
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Admins can update any project
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Staff can update projects
        if ($user->hasRole('Staff')) {
            return true;
        }

        // Project managers can update their assigned projects
        return $project->team()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'manager')
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        // Only admins can delete projects
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        // Only admins can restore projects
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        // Only admins can permanently delete projects
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can manage team members.
     */
    public function manageTeam(User $user, Project $project): bool
    {
        // Admins and staff can manage team members
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Project managers can manage their project's team
        return $project->team()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'manager')
            ->exists();
    }

    /**
     * Determine whether the user can change project visibility.
     */
    public function changeVisibility(User $user, Project $project): bool
    {
        // Only admins and staff can change project visibility
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view internal content.
     */
    public function viewInternalContent(User $user, Project $project): bool
    {
        // Admins, staff, and team members can view internal content
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Team members can view internal content
        return $project->team()->where('user_id', $user->id)->exists();
    }
}

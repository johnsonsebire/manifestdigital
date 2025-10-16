<?php

namespace App\Policies;

use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectFilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Staff and admins can view all files
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectFile $projectFile): bool
    {
        // Admins and staff can view all files
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Load the model relationship to determine context
        $projectFile->loadMissing('model');

        // If attached to a project, check project access
        if ($projectFile->model_type === 'App\Models\Project') {
            return $user->can('view', $projectFile->model);
        }

        // If attached to a task, check task access
        if ($projectFile->model_type === 'App\Models\Task') {
            return $user->can('view', $projectFile->model);
        }

        // If attached to a message, check message access
        if ($projectFile->model_type === 'App\Models\ProjectMessage') {
            return $user->can('view', $projectFile->model);
        }

        // Default deny
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can upload files (context access checked in controller)
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectFile $projectFile): bool
    {
        // Admins can update any file metadata
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Staff can update any file metadata
        if ($user->hasRole('Staff')) {
            return true;
        }

        // Users can update their own uploaded files
        return $projectFile->uploaded_by === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectFile $projectFile): bool
    {
        // Admins can delete any file
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Staff can delete any file
        if ($user->hasRole('Staff')) {
            return true;
        }

        // Users can delete their own uploaded files
        return $projectFile->uploaded_by === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectFile $projectFile): bool
    {
        // Only admins and staff can restore files
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectFile $projectFile): bool
    {
        // Only admins can permanently delete files
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can download the file.
     */
    public function download(User $user, ProjectFile $projectFile): bool
    {
        // If they can view it, they can download it
        return $this->view($user, $projectFile);
    }
}

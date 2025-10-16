<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone can view categories (including guests)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Category $category): bool
    {
        // Staff and admins can view all categories
        if ($user && $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Public can only view visible categories
        return $category->is_visible;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only staff and admins can create categories
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        // Only staff and admins can update categories
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        // Only admins can delete categories
        // Also check if category has no children or services
        if (!$user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return false;
        }

        // Cannot delete if it has children
        if ($category->children()->count() > 0) {
            return false;
        }

        // Cannot delete if it has services
        if ($category->services()->count() > 0) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        // Only admins can restore categories
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        // Only admins can permanently delete categories
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can reorder categories.
     */
    public function reorder(User $user): bool
    {
        // Only staff and admins can reorder categories
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }
}

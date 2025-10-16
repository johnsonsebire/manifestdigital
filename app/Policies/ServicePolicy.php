<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
        /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only staff and admins can view all services (including unlisted)
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Service $service): bool
    {
        // Staff and admins can view all services (including unlisted)
        if ($user && $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Public can only view services that are both visible and available
        return $service->is_visible && $service->is_available;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only staff and admins can create services
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        // Only staff and admins can update services
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        // Only admins can delete services
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        // Only admins can restore services
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        // Only admins can permanently delete services
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can manage service variants.
     */
    public function manageVariants(User $user, Service $service): bool
    {
        // Only staff and admins can manage variants
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view price history.
     */
    public function viewPriceHistory(User $user, Service $service): bool
    {
        // Only staff and admins can view price history
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }
}

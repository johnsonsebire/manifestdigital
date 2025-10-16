<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Staff and admins can view all orders
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        // Staff and admins can view any order
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Customers can only view their own orders
        return $order->customer_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create orders
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        // Staff and admins can update any order
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Customers can only update their pending orders
        return $order->customer_id === $user->id && $order->status === 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        // Only admins can delete orders
        if ($user->hasAnyRole(['Administrator', 'Super Admin'])) {
            return true;
        }

        // Customers can only "delete" (cancel) their pending orders
        return $order->customer_id === $user->id && $order->status === 'pending';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        // Only admins can restore deleted orders
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        // Only admins can permanently delete orders
        return $user->hasAnyRole(['Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can approve change requests for the order.
     */
    public function approveChangeRequest(User $user, Order $order): bool
    {
        // Only staff and admins can approve change requests
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }

    /**
     * Determine whether the user can request changes to the order.
     */
    public function requestChanges(User $user, Order $order): bool
    {
        // Staff and admins can request changes to any order
        if ($user->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
            return true;
        }

        // Customers can request changes to their own paid/processing orders
        return $order->customer_id === $user->id 
            && in_array($order->status, ['paid', 'processing']);
    }

    /**
     * Determine whether the user can mark the order as paid.
     */
    public function markAsPaid(User $user, Order $order): bool
    {
        // Only staff and admins can manually mark orders as paid
        return $user->hasAnyRole(['Staff', 'Administrator', 'Super Admin']);
    }
}

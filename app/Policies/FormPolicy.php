<?php

namespace App\Policies;

use App\Models\Form;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any forms.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-forms');
    }

    /**
     * Determine whether the user can view the form.
     */
    public function view(User $user, Form $form): bool
    {
        return $user->can('view-forms');
    }

    /**
     * Determine whether the user can create forms.
     */
    public function create(User $user): bool
    {
        return $user->can('create-forms');
    }

    /**
     * Determine whether the user can update the form.
     */
    public function update(User $user, Form $form): bool
    {
        return $user->can('edit-forms');
    }

    /**
     * Determine whether the user can delete the form.
     */
    public function delete(User $user, Form $form): bool
    {
        return $user->can('delete-forms');
    }

    /**
     * Determine whether the user can restore the form.
     */
    public function restore(User $user, Form $form): bool
    {
        return $user->can('edit-forms');
    }

    /**
     * Determine whether the user can permanently delete the form.
     */
    public function forceDelete(User $user, Form $form): bool
    {
        return $user->can('delete-forms');
    }
}
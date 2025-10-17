<?php

namespace App\Providers;

use App\Models\Form;
use App\Policies\FormPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Form::class => FormPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Order management permissions
        Gate::define('view-orders', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        Gate::define('manage-orders', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        // Form management permissions
        Gate::define('view-forms', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        Gate::define('create-forms', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        Gate::define('edit-forms', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        Gate::define('delete-forms', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('view-form-submissions', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        Gate::define('export-form-submissions', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        // Admin panel access
        Gate::define('access-admin-panel', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });
    }
}
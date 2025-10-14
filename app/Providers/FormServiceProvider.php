<?php

namespace App\Providers;

use App\Services\FormRenderer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FormRenderer::class, function ($app) {
            return new FormRenderer();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register a directive to include forms by ID
        Blade::directive('form', function ($expression) {
            return "<?php 
                \$formId = {$expression};
                \$form = \\App\\Models\\Form::with('fields')->find(\$formId);
                if (\$form && \$form->isActive()) {
                    echo app('" . FormRenderer::class . "')->renderForm(\$form);
                }
            ?>";
        });
        
        // Register Blade component for forms
        Blade::component('form', \App\View\Components\Form::class);
        
        // Add a content filter for shortcodes in the main content
        // Note: Form shortcode processing is now handled by ContentServiceProvider
    }
}

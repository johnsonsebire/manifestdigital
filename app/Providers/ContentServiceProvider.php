<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Services\FormRenderer;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FormRenderer::class, function ($app) {
            return new FormRenderer();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Process any text containing shortcodes - use this for inline shortcode processing
        Blade::directive('processShortcodes', function ($expression) {
            return "<?php 
                try {
                    echo app('" . FormRenderer::class . "')->processShortcodes($expression); 
                } catch (\\Exception \$e) {
                    echo '<div class=\"alert alert-danger\">Error processing shortcodes: ' . \$e->getMessage() . '</div>';
                }
            ?>";
        });
        
        // Register a simpler directive specifically for rendering forms by ID
        Blade::directive('renderForm', function ($expression) {
            return "<?php 
                try {
                    \$formId = $expression;
                    \$form = \\App\\Models\\Form::with('fields')->find(\$formId);
                    if (\$form && \$form->isActive()) {
                        echo view('forms.partials.form', ['form' => \$form])->render();
                    } else {
                        echo '<div class=\"alert alert-warning\">Form not found or inactive</div>';
                    }
                } catch (\\Exception \$e) {
                    echo '<div class=\"alert alert-danger\">Error: ' . \$e->getMessage() . '</div>';
                }
            ?>";
        });
        
        // Register the shortcode container component
        Blade::component('shortcode-container', \App\View\Components\ShortcodeContainer::class);
    }
}
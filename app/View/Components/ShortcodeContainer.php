<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Services\FormRenderer;

class ShortcodeContainer extends Component
{
    /**
     * The content to process.
     */
    public string $content;

    /**
     * Create a new component instance.
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.shortcode-container', [
            'processedContent' => app(FormRenderer::class)->processShortcodes($this->content),
        ]);
    }
}
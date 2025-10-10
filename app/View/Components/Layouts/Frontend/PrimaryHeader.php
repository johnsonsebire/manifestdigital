<?php

namespace App\View\Components\Layouts\Frontend;

use Illuminate\View\Component;

class PrimaryHeader extends Component
{
    public $transparent;
    public $showMegaMenu;
    public $showDropdown;
    public $navItems;
    public $notificationStyle;

    public function __construct(
        $transparent = true,
        bool $showMegaMenu = false,
        bool $showDropdown = false,
        string $notificationStyle = 'dark'
       
    ) {
        // Ensure transparent is properly converted to boolean
        // Handle both string ('false', 'true', '0', '1') and boolean values
        $this->transparent = match(true) {
            is_bool($transparent) => $transparent,
            is_string($transparent) => filter_var($transparent, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            default => (bool) $transparent
        };
        
        $this->showMegaMenu = $showMegaMenu;
        $this->showDropdown = $showDropdown;
        $this->notificationStyle = $notificationStyle;
        $this->navItems = [
            ['label' => 'Home', 'url' => '/', 'type' => 'link'],
            ['label' => 'Projects', 'url' => 'projects', 'type' => 'link'],
            ['label' => 'AI Sensei', 'url' => 'ai-sensei', 'type' => 'link'],
            ['label' => 'Services', 'type' => 'mega-menu'],
            ['label' => 'Company', 'type' => 'dropdown'],
            ['label' => 'Book a Call', 'url' => 'book-a-call', 'type' => 'link'],
        ];
    }

    public function render()
    {
        return view('components.layouts.frontend.primary-header');
    }
}
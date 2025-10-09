<?php

namespace App\View\Components\Layouts\Frontend;

use Illuminate\View\Component;

class PrimaryHeader extends Component
{
    public $transparent;
    public $showMegaMenu;
    public $showDropdown;
    public $navItems;

    public function __construct(
        bool $transparent = true,
        bool $showMegaMenu = false,
        bool $showDropdown = false,
        array $navItems = null
    ) {
        $this->transparent = $transparent;
        $this->showMegaMenu = $showMegaMenu;
        $this->showDropdown = $showDropdown;
        $this->navItems = $navItems ?? [
            ['label' => 'Home', 'url' => '/', 'type' => 'link'],
            ['label' => 'Projects', 'url' => 'projects', 'type' => 'link'],
            ['label' => 'AI Sensei', 'url' => 'ai-sensei-chat', 'type' => 'link'],
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
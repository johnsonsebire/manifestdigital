<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Frontend extends Component
{
    public $title;
    public $transparentHeader;

    public function __construct($title = null, $transparentHeader = false)
    {
        $this->title = $title;
        $this->transparentHeader = $transparentHeader;
    }

    public function render()
    {
        return view('components.layouts.frontend');
    }
}
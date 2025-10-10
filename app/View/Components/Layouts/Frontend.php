<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Frontend extends Component
{
    public $title;
    public $transparentHeader;
    public $preloader;

    public function __construct($title = null, $transparentHeader = false, $preloader='simple')
    {
        $this->title = $title;
        $this->transparentHeader = $transparentHeader;
        $this->preloader=$preloader;
    }

    public function render()
    {
        return view('components.layouts.frontend');
    }
}
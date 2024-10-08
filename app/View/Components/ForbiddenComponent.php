<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ForbiddenComponent extends Component
{
    private $title, $message;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $title = $this->title;
        $message = $this->message;
        return view('components.forbidden-component', compact('title', 'message'));
    }
}

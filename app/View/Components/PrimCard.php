<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PrimCard extends Component
{
    private $title, $subTitle, $price1, $price2, $icon;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $subTitle, $price1, $price2, $icon)
    {
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->price1 = $price1;
        $this->price2 = $price2;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $title = $this->title;
        $subTitle = $this->subTitle;
        $price1 = formatPrice($this->price1);
        $price2 = formatPrice($this->price2);
        $icon = $this->icon;
        return view('components.prim-card', compact('title', 'subTitle', 'price1', 'price2', 'icon'));
    }
}

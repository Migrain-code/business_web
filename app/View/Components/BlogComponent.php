<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BlogComponent extends Component
{
    public $image;
    public $link;
    public $categoryName;
    public $date;
    public $title;
    public $shortDescription;

    /**
     * Create a new component instance.
     */
    public function __construct($image, $link, $categoryName, $date, $title, $shortDescription)
    {
        $this->image = $image;
        $this->link = $link;
        $this->categoryName = $categoryName;
        $this->date = $date;
        $this->title = $title;
        $this->shortDescription = $shortDescription;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog-component');
    }
}

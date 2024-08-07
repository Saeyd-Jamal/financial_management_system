<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableViewLayout extends Component
{
    public $title;
    public $classC;
    /**
     * Create a new component instance.
     */
    public function __construct($title = null,$classC = null)
    {
        $this->title = $title ?? config('app.name');
        $this->classC = $classC ;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.table-view-layout');
    }
}

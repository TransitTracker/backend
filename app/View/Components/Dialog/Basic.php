<?php

namespace App\View\Components\Dialog;

use Illuminate\View\Component;

class Basic extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $showProp = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dialog.basic');
    }
}

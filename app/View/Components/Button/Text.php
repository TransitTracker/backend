<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class Text extends Component
{
    public function __construct(public bool $hasIcon)
    {
    }

    public function render()
    {
        return view('components.button.text');
    }
}

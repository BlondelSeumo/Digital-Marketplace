<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Partials extends Component
{
    public function render()
    {
        return theme_view('components.partials');
    }
}
